<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHandler {

    /**
     * Adds essential security headers to the HTTP responses. To prevent XSS attacks and so on
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        $response->header("X-XSS-Protection", "1; mode=block");
        $response->header("X-Frame-Options", "SAMEORIGIN");
        $response->header("X-Content-Type-Options", "nosniff");
        $response->header("Strict-Transport-Security", "max-age=31536000");

        return $response;
    }
}
