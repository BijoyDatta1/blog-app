<?php

namespace App\Http\Middleware;

use App\helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->cookie('token')) {
            $token = $request->cookie('token');
            $result = JWTToken::VerifyToken($token);
            if ($result === "Unauthorize") {
                return redirect("/loginpage");
            }else{
                $request->headers->set('email', $result->email);
                $request->headers->set('id', $result->userId);
                return $next($request);
            }
        }else{
            return redirect("/loginpage");
        }
    }
}
