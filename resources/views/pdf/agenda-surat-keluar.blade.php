<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Surat Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 5px;
        }
    .header {
        position: relative; /* Agar posisi absolute anak mengacu ke sini */
        height: 150px;
        margin-bottom: 0;
        margin-top: 1px;
    }

    .header img {
        position: absolute;
        left: 0;
        top: 0;
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .header-text {
        text-align: center;
        width: 100%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-family: Arial, sans-serif;
        line-height: 1.5;
    }

    .header-text h1 {
        margin: 2px 0;
        font-size: 23px;
        font-weight: bold;
    }

    .header-text h2 {
        margin: 2px 0;
        font-size: 20px;
        font-weight: normal;
    }
        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        }
        table, th, td {
        border: 1px solid #000;
        }
        th, td {
        padding: 8px;
        text-align: left;
        }
        th {
        background-color: #0c84f3;
        font-weight: bold;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
        }
        .text-center {
        text-align: center;
        }
        .footer {
        margin-top: 40px;
        text-align: right;
        }
        .footer p {
        margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logoSMPIT.jpg') }}" alt="Logo SMPIT AFISKU">
        <div class="header-text">
            <h1>AGENDA SURAT KELUAR</h1>
            <h1>UNIT SMPIT AL-FITYAN CABANG KUBU RAYA</h1>
            <h2>Tahun Ajaran: {{ $tahunAjaran->th_ajaran ?? 'Tidak Diketahui' }}</h2>
        </div>
    </div>
    <hr style="border: 0; border-top: 4px solid #2c3e50; margin-top: 3px;">

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="23%">Nomor Surat</th>
                <th width="10%">Tanggal</th>
                <th width="22%">Perihal</th>
                <th width="20%">Tujuan</th>
                <th width="20%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratKeluars as $index => $surat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $surat->no_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tgl_surat_keluar)->format('d/m/Y') }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ $surat->tujuan_pengiriman }}</td>
                    <td>{{ $surat->kategoriSurat->kategori ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data surat keluar untuk tahun ajaran ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        @php
    $bulanIndonesia = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    $tanggal = \Carbon\Carbon::now();
    $formattedDate = $tanggal->format('d') . ' ' . $bulanIndonesia[$tanggal->month] . ' ' . $tanggal->format('Y');
    @endphp
    <p>Dicetak pada: {{ $formattedDate }}</p>
    <p>Kepala SMPIT Al-Fityan Kubu Raya</p>
    <p style="font-weight: bold; font-size: 16px; text-decoration: underline; margin-top: 80px;">Heru Purwanto, S.Pd.</p>
    </div>
</body>
</html>