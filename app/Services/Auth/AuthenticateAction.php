<?php

namespace App\Services\Auth;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthenticateAction
{

    public function login(array $data): bool
    {
        if (Auth::viaRemember()) {
            return true;
        }

        return Auth::attempt(
            Arr::except($data, 'remember_me'),
            $data['remember_me']
        );
    }


}
