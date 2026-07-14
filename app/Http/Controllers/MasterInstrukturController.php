<?php

namespace App\Http\Controllers;

use App\Models\MasterInstruktur;
use Illuminate\Http\Request;

class MasterInstrukturController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterInstruktur::with('user');

        // Fitur Pencarian & Filter
        $query->when($request->search, function ($q) use ($request) {
            $q->where('nama_instruktur', 'like', '%' . $request->search . '%')
              ->orWhere('bidang_ahli', 'like', '%' . $request->search . '%')
              ->orWhere('wilayah_instansi', 'like', '%' . $request->search . '%');
        });

        $query->when($request->bidang_ahli, function ($q) use ($request) {
            $q->where('bidang_ahli', 'like', '%' . $request->bidang_ahli . '%');
        });

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $instrukturs = $query->latest()->paginate(10)->withQueryString();
        
        // --- DATA UNTUK STAT CARDS ---
        $totalStat = MasterInstruktur::count();
        $avgRate = MasterInstruktur::avg('rate_harga') ?? 0;
        
        $allBidang = MasterInstruktur::pluck('bidang_ahli')->toArray();
        $bidangCounts = [];
        foreach($allBidang as $b_str) {
            if(!$b_str) continue;
            $b_arr = array_map('trim', explode(',', $b_str));
            foreach($b_arr as $b) {
                if(!empty($b)) {
                    $bidangCounts[$b] = ($bidangCounts[$b] ?? 0) + 1;
                }
            }
        }
        arsort($bidangCounts);
        
        $bidangTop = count($bidangCounts) > 0 ? array_key_first($bidangCounts) : '-';
        $bidangTopCount = count($bidangCounts) > 0 ? $bidangCounts[$bidangTop] : 0;

        // --- DATA UNTUK GRAFIK ---
        // Bar Chart: Input per bulan
        $chartData = MasterInstruktur::selectRaw('MONTH(created_at) as month, count(*) as total')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy(\DB::raw('MONTH(created_at)'))
                                  ->pluck('total', 'month')
                                  ->toArray();
                                  
        $chartValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartValues[] = $chartData[$i] ?? 0;
        }

        // Doughnut Chart: Komposisi Bidang Ahli
        $bidangLabels = array_keys($bidangCounts);
        $bidangValues = array_values($bidangCounts);

        // Data untuk Dropdown Filter
        $listBidang = $bidangLabels;
        sort($listBidang);

        return view('rnd.master-instruktur.index', compact(
            'instrukturs', 
            'totalStat', 
            'avgRate', 
            'bidangTop', 
            'bidangTopCount', 
            'chartValues', 
            'bidangLabels', 
            'bidangValues', 
            'listBidang'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instruktur' => 'required|string|max:255',
            'wilayah_instansi' => 'nullable|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'nullable|numeric',
            'no_rek' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'link_cv' => 'nullable|url',
        ]);

        MasterInstruktur::create([
            'nama_instruktur' => $request->nama_instruktur,
            'wilayah_instansi' => $request->wilayah_instansi,
            'no_telepon' => $request->no_telepon,
            'bidang_ahli' => $request->bidang_ahli,
            'rate_harga' => $request->rate_harga,
            'no_rek' => $request->no_rek,
            'bank' => $request->bank,
            'link_cv' => $request->link_cv,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_instruktur' => 'required|string|max:255',
            'wilayah_instansi' => 'nullable|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'nullable|numeric',
            'no_rek' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'link_cv' => 'nullable|url',
        ]);

        $instruktur = MasterInstruktur::findOrFail($id);
        $instruktur->update([
            'nama_instruktur' => $request->nama_instruktur,
            'wilayah_instansi' => $request->wilayah_instansi,
            'no_telepon' => $request->no_telepon,
            'bidang_ahli' => $request->bidang_ahli,
            'rate_harga' => $request->rate_harga,
            'no_rek' => $request->no_rek,
            'bank' => $request->bank,
            'link_cv' => $request->link_cv,
        ]);

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil diupdate.');
    }

    public function destroy($id)
    {
        $instruktur = MasterInstruktur::findOrFail($id);
        $instruktur->delete();

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil dihapus.');
    }
}
