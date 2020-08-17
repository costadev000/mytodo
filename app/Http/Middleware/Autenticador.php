<?php
namespace App\Http\Middleware;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class Autenticador
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            
            if (!$request->hasHeader('Authorization')) {
                throw new \Exception();
            }
            $authorizationHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            try{
                $dadosAutenticacao = JWT::decode($token, env('JWT_KEY'), ['HS256']);
            }catch(\Firebase\JWT\ExpiredException $e){
                return response()->json('Token Expirado ', 401);
            }
            
            $user = User::where('id', $dadosAutenticacao->user_id)
                ->first();
            if (is_null($user)) {
                throw new \Exception();
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json('Não Autorizado', 401);
        }
    }
}