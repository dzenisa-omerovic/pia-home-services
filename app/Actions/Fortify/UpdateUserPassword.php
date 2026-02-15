<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\PasswordHistoryService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        $historyCount = PasswordHistoryService::getHistoryCount();

        $validator = Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ]);

        $validator->after(function ($validator) use ($user, $input, $historyCount) {
            if (PasswordHistoryService::isPasswordReused($user, $input['password'], $historyCount)) {
                $validator->errors()->add(
                    'password',
                    __('New password must be different from your last :count passwords.', ['count' => $historyCount])
                );
            }
        });

        $validator->validateWithBag('updatePassword');

        PasswordHistoryService::storeCurrentPassword($user);
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
