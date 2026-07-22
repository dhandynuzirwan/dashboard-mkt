<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengajuan Lembur - {{ $lembur->nama }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .kop-surat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .kop-surat .logo img {
            height: 60px;
        }
        .kop-surat .doc-info table {
            width: auto;
            margin-bottom: 0;
            font-size: 12px;
        }
        .kop-surat .doc-info table td {
            padding: 2px 5px;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .content {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.form-table td {
            padding: 5px;
            vertical-align: top;
        }
        table.form-table td:first-child {
            width: 30%;
            font-weight: bold;
        }
        table.form-table td:nth-child(2) {
            width: 2%;
        }
        .signatures {
            margin-top: 50px;
            width: 100%;
        }
        .signatures table {
            width: 100%;
            text-align: center;
        }
        .signatures td {
            width: 25%;
            padding: 10px;
        }
        .sign-space {
            height: 80px;
        }
        .name {
            font-weight: bold;
            text-decoration: underline;
        }
        .approved-stamp {
            color: green;
            font-weight: bold;
            border: 2px solid green;
            padding: 5px;
            display: inline-block;
            transform: rotate(-10deg);
            margin-top: 20px;
        }
        
        @media print {
            body {
                background-color: #fff;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            @page {
                size: A4;
                margin: 2cm;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="kop-surat">
            <div class="logo">
                <img src="{{ asset('assets/img/arsa/arsa_logo.webp') }}" alt="Logo">
            </div>
            <div class="doc-info">
                <table>
                    <tr>
                        <td>No Doc</td>
                        <td>:</td>
                        <td>AJP/SOP-HRD/FH{{ $lembur->id }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($lembur->updated_at)->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="header" style="border-bottom: 0; padding-bottom: 0; margin-bottom: 10px;">
            <h2>FORMULIR PENGAJUAN LEMBUR</h2>
            <p>Dokumen Internal Perusahaan</p>
        </div>
        
        <div class="title">
            SURAT PERINTAH / PENGAJUAN LEMBUR
        </div>

        <div class="content">
            <p>Yang bertanda tangan di bawah ini, menerangkan bahwa:</p>
            
            <table class="form-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $lembur->nama }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $lembur->jabatan }}</td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td>{{ $lembur->divisi }}</td>
                </tr>
                <tr>
                    <td>Hari / Tanggal</td>
                    <td>:</td>
                    <td>
                        {{ \Carbon\Carbon::parse($lembur->tanggal_mulai)->translatedFormat('l, d F Y') }}
                        @if($lembur->tanggal_selesai && $lembur->tanggal_selesai != $lembur->tanggal_mulai)
                            <br>s/d<br>
                            {{ \Carbon\Carbon::parse($lembur->tanggal_selesai)->translatedFormat('l, d F Y') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Waktu (Jam)</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($lembur->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($lembur->jam_selesai)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td>Tugas yang Dikerjakan</td>
                    <td>:</td>
                    <td>{{ $lembur->tugas }}</td>
                </tr>
                <tr>
                    <td>Dukungan (Fasilitas)</td>
                    <td>:</td>
                    <td>{{ $lembur->dukungan_fasilitas ?: '-' }}</td>
                </tr>
                <tr>
                    <td>Catatan Lainnya</td>
                    <td>:</td>
                    <td>{{ $lembur->catatan ?: '-' }}</td>
                </tr>
            </table>

            <p style="margin-top: 30px;">Demikian surat pengajuan lembur ini dibuat untuk dapat dilaksanakan dan digunakan sebagaimana mestinya.</p>
        </div>

        <div class="signatures">
            <table>
                <tr>
                    <td>
                        Pemohon,<br>
                        <br><br><br><br>
                        <span class="name">{{ $lembur->nama }}</span>
                    </td>
                    <td>
                        Menyetujui,<br>Kepala Divisi<br>
                        <div class="approved-stamp">APPROVED</div>
                        <br>
                        <span class="name">{{ $lembur->spv->name ?? 'Disetujui' }}</span>
                    </td>
                    <td>
                        Mengetahui,<br>HRD<br>
                        <div class="approved-stamp">APPROVED</div>
                        <br>
                        <span class="name">{{ $lembur->hrd->name ?? 'Disetujui' }}</span>
                    </td>
                    <td>
                        Mengetahui,<br>Direktur<br>
                        <div class="approved-stamp">APPROVED</div>
                        <br>
                        <span class="name">{{ $lembur->direktur->name ?? 'Disetujui' }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
