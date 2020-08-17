<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends BaseController
{
    public function __construct()
    {
        $this->classe = Todo::class;
    }
    
    public function checklists(Request $request){
        $checklsits = Todo::find($request->id)->checklists;
        if(is_null($checklsits)){
            return response()->json('Lista não encontrada', 404);
        }
        return response()->json($checklsits, 200);
    }

    public function lastTodos(Request $request){
        $todoList = Todo::where('user_id', $request->user_id)->take($request->quant)->get();
        if(is_null($todoList)){
            return response()->json('Sem dados', 201);
        }
        return response()->json($todoList, 200);
    }
}
