<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentCreatorController extends Controller
{
    public function index()
    {
        // Data Dummy (Bisa diganti dengan data dari database saat beroperasi penuh)
        $kpi = \App\Models\ContentKpi::latest()->first();
        $operasionals = \App\Models\ContentOperasional::orderBy('target_deadline', 'asc')->get();
        
        return view('operational.content-creator.dashboard', compact('kpi', 'operasionals'));
    }
}
