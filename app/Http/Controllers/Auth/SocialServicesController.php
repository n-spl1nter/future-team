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
            } elseif ($serviceName == 'vkontakte') {
                $serviceUser->user['email'] = $serviceUser->accessTokenResponseBody['email'];
            }
            $attributes = [
                'first_name' => $serviceUser->user['first_name'],
                'last_name' => $serviceUser->user['last_name'],
                'email' => $serviceUser->user['email'],
                'token' => $serviceUser->token,
                'identity' => $serviceUser->id,
            ];
            if (isset($serviceUser->user['email']) && User::whereEmail($serviceUser->user['email'])->count() == 0) {
                $attributes['email'] = $serviceUser->user['email'];
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
            'emailVerified' => $emailVerified,
            'hasProfile' => $hasProfile,
        ]);
    }
}
