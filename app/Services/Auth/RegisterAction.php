<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterAction
{
    public function __construct()
    {

    }

    /**
     * Handle user registration using form data from Register.vue
     *
     * @param  array{name:string,email:string,password:string,password_confirmation:string}  $data
     * @throws ValidationException
     */
    public function handle(array $data): User
    {
        // Password is auto-hashed by the User model cast
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        event(new Registered($user));

        // Log the user in
        Auth::guard()->login($user);

        return $user;
    }
}
