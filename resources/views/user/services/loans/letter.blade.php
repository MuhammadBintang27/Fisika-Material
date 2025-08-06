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
        <div class="section">
            <div class="section-title">Saya yang bertanda tangan di bawah ini sebagai {{ $loan->user_type === 'dosen' ? 'Dosen' : ($loan->user_type === 'mahasiswa' ? 'Mahasiswa' : 'Pihak Luar') }} dari {{ $loan->user_type === 'pihak-luar' ? $loan->instansi : 'Universitas Syiah Kuala' }}:</div>
            
            <div class="applicant-info">
                <div class="applicant-row">
                    <div class="applicant-label">Nama:</div>
                    <div class="applicant-value">{{ $loan->namaPeminjam }}</div>
                </div>
                <div class="applicant-row">
                    <div class="applicant-label">{{ $loan->user_type === 'dosen' ? 'NIP' : ($loan->user_type === 'mahasiswa' ? 'NIM' : 'NIP/ID') }}:</div>
                    <div class="applicant-value">{{ $loan->nip_nim }}</div>
                </div>
                @if($loan->user_type === 'mahasiswa')
                <div class="applicant-row">
                    <div class="applicant-label">Dosen Pembimbing:</div>
                    <div class="applicant-value">{{ $loan->supervisor_name }} ({{ $loan->supervisor_nip }})</div>
                </div>
                @endif
                @if($loan->user_type === 'pihak-luar')
                <div class="applicant-row">
                    <div class="applicant-label">Jabatan:</div>
                    <div class="applicant-value">{{ $loan->jabatan }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Equipment Request -->
        <div class="section">
            <div class="section-title">Mohon diberikan izin kepada {{ $loan->user_type === 'dosen' ? 'dosen' : ($loan->user_type === 'mahasiswa' ? 'mahasiswa' : 'pihak luar') }} tersebut agar dapat memakai peralatan sebagai berikut:</div>
            
            <table class="equipment-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Alat</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->alat->nama }}</td>
                        <td>{{ $item->alat->deskripsi }}</td>
                        <td>{{ $item->jumlah }} unit</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Research Details -->
        <div class="research-details">
            <div class="section-title">Peralatan tersebut digunakan untuk melaksanakan penelitian dengan judul:</div>
            <div style="font-weight: bold; margin: 10px 0;">{{ $loan->judul_penelitian }}</div>
            @if($loan->deskripsi_penelitian)
            <div style="margin: 10px 0;">{{ $loan->deskripsi_penelitian }}</div>
            @endif
            <div style="margin-top: 15px;">
                <strong>Di Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala pada:</strong><br>
                Tanggal: {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') }}<br>
                Waktu: {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('H:i') }} - {{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('H:i') }}<br>
                Durasi: {{ $loan->durasi_jam }} jam
            </div>
        </div>

        <!-- Responsibility Clause -->
        <div class="responsibility-clause">
            <strong>Segala sesuatu yang menyebabkan kerugian akan menjadi tanggung jawab {{ $loan->user_type === 'dosen' ? 'dosen' : ($loan->user_type === 'mahasiswa' ? 'mahasiswa' : 'peminjam') }} yang bersangkutan.</strong>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            Demikian surat ini dibuat, untuk dipergunakan sebagaimana mestinya.
        </div>

        <div class="date-location">
            Darussalam, {{ \Carbon\Carbon::parse($loan->created_at)->format('d F Y') }}
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div>Menyetujui,</div>
            <div>Kepala Laboratorium Fisika Material dan Energi,</div>
            <div class="signature-line">
                <br><br>
                <strong>Nama Kepala Laboratorium</strong><br>
                NIP.
            </div>
        </div>
        
        <div class="signature-box">
            @if($loan->user_type === 'mahasiswa')
            <div>Pembimbing Penelitian,</div>
            @elseif($loan->user_type === 'pihak-luar')
            <div>Pimpinan Instansi,</div>
            @else
            <div>Pemohon,</div>
            @endif
            <div class="signature-line">
                <br><br>
                <strong>{{ $loan->namaPeminjam }}</strong><br>
                {{ $loan->user_type === 'dosen' ? 'NIP' : ($loan->user_type === 'mahasiswa' ? 'NIM' : 'NIP/ID') }}: {{ $loan->nip_nim }}
            </div>
        </div>
    </div>

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