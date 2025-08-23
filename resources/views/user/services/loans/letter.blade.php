<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Izin Pemakaian Alat - {{ $loan->namaPeminjam }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
        }
        
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        
        .content {
            margin-bottom: 30px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .applicant-info {
            margin-bottom: 20px;
        }
        
        .applicant-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .applicant-label {
            width: 200px;
            font-weight: bold;
        }
        
        .applicant-value {
            flex: 1;
            border-bottom: 1px dotted #333;
            min-height: 20px;
        }
        
        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .equipment-table th,
        .equipment-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        
        .equipment-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .print-buttons {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 8px;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .letter-number {
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .date-location {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .responsibility-clause {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .research-details {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Print Buttons -->
    {{-- Hapus seluruh blok tombol aksi di atas surat --}}
    {{-- <div class="no-print print-buttons"> ... </div> --}}

    <!-- Letter Content -->
    <div class="header">
        <h1>Surat Izin Pemakaian Alat</h1>
        <p>Laboratorium Fisika Material dan Energi</p>
        <p>Departemen Fisika, Universitas Syiah Kuala</p>
    </div>

    <div class="letter-number">
        Nomor: {{ $loan->id }}<br>
        Tanggal: {{ \Carbon\Carbon::parse($loan->created_at)->format('d F Y') }}
    </div>

    <div class="content">
        <!-- Applicant Information -->
        <div class="section" style="margin-bottom: 10px;">
            <div style="margin-bottom: 8px;">
                @if($loan->user_type === 'dosen')
                    Saya yang bertanda tangan di bawah ini sebagai Dosen Universitas Syiah Kuala:
                @else
                    Saya yang bertanda tangan di bawah ini sebagai Dosen Pembimbing/Pimpinan Instansi<br>dari mahasiswa/staf/peneliti:
                @endif
            </div>
            <table style="width:100%; border-collapse:collapse; margin-bottom: 10px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:4px; width:60%;">Nama</th>
                        <th style="border:1px solid #000; padding:4px; width:40%;">{{ $loan->user_type === 'dosen' ? 'NIP' : ($loan->user_type === 'mahasiswa' ? 'NIM' : 'NIP/ID') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border:1px solid #000; padding:4px;">{{ $loan->namaPeminjam }}</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $loan->nip_nim }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section" style="margin-bottom: 10px;">
            @if($loan->user_type === 'dosen')
                Mohon diberikan izin kepada saya agar dapat memakai peralatan sebagai berikut:
            @else
                Mohon diberikan izin kepada mahasiswa/staf/peneliti tersebut agar dapat memakai peralatan sebagai berikut:
            @endif
            <table style="width:100%; border-collapse:collapse; margin-top: 8px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:4px; width:5%;">No.</th>
                        <th style="border:1px solid #000; padding:4px; width:35%;">Nama Alat</th>
                        <th style="border:1px solid #000; padding:4px; width:40%;">Spesifikasi</th>
                        <th style="border:1px solid #000; padding:4px; width:20%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->items as $index => $item)
                    <tr>
                        <td style="border:1px solid #000; padding:4px;">{{ $index + 1 }}</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $item->alat->nama }}</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $item->alat->deskripsi }}</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $item->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section" style="margin-bottom: 10px;">
            Peralatan tersebut digunakan untuk melaksanakan penelitian dengan judul: <span>{{ $loan->judul_penelitian ?? '........' }}</span> di Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala pada:
            <div style="display: flex; gap: 40px; margin-left: 30px; margin-top: 5px;">
                <div>Tanggal/Tahun : {{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') : '' }}</div>
                <div>Waktu : {{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('H:i') : '' }}</div>
            </div>
        </div>
        <div class="section" style="margin-bottom: 10px;">
            @if($loan->user_type === 'dosen')
                Segala sesuatu yang menyebabkan kerugian akan menjadi tanggung jawab saya yang bersangkutan.
            @else
                Segala sesuatu yang menyebabkan kerugian akan menjadi tanggung jawab mahasiswa yang bersangkutan.
            @endif
        </div>
        <div class="section" style="margin-bottom: 10px;">
            Demikian surat ini dibuat, untuk dipergunakan sebagaimana mestinya.
        </div>
        <div class="section" style="margin-bottom: 30px; text-align:center;">
            Darussalam, {{ $loan->created_at ? \Carbon\Carbon::parse($loan->created_at)->format('d F Y') : 'tanggal, bulan, tahun' }}<br>
            <br>
            Menyetujui,
        </div>
        <div style="display: flex; justify-content: center; gap: 60px; margin-top: 40px;">
            <div style="text-align: center; width: 300px;">
                Kepala Laboratorium Fisika Material dan Energi,<br><br><br><br>
                <strong>Saifullah, S. Si, M. Si</strong><br>
                1100023129401912
            </div>
            <div style="text-align: center; width: 300px;">
                @if($loan->user_type === 'dosen')
                    Pemohon,<br><br><br><br>
                    <strong>{{ $loan->namaPeminjam }}</strong><br>
                    {{ $loan->nip_nim }}
                @elseif($loan->user_type === 'mahasiswa')
                    Pembimbing Penelitian,<br><br><br><br>
                    <strong>{{ $loan->supervisor_name ?? '-' }}</strong><br>
                    {{ $loan->supervisor_nip ?? '-' }}
                @else
                    Pimpinan Instansi,<br><br><br><br>
                    <strong>{{ $loan->supervisor_name ?? '-' }}</strong><br>
                    {{ $loan->supervisor_nip ?? '-' }}
                    @if($loan->supervisor_instansi)
                        <br>{{ $loan->supervisor_instansi }}
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    {{-- Hapus seluruh blok tanda tangan di bawah surat --}}
    {{-- <div class="signature-section"> ... </div> --}}

    <!-- Status Information -->
    <!-- <div style="margin-top: 50px; padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;">
        <h3 style="margin: 0 0 10px 0; color: #007bff;">Status Peminjaman</h3>
        <p style="margin: 0;"><strong>Status:</strong> 
            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;
                @if($loan->status === 'PENDING') background: #fff3cd; color: #856404;
                @elseif($loan->status === 'APPROVED') background: #d4edda; color: #155724;
                @elseif($loan->status === 'REJECTED') background: #f8d7da; color: #721c24;
                @else background: #e2e3e5; color: #383d41;
                @endif">
                {{ $loan->status_label }}
            </span>
        </p>
        <p style="margin: 5px 0 0 0;"><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($loan->created_at)->format('d F Y H:i') }}</p>
        @if($loan->notes)
        <p style="margin: 5px 0 0 0;"><strong>Catatan:</strong> {{ $loan->notes }}</p>
        @endif
    </div> -->

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html> 