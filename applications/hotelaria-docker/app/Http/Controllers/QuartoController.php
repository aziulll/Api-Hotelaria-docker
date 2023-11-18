<?php

namespace App\Http\Controllers;

use App\Models\Quarto;
use Illuminate\Http\Request;

class QuartoController extends Controller
{
    public function criarQuarto(Request $request)
    {

        $request->validate([
            'numero' => 'required|string',
            'capacidade' => 'required|integer',
            'preco_diaria' => 'required|numeric',

        ]);


        $quarto = Quarto::create([
            'numero' => $request->input('numero'),
            'capacidade' => $request->input('capacidade'),
            'preco_diaria' => $request->input('preco_diaria'),
            'disponivel' => true,
        ]);


        return response()->json(['message' => 'Quarto criado com sucesso', 'data' => $quarto], 201);
    }

    public function listarDisponiveis()
    {


        $quartosDisponiveis = Quarto::where('disponivel', true)->get();


        if ($quartosDisponiveis->isEmpty()) {
            return response()->json(['message' => 'Nenhum quarto cadastrado '], 404);
        }
        return response()->json($quartosDisponiveis);
    }


}
