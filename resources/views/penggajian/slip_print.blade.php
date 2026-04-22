<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $user->nama_lengkap ?? $user->name }}</title>
    <style>
        /* Pengaturan Dasar */
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: #f4f4f4; 
            padding: 20px; 
            margin: 0;
        }
        
        /* Container Slip A4 */
        .slip-card { 
            background: #fff; 
            width: 210mm; 
            min-height: 148mm; 
            margin: 0 auto; 
            padding: 15mm; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
            position: relative; 
            border: 1px solid #ddd;
        }

        /* Kop Surat */
        .kop-surat { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .kop-surat h2 { 
            margin: 0; 
            font-size: 24px; 
            letter-spacing: 1px;
        }
        .kop-surat p { 
            margin: 5px 0 0 0; 
            font-size: 14px; 
        }
        .logo-arsa { 
            height: 60px; 
            float: left; 
            position: absolute; 
            top: 15mm; 
            left: 15mm; 
        }

        /* Judul Slip */
        .title { 
            text-align: center; 
            font-size: 18px; 
            font-weight: bold; 
            text-decoration: underline; 
            margin: 20px 0; 
        }

        /* Tabel Info Karyawan */
        .table-info { 
            width: 100%; 
            margin-bottom: 20px; 
            font-size: 13px; 
        }
        .table-info td { 
            padding: 3px 0; 
        }

        /* Tabel Data Gaji */
        .table-data { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 13px; 
            border: 1px solid #000;
        }
        .table-data th, .table-data td { 
            border: 1px solid #000; 
            padding: 10px; 
        }
        .bg-gray { 
            background-color: #eeeeee; 
        }
        .text-right { 
            text-align: right; 
        }
        .indent { 
            padding-left: 25px !important; 
            font-style: italic;
            color: #555;
            font-size: 12px;
        }

        /* Box Tanda Tangan */
        .signature-section { 
            margin-top: 40px; 
            width: 100%; 
        }
        .signature-box { 
            float: right; 
            text-align: center; 
            width: 200px; 
        }
        .space { 
            height: 70px; 
        }

        /* Tombol Cetak */
        .no-print { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .btn-print {
            padding: 10px 25px; 
            cursor: pointer; 
            background: #28a745; 
            color: #fff; 
            border: none; 
            border-radius: 5px;
            font-weight: bold;
        }

        /* Media Print */
        @media print {
            body { background: none; padding: 0; }
            .slip-card { box-shadow: none; margin: 0; border: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            🖨️ Simpan / Cetak Slip Gaji
        </button>
        <a href="{{ url()->previous() }}" style="margin-left: 15px; text-decoration: none; color: #555;">[ Kembali ]</a>
    </div>

    <div class="slip-card">
        {{-- KOP SURAT --}}
        <div class="kop-surat">
            <img src="{{ asset('assets/img/kop-slip-gaji-arsa.png') }}" class="logo-arsa">
            <h2>PT ARSA JAYA PRIMA</h2>
            <p>Yogyakarta, Indonesia</p>
        </div>

        <div class="title">SLIP GAJI</div>

        {{-- INFO KARYAWAN --}}
        <table class="table-info">
            <tr>
                <td width="15%">Tanggal</td>
                <td width="2%">:</td>
                <td width="33%">{{ $now->translatedFormat('d F Y') }}</td>
                
                <td width="15%">Nama</td>
                <td width="2%">:</td>
                <td width="33%"><strong>{{ $user->nama_lengkap ?? $user->name }}</strong></td>
            </tr>
            <tr>
                <td>No. Referensi</td>
                <td>:</td>
                <td>{{ $noReferensi }}</td>
                
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $jabatan }}</td>
            </tr>
        </table>

        {{-- RINCIAN GAJI --}}
        <table class="table-data">
            <thead>
                <tr class="bg-gray">
                    <th width="65%">KETERANGAN</th>
                    <th width="35%" class="text-right">JUMLAH (Rp)</th>
                </tr>
            </thead>
            <tbody>
                {{-- SECTION PENGHASILAN --}}
                <tr class="bg-gray">
                    <td colspan="2"><strong>A. Penghasilan</strong></td>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td class="text-right">{{ number_format($gapok_hitung, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tunjangan BPJS</td>
                    <td class="text-right">{{ number_format($tunjangan_bpjs, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tunjangan Kemahalan</td>
                    <td class="text-right">{{ number_format($tunj_kemahalan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tunjangan Progress (KPI)</td>
                    <td class="text-right">{{ number_format($progress_val, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Komisi Penjualan / Fee Marketing</td>
                    <td class="text-right">{{ number_format($fee_marketing, 0, ',', '.') }}</td>
                </tr>

                {{-- SECTION POTONGAN --}}
                <tr class="bg-gray">
                    <td colspan="2"><strong>B. Potongan</strong></td>
                </tr>
                <tr>
                    <td>Iuran BPJS</td>
                    <td class="text-right fw-bold">{{ number_format($iuran_bpjs, 0, ',', '.') }}</td>
                </tr>
                <tr><td class="indent">- JKK (Perusahaan)</td><td class="text-right small text-muted">{{ number_format($jkk, 0, ',', '.') }}</td></tr>
                <tr><td class="indent">- JKM (Perusahaan)</td><td class="text-right small text-muted">{{ number_format($jkm, 0, ',', '.') }}</td></tr>
                <tr><td class="indent">- JHT Pemberi Kerja</td><td class="text-right small text-muted">{{ number_format($jht_kantor, 0, ',', '.') }}</td></tr>
                <tr><td class="indent">- JHT Tenaga Kerja (Karyawan)</td><td class="text-right small text-muted">{{ number_format($jht_karyawan, 0, ',', '.') }}</td></tr>
                
                <tr>
                    <td>Izin Tidak Masuk Kerja</td>
                    <td class="text-right text-danger">{{ number_format($potonganIzin, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="bg-gray">
                    <th class="text-right" style="font-size: 15px;">TOTAL DITERIMA (TAKE HOME PAY)</th>
                    <th class="text-right" style="font-size: 15px;">Rp {{ number_format($total_gaji, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        {{-- TANDA TANGAN --}}
        <div class="signature-section">
            <div class="signature-box">
                <p>Yogyakarta, {{ $now->translatedFormat('d F Y') }}</p>
                <p>PT Arsa Jaya Prima</p>
                <div class="space"></div>
                <p><strong>Fajar Budiarto</strong><br>Direktur</p>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

</body>
</html>