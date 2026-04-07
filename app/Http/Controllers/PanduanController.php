<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index()
    {
        // Jika nanti butuh data tambahan dari database (misal: FAQ), bisa di-query di sini
        return view('panduan');
    }
    
    public function update(Request $request)
    {
        // Validasi file harus PDF dan maksimal 5MB
        $request->validate([
            'file_panduan' => 'required|mimes:pdf|max:5120',
        ]);
    
        if ($request->hasFile('file_panduan')) {
            $file = $request->file('file_panduan');
            
            // Simpan dengan nama tetap agar menimpa file yang lama (replace)
            $fileName = 'panduan-dashboard.pdf';
            
            // Pindahkan ke public/assets/pdf
            $file->move(public_path('assets/pdf'), $fileName);
    
            return redirect()->back()->with('success', 'File panduan berhasil diperbarui!');
        }
    
        return redirect()->back()->with('error', 'Gagal mengupload file.');
    }
}