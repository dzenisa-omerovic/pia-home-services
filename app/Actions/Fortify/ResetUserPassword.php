<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\PasswordHistoryService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        $historyCount = PasswordHistoryService::getHistoryCount();

        $validator = Validator::make($input, [
            'password' => $this->passwordRules(),
        ]);

        $validator->after(function ($validator) use ($user, $input, $historyCount) {
            if (PasswordHistoryService::isPasswordReused($user, $input['password'], $historyCount)) {
                $validator->errors()->add(
                    'password',
                    __('New password must be different from your last :count passwords.', ['count' => $historyCount])
                );
            }
        });

        $validator->validate();

        PasswordHistoryService::storeCurrentPassword($user);
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
