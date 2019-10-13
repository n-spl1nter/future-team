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
        $user = User::findOrCreateViaNetworkService($serviceName, $attributes);
        if ($user->hasVerifiedEmail()) {
            $token = $user->makeToken();
            return view('auth-success', compact('token'));
        }

        return view('auth-success', [
            'email' => $user->email,
            'error' => 'not verified',
        ]);
    }
}
