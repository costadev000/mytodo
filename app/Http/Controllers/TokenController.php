<?php
namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Log;

class TokenController extends Controller
{
    public function gerarToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if(is_null($user) ){
            return response()->json('Usuário ou Senha Inválidos', 401);
        }else{
            try {
                $pass = Crypt::decrypt($user->password);
            } catch (DecryptException $e) {
                //
            }
            if($pass != $request->password){
                return response()->json('Senha Inválida', 401);
            }
        }
        $token = JWT::encode(
            [
                'user_id' => $user->id,
                'exp' => time() + 60*60,
                'orig_iat' => time()
            ],
            env('JWT_KEY'));

        return [
            'access_token' => $token,
            'user' => [
                'email'  => $user->email,
                'name'   => $user->name,
                'id'     => $user->id,
                'status' => $user->status
            ]
        ];
    }

    public function refreshToken(Request $request){
        try{
            $user = User::where('id', $request->id)->first();
            if(is_null($user)){
                throw new \Exception();
            }
            $dadosAutenticacao = JWT::decode($request->token, env('JWT_KEY'), ['HS256']);
            return [
                'access_token' => $request->token,
                'user' => [
                    'email'  => $user->email,
                    'name'   => $user->name,
                    'id'     => $user->id,
                    'status' => $user->status
                ]
            ];
        }catch(\Firebase\JWT\ExpiredException $e){
            $user = User::where('id', $request->id)->first();
            if(is_null($user)){
                throw new \Exception();
            }
            $newToken = JWT::encode(
                ['user_id' => $request->id, 'exp' => time() + 1440*60, 'orig_iat' => time()],
                env('JWT_KEY'));
            return [
                'access_token' => $newToken,
                'user' => [
                    'email'  => $user->email,
                    'name'   => $user->name,
                    'id'     => $user->id,
                    'status' => $user->status
                ]
            ];
        }catch(\Exception $e)   {
            return response()->json('Faça o Login novamente! '.$e, 401);
        }
    }
}
