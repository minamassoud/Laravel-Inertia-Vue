<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
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
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', PasswordRule::min(8), 'confirmed'],
        ]);

        $validated = $validator->validate();

        // Password is auto-hashed by the User model cast
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        // Log the user in
        Auth::guard()->login($user);

        return $user;
    }
}
