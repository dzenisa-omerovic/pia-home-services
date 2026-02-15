<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureContactAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()
                ->guest(route('login', ['status' => 'contactLoginRequired']))
                ->with('toast', [
                    'type' => 'warning',
                    'message' => 'Morate biti ulogovani da biste pristupili stranici Contact us.',
                ]);
        }

        if (!in_array(Auth::user()->utype, ['CST', 'SVP'], true)) {
            return redirect()
                ->route('home')
                ->with('toast', [
                    'type' => 'warning',
                    'message' => 'Contact Us je dostupan samo customer i service provider nalozima.',
                ]);
        }

        return $next($request);
    }
}
