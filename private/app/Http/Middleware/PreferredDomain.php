<?php

namespace App\Http\Middleware;

use App\Http\Domain;
use Closure;

/**
 * Class PreferredDomain
 * @package App\Http\Middleware
 */
class PreferredDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = new Domain($request);

        if ($domain->diff()) {
            return redirect()->to($domain->translated(), config('app.debug') == true ? 302 : 301);
        }

        return $next($request);
    }
}