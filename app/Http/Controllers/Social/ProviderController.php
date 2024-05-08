<?php

namespace App\Http\Controllers\Social;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    //
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        $SocialUser = Socialite::driver($provider)->user();
        // dd($user);

        $user = User::updateOrCreate([
            'provider_id' => $SocialUser->id,
            'provider' => $provider,

        ], [
            'name' => $SocialUser->name,
            'username' => $SocialUser->nickname,
            'email' => $SocialUser->email,
            'provider_token' => $SocialUser->token,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
