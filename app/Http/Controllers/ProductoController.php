<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getBarChartData($request->input('from'), $request->input('to'));
        return view('producto', $data);
    }

    public function getBarChartData($start_date = null, $end_date = null)
    {
        $query = DB::table('producto')
            ->select('producto', DB::raw('COUNT(*) as total_repeticiones'))
            ->groupBy('producto')
            ->orderByDesc('total_repeticiones');

        if ($start_date && $end_date) {
            $query->whereBetween('fecha_hora', [$start_date, $end_date]);
        }

        $productosMasRepetidos = $query->take(3)->get();

        $productos = [];
        $repeticiones = [];

        foreach ($productosMasRepetidos as $producto) {
            $productos[] = $producto->producto;
            $repeticiones[] = $producto->total_repeticiones;
        }

        return ['productos' => $productos, 'repeticiones' => $repeticiones];
    }
}
