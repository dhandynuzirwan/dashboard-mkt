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
            $q->where('bidang_ahli', $request->bidang_ahli);
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
        
        $bidangTerbanyak = MasterInstruktur::select('bidang_ahli')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('bidang_ahli')
            ->orderByDesc('total')
            ->first();
        $bidangTop = $bidangTerbanyak ? $bidangTerbanyak->bidang_ahli : '-';
        $bidangTopCount = $bidangTerbanyak ? $bidangTerbanyak->total : 0;

        // --- DATA UNTUK GRAFIK ---
        // Bar Chart: Input per bulan
        $chartData = MasterInstruktur::selectRaw('MONTH(created_at) as month, count(*) as total')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy('month')
                                  ->pluck('total', 'month')
                                  ->toArray();
                                  
        $chartValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartValues[] = $chartData[$i] ?? 0;
        }

        // Doughnut Chart: Komposisi Bidang Ahli
        $bidangStats = MasterInstruktur::select('bidang_ahli', \DB::raw('count(*) as total'))
                                      ->groupBy('bidang_ahli')
                                      ->get();
        $bidangLabels = $bidangStats->pluck('bidang_ahli')->toArray();
        $bidangValues = $bidangStats->pluck('total')->toArray();

        // Data untuk Dropdown Filter
        $listBidang = MasterInstruktur::select('bidang_ahli')->distinct()->pluck('bidang_ahli');

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
            'wilayah_instansi' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'required|numeric',
            'no_rek' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
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
            'wilayah_instansi' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'required|numeric',
            'no_rek' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
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
