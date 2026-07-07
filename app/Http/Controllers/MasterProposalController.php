<?php

namespace App\Http\Controllers;

use App\Models\MasterProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterProposalController extends Controller
{
    public function index()
    {
        $proposals = MasterProposal::with('user')->latest()->get();
        return view('rnd.master-proposal.index', compact('proposals'));
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
