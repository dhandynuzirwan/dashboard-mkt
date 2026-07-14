<?php

namespace App\Http\Controllers;

use App\Models\MasterProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterProposalController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterProposal::with('user');

        // Fitur Pencarian & Filter
        $query->when($request->search, function ($q) use ($request) {
            $q->where('judul_proposal', 'like', '%' . $request->search . '%');
        });

        $query->when($request->lembaga, function ($q) use ($request) {
            $q->where('lembaga', $request->lembaga);
        });

        $query->when($request->kategori, function ($q) use ($request) {
            $q->where('kategori', $request->kategori);
        });

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $proposals = $query->latest()->paginate(10)->withQueryString();
        
        // --- DATA UNTUK STAT CARDS ---
        $totalBnsp = MasterProposal::where('lembaga', 'like', '%BNSP%')->count();
        $totalKemnaker = MasterProposal::where('lembaga', 'like', '%KEMNAKER%')->count();
        $totalSoftskill = MasterProposal::where('lembaga', 'like', '%SOFTSKILL%')->count();

        // --- DATA UNTUK GRAFIK ---
        // Bar Chart: Input per bulan
        $chartData = MasterProposal::selectRaw('MONTH(created_at) as month, count(*) as total')
                                  ->whereYear('created_at', date('Y'))
                                  ->groupBy('month')
                                  ->pluck('total', 'month')
                                  ->toArray();
                                  
        $chartValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartValues[] = $chartData[$i] ?? 0;
        }

        // Doughnut Chart: Komposisi Kategori
        $kategoriStats = MasterProposal::select('kategori', \DB::raw('count(*) as total'))
                                      ->groupBy('kategori')
                                      ->get();
        $kategoriLabels = $kategoriStats->pluck('kategori')->toArray();
        $kategoriValues = $kategoriStats->pluck('total')->toArray();

        // Data untuk Dropdown Filter
        $listKategori = MasterProposal::select('kategori')->distinct()->pluck('kategori');
        $listLembaga = MasterProposal::select('lembaga')->distinct()->pluck('lembaga');

        return view('rnd.master-proposal.index', compact(
            'proposals', 
            'totalBnsp', 
            'totalKemnaker', 
            'totalSoftskill', 
            'chartValues', 
            'kategoriLabels', 
            'kategoriValues', 
            'listKategori',
            'listLembaga'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lembaga' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:doc,docx,pdf|max:10240',
        ]);

        $file = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        MasterProposal::create([
            'lembaga' => $request->lembaga,
            'kategori' => $request->kategori,
            'judul_proposal' => $request->judul_proposal,
            'file_proposal_path' => $filePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('master-proposal.index')->with('success', 'Data Proposal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lembaga' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'file_proposal' => 'nullable|file|mimes:doc,docx,pdf|max:10240',
        ]);

        $proposal = MasterProposal::findOrFail($id);
        
        $data = [
            'lembaga' => $request->lembaga,
            'kategori' => $request->kategori,
            'judul_proposal' => $request->judul_proposal,
        ];

        if ($request->hasFile('file_proposal')) {
            // Delete old file if exists
            if ($proposal->file_proposal_path && Storage::disk('public')->exists($proposal->file_proposal_path)) {
                Storage::disk('public')->delete($proposal->file_proposal_path);
            }
            
            $file = $request->file('file_proposal');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['file_proposal_path'] = $file->storeAs('proposals', $fileName, 'public');
        }

        $proposal->update($data);

        return redirect()->route('master-proposal.index')->with('success', 'Data Proposal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $proposal = MasterProposal::findOrFail($id);
        
        if ($proposal->file_proposal_path && Storage::disk('public')->exists($proposal->file_proposal_path)) {
            Storage::disk('public')->delete($proposal->file_proposal_path);
        }
        
        $proposal->delete();

        return redirect()->route('master-proposal.index')->with('success', 'Data Proposal berhasil dihapus.');
    }
}
