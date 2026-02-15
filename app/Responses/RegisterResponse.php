<?php

namespace App\Responses;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        if ($user && $user->utype === 'SVP') {
            $sprovider = ServiceProvider::where('user_id', $user->id)->first();
            $status = ($sprovider && $sprovider->approval_status === 'rejected') ? 'providerRejected' : 'providerApprovalPending';
            Auth::logout();
            return redirect()->route('login', ['status' => $status]);
        }

        return redirect()->intended(Fortify::redirects('register'));
    }
}
