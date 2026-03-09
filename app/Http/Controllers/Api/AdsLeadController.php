<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdsLead;
use Illuminate\Http\Request;

class AdsLeadController extends Controller
{
    public function store(Request $request)
    {
        // 1. Cek API Key
        if ($request->header('X-API-KEY') !== 'RAHASIA123') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Logika Duplicate Check
        // Kita cek apakah Email ATAU WA sudah pernah masuk sebelumnya
        $isDuplicate = AdsLead::where('email', $request->email)
            ->where('wa_hrd', $request->wa_hrd)
            ->where('jenis_sertifikasi', $request->jenis_sertifikasi) // Tambahkan kunci ini
            ->where('marketing_id', null) // Hanya cek duplikat jika data sebelumnya BELUM di-follow up
            ->exists();

        if ($isDuplicate) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'Klien ini sudah terdaftar untuk program sertifikasi yang sama.'
            ], 200);
        }

        // 3. Simpan Data Jika Belum Ada
        try {
            $lead = AdsLead::create([
                'nama_hrd'          => $request->nama_hrd,
                'email'             => $request->email,
                'wa_hrd'            => $request->wa_hrd,
                'kebutuhan_program' => $request->kebutuhan_program,
                'jenis_sertifikasi' => $request->jenis_sertifikasi,
                'nama_perusahaan'   => $request->nama_perusahaan,
                'lokasi'            => $request->lokasi,
                'jenis_klien'       => $request->jenis_klien,
                'channel_akuisisi'  => $request->channel_akuisisi,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data baru berhasil disimpan',
                'id' => $lead->id
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }
}