<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistroController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(7)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $registros = Registro::whereBetween('fecha_hora', [$startDate, $endDate])->orderBy('fecha_hora')->get();
    
        $dataDiferencia = [];
    
        foreach ($registros as $registro) {
            $interpretacion = $this->interpretarMensaje($registro->mensaje_enviado);
            $fecha = $registro->fecha_hora;
    
            if (!isset($dataDiferencia[$fecha])) {
                $dataDiferencia[$fecha] = ['fecha' => $fecha, 'diferencia' => 0];
            }
    
            $dataDiferencia[$fecha]['diferencia'] += $interpretacion;
        }
    
        return view('grafica', [
            'dataDiferencia' => array_values($dataDiferencia),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    
    private function interpretarMensaje($mensaje)
    {
        if ($mensaje == 'Positivo') {
            return 1;
        } elseif ($mensaje == 'Negativo') {
            return -1;
        } else {
            return 0;
        }
    }
}
