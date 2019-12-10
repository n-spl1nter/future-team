<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialServicesController extends Controller
{
    public function providerRedirect(string $serviceName)
    {
        return \Socialite::driver($serviceName)
            ->scopes(config("services.$serviceName.scopes"))
            ->redirect();
    }

    public function providerCallBack(string $serviceName)
    {
        $accessToken = null;
        $id = null;
        $emailVerified = null;
        $hasProfile = null;
        try {
            $serviceUser = \Socialite::driver($serviceName)->stateless()->user();
            if ($serviceName == 'facebook') {
                $nameParts = explode(' ', $serviceUser->user['name']);
                $serviceUser->user['first_name'] = array_shift($nameParts);
                $serviceUser->user['last_name'] = implode(' ', $nameParts);
            }
            $attributes = [
                'first_name' => $serviceUser->user['first_name'],
                'last_name' => $serviceUser->user['last_name'],
                'email' => null,
                'token' => $serviceUser->token,
                'identity' => $serviceUser->id,
            ];
            $email = null;
            if (isset($serviceUser->user) && isset($serviceUser->user['email'])) {
                $email = $serviceUser->user['email'];
            } elseif (isset($serviceUser->accessTokenResponseBody) && isset($serviceUser->accessTokenResponseBody['email'])) {
                $email = $serviceUser->accessTokenResponseBody['email'];
            }
            if ($email && User::whereEmail($email)->count() == 0) {
                $attributes['email'] = $email;
                $attributes['email_verified_at'] = now();
            }
            $user = User::findOrCreateViaNetworkService($serviceName, $attributes);
            $accessToken = $user->makeToken()->accessToken;
            $id = $user->id;
            $emailVerified = $user->hasVerifiedEmail();
            $hasProfile = $user->hasFilledProfile();
        } catch (\Throwable $exception) {
            \Log::error($exception->getMessage());
        }

        return view('auth-success', [
            'accessToken' => $accessToken,
            'id' => $id,
            'hasProfile' => $hasProfile,
        ]);
    }
}
