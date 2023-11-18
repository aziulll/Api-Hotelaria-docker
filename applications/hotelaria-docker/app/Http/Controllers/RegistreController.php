<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistreController extends Controller
{
    public function criarCliente(Request $request)
    {
   
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:users',
            'senha' => 'required|min:8',
            'telefone' => 'required'
        ]);

       
        User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha), 
            'telefone' => $request->telefone
        ]);

        return response()->json(['message'=> 'Usuário criado com sucesso']);
    }
}
