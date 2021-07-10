<?php

namespace App\Http\Middleware;

use App\Xero\Storage;
use Closure;

class IsXeroTokenHasExpired
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
        $storage = new Storage();
        if ($storage->getHasExpired()) {
            return redirect()->route('xero.index');
        }
        return $next($request);
    }
}
