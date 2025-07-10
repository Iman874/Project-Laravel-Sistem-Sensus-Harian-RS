<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelRS;

class ModelRSController extends Controller
{
    public function index()
    {
        return view('content.grafik.modelrs-grafik');
    }

    // Get data from database 1
    public function getTableData()
    {
        $data = ModelRS::orderBy('tanggal')->get();

        return response()->json($data);
    }

    /* Get data from database 2
    public function getChartData()
    {
        $data = ModelRS::orderBy('tanggal')->get();

        return response()->json([
            'labels' => $data->pluck('tanggal'),
            'BOR' => $data->pluck('BOR'),
            'LOS' => $data->pluck('LOS'),
            'TOI' => $data->pluck('TOI'),
            'BTO' => $data->pluck('BTO'),
            'BOR_min' => array_fill(0, $data->count(), 60), // Garis BOR min 60%
            'BOR_max' => array_fill(0, $data->count(), 85), // Garis BOR max 85%
            'TOI_max' => array_fill(0, $data->count(), 3) // TOI max 3 hari
        ]);
    }*/

    // Get data from database 3
    public function getChartData()
{
    $data = ModelRS::orderBy('tanggal')->get();

    return response()->json([
        'labels' => $data->pluck('tanggal'),
        'BOR' => $data->pluck('BOR'),
        'LOS' => $data->pluck('LOS'),
        'TOI' => $data->pluck('TOI'),
        'BTO' => $data->pluck('BTO'),
        // Garis batas efisiensi
        'BOR_min' => array_fill(0, $data->count(), 60), // Minimal 60%
        'BOR_max' => array_fill(0, $data->count(), 85), // Maksimal 85%
        'LOS_min' => array_fill(0, $data->count(), 6), // Minimal 6 hari
        'LOS_max' => array_fill(0, $data->count(), 9), // Maksimal 9 hari
        'TOI_max' => array_fill(0, $data->count(), 3), // Maksimal 3 hari
        'BTO_min' => array_fill(0, $data->count(), 40), // Minimal 40 kali
        'BTO_max' => array_fill(0, $data->count(), 50)  // Maksimal 50 kali
    ]);
}


}
