<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(Auth::user()->id);
        if (Auth::check()) {
            if ($user->Status == "active") {
                return $next($request);
            }
        }
        return redirect()->to('/')->with(['active_user' => 'you are not active User']);
    }
}
