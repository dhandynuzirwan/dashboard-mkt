<?php

namespace App\Imports;

use App\Models\Prospek;
use App\Models\Cta;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProspekCtaImport implements ToCollection, WithHeadingRow
{
    public $createdProspekIds = [];
    public $createdCtaIds = [];

    public function collection(Collection $rows)
    {
        $currentUserId = auth()->id();

        foreach ($rows as $row) {
            // Jika kolom perusahaan kosong, lewati baris ini
            if (empty($row['perusahaan'])) {
                continue;
            }

            // 1. Parsing Tanggal Prospek secara aman (Mendukung format d/m/Y seperti 21/07/2025)
            $tanggalProspek = now()->format('Y-m-d');
            if (!empty($row['tanggal_prospek'])) {
                $rawTanggal = trim($row['tanggal_prospek']);
                if (is_numeric($rawTanggal)) {
                    $tanggalProspek = Date::excelToDateTimeObject($rawTanggal)->format('Y-m-d');
                } else {
                    try {
                        $cleanedDate = str_replace(['\\', '-'], '/', $rawTanggal);
                        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $cleanedDate)) {
                            $tanggalProspek = Carbon::createFromFormat('d/m/Y', $cleanedDate)->format('Y-m-d');
                        } else {
                            $tanggalProspek = Carbon::parse($cleanedDate)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $tanggalProspek = now()->format('Y-m-d');
                    }
                }
            }

            // 2. Pemetaan Marketing (Berdasarkan Nama)
            $marketingId = $currentUserId;
            if (!empty($row['nama_marketing'])) {
                $marketing = User::where('role', 'marketing')
                    ->where('name', 'LIKE', '%' . trim($row['nama_marketing']) . '%')
                    ->first();
                if ($marketing) {
                    $marketingId = $marketing->id;
                }
            }

            // 3. Cari Data Prospek yang Sudah Ada (Pencocokan berbasis Perusahaan & Lokasi)
            $perusahaan = trim($row['perusahaan']);
            $lokasi = isset($row['lokasi']) ? trim($row['lokasi']) : null;

            // Parsing tanggal FU secara aman (Karena bertipe string, kita simpan langsung teksnya)
            $updateFU = null;
            if (isset($row['update_fu']) && $row['update_fu'] !== '') {
                $rawUpdateFU = trim($row['update_fu']);
                if (is_numeric($rawUpdateFU)) {
                    $updateFU = Date::excelToDateTimeObject($rawUpdateFU)->format('Y-m-d');
                } else {
                    $updateFU = $rawUpdateFU;
                }
            }

            $prospekQuery = Prospek::where('perusahaan', 'LIKE', '%' . $perusahaan . '%');
            if (!empty($lokasi)) {
                $prospekQuery->where('lokasi', 'LIKE', '%' . $lokasi . '%');
            } else {
                $prospekQuery->where(function($q) {
                    $q->whereNull('lokasi')->orWhere('lokasi', '');
                });
            }
            $prospek = $prospekQuery->first();

            // 4. Buat atau Update data Prospek
            if ($prospek) {
                $prospek->update([
                    'tanggal_prospek' => $tanggalProspek,
                    'marketing_id'    => $marketingId,
                    'telp'            => $row['telp'] ?? $prospek->telp,
                    'telp_baru'       => $row['telp_baru'] ?? $prospek->telp_baru,
                    'email'           => $row['email'] ?? $prospek->email,
                    'jabatan'         => $row['jabatan'] ?? $prospek->jabatan,
                    'nama_pic'        => $row['nama_hrd_pic'] ?? $prospek->nama_pic,
                    'wa_pic'          => $row['wa_hrd_pic'] ?? $prospek->wa_pic,
                    'sumber'          => $row['sumber'] ?? $prospek->sumber,
                    'status'          => $row['status_akhir_data'] ?? $prospek->status,
                    'catatan'         => $row['catatan'] ?? $prospek->catatan,
                    'update_terakhir' => $updateFU ?? now()->format('Y-m-d H:i:s'),
                ]);
            } else {
                $prospek = Prospek::create([
                    'marketing_id'    => $marketingId,
                    'tanggal_prospek' => $tanggalProspek,
                    'perusahaan'      => $perusahaan,
                    'telp'            => $row['telp'] ?? null,
                    'telp_baru'       => $row['telp_baru'] ?? null,
                    'email'           => $row['email'] ?? null,
                    'jabatan'         => $row['jabatan'] ?? null,
                    'nama_pic'        => $row['nama_hrd_pic'] ?? null,
                    'wa_pic'          => $row['wa_hrd_pic'] ?? null,
                    'lokasi'          => $lokasi,
                    'sumber'          => $row['sumber'] ?? null,
                    'status'          => $row['status_akhir_data'] ?? null,
                    'catatan'         => $row['catatan'] ?? null,
                    'update_terakhir' => $updateFU ?? now()->format('Y-m-d H:i:s'),
                ]);
                $this->createdProspekIds[] = $prospek->id;
            }

            // 5. Simpan / Hubungkan dengan data CTA (jika ada judul permintaan atau ada detail CTA yang terisi)
            $hasCtaDetails = !empty($row['judul_permintaan_cta']) 
                || !empty($row['jumlah_peserta_cta']) 
                || !empty($row['sertifikasi_cta']) 
                || !empty($row['skema_cta']) 
                || !empty($row['harga_penawaran_cta']) 
                || !empty($row['harga_vendor_cta'])
                || !empty($row['link_proposal_cta'])
                || !empty($row['status_penawaran_cta'])
                || !empty($row['keterangan_cta']);

            if ($hasCtaDetails) {
                $jumlah = !empty($row['jumlah_peserta_cta']) ? (int)$row['jumlah_peserta_cta'] : 1;
                $hargaPenawaran = !empty($row['harga_penawaran_cta']) ? (float)$row['harga_penawaran_cta'] : null;
                $hargaVendor = !empty($row['harga_vendor_cta']) ? (float)$row['harga_vendor_cta'] : null;

                $totalPenawaran = ($jumlah && $hargaPenawaran) ? $jumlah * $hargaPenawaran : null;
                $totalVendor = ($jumlah && $hargaVendor) ? $jumlah * $hargaVendor : null;

                // Logika penerjemahan sertifikasi
                $sertifikasiExcel = isset($row['sertifikasi_cta']) ? strtoupper(trim($row['sertifikasi_cta'])) : '';
                $sertifikasiDB = null;
                if ($sertifikasiExcel !== '') {
                    if (str_contains($sertifikasiExcel, 'KEMENAKER') || str_contains($sertifikasiExcel, 'KEMNAKER')) {
                        $sertifikasiDB = 'kemnaker';
                    } elseif (str_contains($sertifikasiExcel, 'BNSP')) {
                        $sertifikasiDB = 'bnsp';
                    } elseif (str_contains($sertifikasiExcel, 'INTERNAL')) {
                        $sertifikasiDB = 'internal';
                    } elseif (str_contains($sertifikasiExcel, 'SIO')) {
                        $sertifikasiDB = 'sio';
                    } elseif (str_contains($sertifikasiExcel, 'RIKSA')) {
                        $sertifikasiDB = 'riksa';
                    }
                }

                // Logika penerjemahan skema (Enum: Offline Training, Online Training, Inhouse Training)
                $skemaExcel = isset($row['skema_cta']) ? strtolower(trim($row['skema_cta'])) : '';
                $skemaDB = null;
                if ($skemaExcel !== '') {
                    if (str_contains($skemaExcel, 'online')) {
                        $skemaDB = 'Online Training';
                    } elseif (str_contains($skemaExcel, 'offline')) {
                        $skemaDB = 'Offline Training';
                    } elseif (str_contains($skemaExcel, 'inhouse') || str_contains($skemaExcel, 'in-house') || str_contains($skemaExcel, 'in house')) {
                        $skemaDB = 'Inhouse Training';
                    }
                }

                // Logika penerjemahan status penawaran (Enum: under_review, hold, kalah_harga, deal, cancel)
                $statusExcel = isset($row['status_penawaran_cta']) ? strtolower(trim($row['status_penawaran_cta'])) : '';
                $statusDB = 'under_review'; // Default
                if ($statusExcel !== '') {
                    $normalizedStatus = str_replace([' ', '-'], '_', $statusExcel);
                    if (str_contains($normalizedStatus, 'review') || str_contains($normalizedStatus, 'under')) {
                        $statusDB = 'under_review';
                    } elseif (str_contains($normalizedStatus, 'hold')) {
                        $statusDB = 'hold';
                    } elseif (str_contains($normalizedStatus, 'kalah') || str_contains($normalizedStatus, 'harga')) {
                        $statusDB = 'kalah_harga';
                    } elseif (str_contains($normalizedStatus, 'deal') || str_contains($normalizedStatus, 'closing')) {
                        $statusDB = 'deal';
                    } elseif (str_contains($normalizedStatus, 'cancel') || str_contains($normalizedStatus, 'batal')) {
                        $statusDB = 'cancel';
                    }
                }

                // Tentukan Judul Permintaan secara aman (fallback ke sertifikasi/skema jika judul kosong)
                $judulPermintaan = !empty($row['judul_permintaan_cta']) 
                    ? trim($row['judul_permintaan_cta']) 
                    : (!empty($row['sertifikasi_cta']) ? trim($row['sertifikasi_cta']) : (!empty($row['skema_cta']) ? trim($row['skema_cta']) : '-'));

                // Cari apakah CTA dengan judul_permintaan yang sama sudah ada untuk prospek ini
                $cta = Cta::where('prospek_id', $prospek->id)
                    ->where('judul_permintaan', 'LIKE', '%' . trim($judulPermintaan) . '%')
                    ->first();

                if ($cta) {
                    // Update data CTA yang ada
                    $cta->update([
                        'jumlah_peserta'   => $jumlah,
                        'sertifikasi'      => $sertifikasiDB,
                        'skema'            => $skemaDB ?? $cta->skema,
                        'harga_penawaran'  => $hargaPenawaran,
                        'harga_vendor'     => $hargaVendor,
                        'total_penawaran'  => $totalPenawaran,
                        'total_vendor'     => $totalVendor,
                        'proposal_link'    => $row['link_proposal_cta'] ?? $cta->proposal_link,
                        'status_penawaran' => $statusExcel !== '' ? $statusDB : $cta->status_penawaran,
                        'keterangan'       => $row['keterangan_cta'] ?? $cta->keterangan,
                    ]);
                } else {
                    // Buat data CTA baru (multiple CTA per prospek didukung)
                    $newCta = Cta::create([
                        'prospek_id'       => $prospek->id,
                        'judul_permintaan' => $judulPermintaan,
                        'jumlah_peserta'   => $jumlah,
                        'sertifikasi'      => $sertifikasiDB,
                        'skema'            => $skemaDB,
                        'harga_penawaran'  => $hargaPenawaran,
                        'harga_vendor'     => $hargaVendor,
                        'total_penawaran'  => $totalPenawaran,
                        'total_vendor'     => $totalVendor,
                        'proposal_link'    => $row['link_proposal_cta'] ?? null,
                        'status_penawaran' => $statusDB,
                        'keterangan'       => $row['keterangan_cta'] ?? null,
                    ]);
                    $this->createdCtaIds[] = $newCta->id;
                }
            } else {
                // Skenario: Baris tidak memiliki detail CTA, tetapi karena ini import data pipeline lama, 
                // semua data harus berstatus "Done CTA" (memiliki minimal 1 relasi CTA).
                // Kita buatkan minimal satu record CTA kosong jika belum punya sama sekali.
                $ctaExists = Cta::where('prospek_id', $prospek->id)->exists();
                if (!$ctaExists) {
                    $newCta = Cta::create([
                        'prospek_id'       => $prospek->id,
                        'judul_permintaan' => '-', // Judul default penanda
                        'status_penawaran' => 'under_review',
                    ]);
                    $this->createdCtaIds[] = $newCta->id;
                }
            }
        }
    }
}
