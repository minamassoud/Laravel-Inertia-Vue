<?php

namespace App\ValidationRules;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserRules
{
    // -----------------------------------------------------------------
    // PUBLIC METHODS for specific validation scenarios
    // -----------------------------------------------------------------

    public function forCreation(): array
    {
        return array_merge(
            $this->nameRules(),
            $this->emailRules(),
            $this->passwordRules()
        );
    }

    public function forDeletion(): array
    {
        return array_merge(
            $this->currentPasswordRules()
        );
    }

    private function nameRules(): array
    {
        return ['name' => ['required', 'string', 'max:255']];
    }

    private function emailRules(?User $user = null): array
    {
        $uniqueRule = Rule::unique('users', 'email');

        if ($user) {
            $uniqueRule->ignore($user->id);
        }

        return ['email' => ['required', 'string', 'email', 'max:255', $uniqueRule]];
    }

    private function passwordRules(): array
    {
        return ['password' => ['required', 'string', PasswordRule::min(8), 'confirmed']];
    }


    // -----------------------------------------------------------------
    // PRIVATE HELPER METHODS for individual field rules (The DRY part)
    // -----------------------------------------------------------------

    public function forProfileUpdate(User $user): array
    {
        return array_merge(
            $this->nameRules(),
            $this->emailRules($user)
        );
    }

    public function forPasswordUpdate(): array
    {
        return array_merge(
            $this->currentPasswordRules(),
            $this->passwordRules()
        );
    }

    private function currentPasswordRules(): array
    {
        // 'current_password' is a built-in Laravel rule to check against the authenticated user's hash.
        return ['current_password' => ['required', 'string', 'current_password']];
    }

    public function forAuthentication(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember_me' => ['boolean']
        ];
    }
}
