<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterFinansial;
use Carbon\Carbon;

class ParameterFinansialController extends Controller
{
    public function index(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', Carbon::now()->format('Y-m'));
        
        $parameter = ParameterFinansial::where('bulan_tahun', $bulan_tahun)->first();
        
        // If not found, use default 0
        $target_minimal = $parameter ? $parameter->target_minimal : 0;
        $hpp_per_bulan = $parameter ? $parameter->hpp_per_bulan : 0;

        return view('finance.parameter-finansial', compact('bulan_tahun', 'target_minimal', 'hpp_per_bulan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bulan_tahun' => 'required|date_format:Y-m',
            'target_minimal' => 'required|numeric|min:0',
            'hpp_per_bulan' => 'required|numeric|min:0'
        ]);

        ParameterFinansial::updateOrCreate(
            ['bulan_tahun' => $request->bulan_tahun],
            [
                'target_minimal' => $request->target_minimal,
                'hpp_per_bulan' => $request->hpp_per_bulan
            ]
        );

        return redirect()->route('parameter-finansial.index', ['bulan_tahun' => $request->bulan_tahun])
            ->with('success', 'Parameter Finansial berhasil disimpan!');
    }
}
