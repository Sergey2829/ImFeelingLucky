<?php

namespace App\Http\Middleware;

use App\Models\Link;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->get('signature');
        if (!$signature) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }

        return Link::query()->where('signature', $signature)->valid()->exists() ?
            $next($request) :
            abort(Response::HTTP_UNAUTHORIZED);

    }
}
