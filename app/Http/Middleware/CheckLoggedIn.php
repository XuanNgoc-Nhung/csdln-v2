<?php
/**
 * Created by PhpStorm.
 * User: duongnv
 * Date: 2/22/2019
 * Time: 3:45 PM
 */

namespace App\Http\Middleware;

use Closure;

class CheckLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $login = session('isLoggedIn', false);
        if (!$login) {
            return redirect(url("/"));
        }
        $ajax = $request->ajax();
        if (!$ajax) {
            $path = $request->path();
            if (!check_access_path($path)) {
//                dd("check access false");
                return redirect()->back()->with('status', "You can not access to this page !!!");
            }
        }
        return $next($request);
    }
}
