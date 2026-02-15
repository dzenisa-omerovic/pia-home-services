<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ServiceProvider;

class AuthSprovider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->utype === 'SVP')
        {
            $sprovider = ServiceProvider::where('user_id', Auth::id())->first();
            if ($sprovider && $sprovider->approval_status === 'approved') {
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('login', ['status' => $sprovider && $sprovider->approval_status === 'rejected' ? 'providerRejected' : 'providerApprovalPending']);
        }
        else
        {
            session()->flush();
            return redirect()->route('login');
        }
    }
}
