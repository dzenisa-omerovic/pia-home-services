<?php

namespace App\Responses;

use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        if ($user && $user->utype === 'SVP') {
            $sprovider = ServiceProvider::where('user_id', $user->id)->first();
            if ($sprovider && $sprovider->approval_status !== 'approved') {
                $status = $sprovider->approval_status === 'rejected' ? 'providerRejected' : 'providerApprovalPending';
                Auth::logout();
                return redirect()->route('login', ['status' => $status]);
            }
        }

        return redirect()->intended(Fortify::redirects('login'));
    }
}
