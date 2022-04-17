<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        if (!$request->user()->can($permission)) {
            if ($permission == 'admin.authenticate') {
                return redirect()->route('login');
            } else {
                return redirect()
                    ->route('admin.dashboard.index')
                    ->with('error', '
                        <strong class="font-red-thunderbird">Bu işlemi yapmaya veya ilgili sayfayı görüntülemeye yetkiniz yok!</strong> <br>
                        Bu yüzden yönetim paneli ana sayfasına yönlendirildiniz.
                    ');
            }
        }

        return $next($request);
    }
}
