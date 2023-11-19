<?php

namespace App\Http\Controllers;

use App\Models\Quarto;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller


{

    /* Metodo para criar as reservas, para que retorne valores reais nos testes manuais 
    */
    public function criarReserva(Request $request)
{
    $request->validate([
        'data_checkin' => 'required|date',
        'data_checkout' => 'required|date',
        'quarto_id' => 'required',
    ]);

    $quarto = Quarto::find($request->quarto_id);

    if (!$quarto) {
        return response()->json(['message' => 'Quarto não encontrado'], 404);
    }

   
    if ($quarto->disponivel) {
        // Marcar o quarto como indisponível
        $quarto->marcarComoIndisponivel();

    
        $reserva = Reserva::create([
            'data_checkin' => $request->data_checkin,
            'data_checkout' => $request->data_checkout,
            'quarto_id' => $request->quarto_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Reserva criada com sucesso'], 201);
    } else {
        return response()->json(['message' => 'Quarto indisponível'], 422);
    }
}



    /* Metodo para buscar as reservas por cliente
    */
    public function reservasDoCliente($userId)
    {
        try {

            $cliente = User::findOrFail($userId);


            $reservasDoCliente = $cliente->reservas;


            return response()->json(['reservas_do_cliente' => $reservasDoCliente], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
    }


    
    /* Metodo para buscar os quartos ocupados por data. Criado um estrutura de filtro com data final e inicial 
    */

    public function ocupadosPorData(Request $request)
    {
        try {
            $dataInicial = $this->validateAndFormatDate($request->input('data_inicial'));
            $dataFinal = $this->validateAndFormatDate($request->input('data_final'));

            $quartosIndisponiveis = Quarto::whereHas('reservas', function ($query) use ($dataInicial, $dataFinal) {
                $query->where(function ($q) use ($dataInicial, $dataFinal) {
                    $q->whereDate('data_checkin', '<=', $dataFinal)
                        ->whereDate('data_checkout', '>=', $dataInicial);
                });
            })->get();

            $countQuartosIndisponiveis = $quartosIndisponiveis->count();

            

            if ($countQuartosIndisponiveis > 0) {
                return response()->json(['quartos_ocupados_data' => $quartosIndisponiveis]);
            } else {
                return response()->json(["Todos os quartos estão disponíveis nessa data"]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /** 
     * Esse metodo é responsavel por formatar e validar o formato das datas enviadas atraves dos testes.
     * Sinaliza caso o formato não esteja em y-m-d
    */
    private function validateAndFormatDate($date)
    {

        $dateFormat = 'Y-m-d';


        $parsedDate = \DateTime::createFromFormat($dateFormat, $date);


        if (!$parsedDate) {
            throw new \Exception("Formato de data inválido. Use o formato $dateFormat.");
        }


        return $parsedDate->format($dateFormat);
    }
}
