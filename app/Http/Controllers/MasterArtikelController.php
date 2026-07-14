<?php

namespace App\Http\Controllers;

use App\Models\MasterArtikel;
use Illuminate\Http\Request;

class MasterArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterArtikel::with('user');

        // Fitur Pencarian & Filter
        $query->when($request->search, function ($q) use ($request) {
            $q->where('judul_artikel', 'like', '%' . $request->search . '%');
        });

        $query->when($request->kategori, function ($q) use ($request) {
            $q->where('kategori_artikel', $request->kategori);
        });

        $query->when($request->user_id, function ($q) use ($request) {
            $q->where('user_id', $request->user_id);
        });

        $query->when($request->status_publish, function ($q) use ($request) {
            $q->where('status_publish', $request->status_publish);
        });

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $artikels = $query->latest()->paginate(10)->withQueryString();
        
                $totalStat = MasterArtikel::count();
        $totalPublish = MasterArtikel::where('status_publish', 'Publish')->count();
        $kategoriTerbanyak = MasterArtikel::select('kategori_artikel')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('kategori_artikel')
            ->orderByDesc('total')
            ->first();
        $kategoriTop = $kategoriTerbanyak ? $kategoriTerbanyak->kategori_artikel : '-';
        $kategoriTopCount = $kategoriTerbanyak ? $kategoriTerbanyak->total : 0;

        $chartData = MasterArtikel::selectRaw('MONTH(created_at) as month, count(*) as total')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy(\DB::raw('MONTH(created_at)'))
                                  ->pluck('total', 'month')
                                  ->toArray();
                                  
        $chartValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartValues[] = $chartData[$i] ?? 0;
        }

        // Data untuk Doughnut Chart (Kategori)
        $kategoriStats = MasterArtikel::select('kategori_artikel', \DB::raw('count(*) as total'))
                                      ->groupBy('kategori_artikel')
                                      ->get();
        $kategoriLabels = $kategoriStats->pluck('kategori_artikel')->toArray();
        $kategoriValues = $kategoriStats->pluck('total')->toArray();

        // Data untuk Dropdown Filter
        $listKategori = MasterArtikel::select('kategori_artikel')->distinct()->pluck('kategori_artikel');
        $listPenginput = MasterArtikel::with('user')->select('user_id')->distinct()->get()->map(function($item) {
            return $item->user;
        })->filter();

        return view('rnd.master-artikel.index', compact('artikels', 'totalStat', 'totalPublish', 'kategoriTop', 'kategoriTopCount', 'chartValues', 'kategoriLabels', 'kategoriValues', 'listKategori', 'listPenginput'));
    }

    public function downloadTxt($id)
    {
        $artikel = MasterArtikel::findOrFail($id);
        
        $content = "Judul: " . $artikel->judul_artikel . "\r\n";
        $content .= "Kategori: " . $artikel->kategori_artikel . "\r\n";
        $content .= "Tanggal: " . $artikel->created_at->format('d/m/Y H:i') . "\r\n";
        $content .= "Status: " . $artikel->status_publish . "\r\n";
        $content .= str_repeat("-", 50) . "\r\n\r\n";
        $content .= $artikel->naskah_artikel;

        $fileName = 'Artikel_' . \Str::slug($artikel->judul_artikel) . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
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
