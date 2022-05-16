<?php

namespace App\Http\Middleware;

use App\Traits\ResponseApi;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class JwtMiddleware
{
    use ResponseApi;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->responseError(Response::HTTP_BAD_REQUEST, 'Token is Expired', 'Please login again');
        } catch (TokenInvalidException $e) {
            return $this->responseError(Response::HTTP_BAD_REQUEST, 'Token is Invalid', null);
        } catch (JWTException $e) {
            return $this->responseError(Response::HTTP_BAD_REQUEST, 'Authorization Token not found', null);
        }
        return $next($request);
    }
}
