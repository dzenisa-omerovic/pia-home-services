<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordHistoryService
{
    public static function getHistoryCount(): int
    {
        $default = (int)config('security.password_history_count', 5);
        $value = AppSetting::getInt('password_history_count', $default);
        return max(1, $value);
    }

    public static function isPasswordReused(User $user, string $plainPassword, ?int $historyCount = null): bool
    {
        $historyCount = $historyCount ?? static::getHistoryCount();

        if (Hash::check($plainPassword, $user->password)) {
            return true;
        }

        $previousCount = max(0, $historyCount - 1);
        if ($previousCount === 0) {
            return false;
        }

        $recent = PasswordHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($previousCount)
            ->pluck('password');

        foreach ($recent as $hashed) {
            if (Hash::check($plainPassword, $hashed)) {
                return true;
            }
        }

        return false;
    }

    public static function storeCurrentPassword(User $user): void
    {
        $latest = PasswordHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->value('password');

        if ($latest && hash_equals($latest, $user->password)) {
            return;
        }

        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $user->password,
        ]);
    }
}
