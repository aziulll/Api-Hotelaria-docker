<?php

namespace App\Http\Controllers;

use App\Models\Quarto;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller


{
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



            $quarto = Reserva::create([
                'data_checkin' => $request->data_checkin,
                'data_checkout' => $request->data_checkout,
                'quarto_id' => $request->quarto_id,
                'user_id' => Auth::id(),
            ]);       


            return response()->json(['message' => 'Reserva criado com sucesso'], 201);
        }

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


//     public function ocupadosPorData(Request $request)
//     {

//         try {
//         $dataInicial = $request->input('data_inicial');
//         $dataFinal = $request->input('data_final');

//         $quartosIndisponiveis = Quarto::whereHas('reservas', function ($query) use ($dataInicial, $dataFinal) {
//             $query->where(function ($q) use ($dataInicial, $dataFinal) {
//                 $q->whereDate('data_checkin', '<=', $dataFinal)
//                     ->whereDate('data_checkout', '>=', $dataInicial);
//             });
//         })
//             ->get();

//         $countQuartosIndisponiveis = $quartosIndisponiveis->count();

//         if ($countQuartosIndisponiveis > 0) {
//             return response()->json($quartosIndisponiveis);
//         } else {
//             return response()->json(["Todos os quartos estão disponíveis nessa data"]);
//         }
//     }
//     catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }


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
            return response()->json($quartosIndisponiveis);
        } else {
            return response()->json(["Todos os quartos estão disponíveis nessa data"]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

private function validateAndFormatDate($date)
{
    // Adapte este formato de acordo com o que você espera da entrada do usuário
    $dateFormat = 'Y-m-d';

   
    $parsedDate = \DateTime::createFromFormat($dateFormat, $date);

   
    if (!$parsedDate) {
        throw new \Exception("Formato de data inválido. Use o formato $dateFormat.");
    }

    
    return $parsedDate->format($dateFormat);
}
}