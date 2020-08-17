<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\User;

class UserController extends Controller
{

    public function newUser(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'status' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if(is_null($user)){
            $user = new User();
            $user->fill([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Crypt::encrypt($request->input('password')),
                'status' => $request->input('status')
            ])->save();
            return response()->json('Usuário Criado com Sucesso!', 201);
        }else{
            return response()->json('Usuário já Existe', 400);
        }

    }

    public function show(Request $request){
        $user = User::where('id', $request->id)->first();
        if(is_null($user)){
            return response()->json('Usuario não Autenticado', 401);
        }
        return response()->json($user, 200);
    }

    public function update(Request $request){
        $user = User::where('id', $quest->id)->first();
        $user->fill($request->all());
        $user->save();
        if(is_null($user)){
            return response()->json('Usuário não autenticado', 404);
        }
        return $user;
    }

    public function todos(Request $request){
        $user = User::where('id', $request->id)->with('todos')->first();
        if(is_null($user)){
            return response()->json('Usuário não encontrado', 400);
        }
        return response()->json($user, 200);
    }
}
