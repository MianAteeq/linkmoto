<?php

namespace App\Http\Middleware;

use App\Models\AgreementAcceptance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Vender\Entities\VenderService;

class Vender
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | Allowed routes (prevent redirect loops)
    |--------------------------------------------------------------------------
    */

    if (
        $request->routeIs('vender.agreements') ||
        $request->routeIs('vender.agreements.submit')
    ) {
        return $next($request);
    }

    /*
    |--------------------------------------------------------------------------
    | Restricted statuses
    |--------------------------------------------------------------------------
    */

    $restrictedStatuses = [
        'PENDING',
        'Request for Info',
        'DECLINE',
        'IN_REVIEW',
    ];

    if (
        $user->status === 'ACCEPTED' &&
        in_array($user->application_status, $restrictedStatuses)
    ) {
        return redirect()->route('vender.profiles');
    }

    /*
    |--------------------------------------------------------------------------
    | Agreements check
    |--------------------------------------------------------------------------
    */

    if ($user->vender_id != 0) {
        
        $accepted = AgreementAcceptance::where('user_id', $user->id)
        ->pluck('agreement_type')
        ->toArray();
        
        $hasTerms = in_array('TERMS', $accepted);
        $hasPrivacy = in_array('PRIVACY', $accepted);
        
        
        if (!$hasTerms || !$hasPrivacy) {
          

            if (!$request->routeIs('vender.agreements')) {
                return redirect()->route('vender.agreements');
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Accepted users
    |--------------------------------------------------------------------------
    */

    if ($user->application_status === 'ACCEPTED') {

        if (!$request->routeIs('vender.index')) {
            return redirect()->route('vender.index');
        }

        return $next($request);
    }

    /*
    |--------------------------------------------------------------------------
    | Default fallback
    |--------------------------------------------------------------------------
    */

    return redirect()->route('vender.profiles');
}
}
