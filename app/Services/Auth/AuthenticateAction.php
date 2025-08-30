<?php

namespace App\Services\Auth;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateAction
{

    public function login(array $data): bool
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string']
        ]);

        $validated = $validator->validate();
        $remember = (bool) Arr::get($data, 'remember_me');

        if (Auth::viaRemember()) {
            return true;
        }

        return Auth::attempt($validated, $remember);
    }


}
