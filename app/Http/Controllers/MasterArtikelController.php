<?php

namespace App\Http\Controllers;

use App\Models\MasterArtikel;
use Illuminate\Http\Request;

class MasterArtikelController extends Controller
{
    public function index()
    {
        $artikels = MasterArtikel::with('user')->latest()->get();
        
        $totalStat = MasterArtikel::count();
        $chartData = MasterArtikel::selectRaw('MONTH(created_at) as month, count(*) as total')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy('month')
                                  ->pluck('total', 'month')
                                  ->toArray();
                                  
        $chartValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartValues[] = $chartData[$i] ?? 0;
        }

        return view('rnd.master-artikel.index', compact('artikels', 'totalStat', 'chartValues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
            'judul_artikel' => 'required|string|max:255',
            'naskah_artikel' => 'required|string',
            'status_publish' => 'required|string',
            'link_publikasi' => 'nullable|url',
        ]);

        MasterArtikel::create([
            'kategori_artikel' => $request->kategori_artikel,
            'judul_artikel' => $request->judul_artikel,
            'naskah_artikel' => $request->naskah_artikel,
            'status_publish' => $request->status_publish,
            'link_publikasi' => $request->link_publikasi,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('master-artikel.index')->with('success', 'Data Artikel berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
            'judul_artikel' => 'required|string|max:255',
            'naskah_artikel' => 'required|string',
            'status_publish' => 'required|string',
            'link_publikasi' => 'nullable|url',
        ]);

        $artikel = MasterArtikel::findOrFail($id);
        $artikel->update([
            'kategori_artikel' => $request->kategori_artikel,
            'judul_artikel' => $request->judul_artikel,
            'naskah_artikel' => $request->naskah_artikel,
            'status_publish' => $request->status_publish,
            'link_publikasi' => $request->link_publikasi,
        ]);

        return redirect()->route('master-artikel.index')->with('success', 'Data Artikel berhasil diupdate.');
    }

    public function destroy($id)
    {
        $artikel = MasterArtikel::findOrFail($id);
        $artikel->delete();

        return redirect()->route('master-artikel.index')->with('success', 'Data Artikel berhasil dihapus.');
    }
}
