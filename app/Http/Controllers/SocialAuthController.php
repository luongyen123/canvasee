<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Socialite;
use App\User;

class SocialAuthController extends Controller
{
    public function redirect($service) {
        return Socialite::driver ( $service )->redirect ();
    }

    public function callback($service) {
        $user = Socialite::with ( $service )->user ();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
     
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }


}
