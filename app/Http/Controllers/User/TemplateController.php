<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index()
    {
        return view('user.components.surat-template');
    }

    public function download($type)
    {
        // Path ke template files
        $templates = [
            'pengujian' => 'templates/Template_Surat_Pengajuan_Pengujian.docx',
            'kunjungan' => 'templates/Template_Surat_Pengajuan_Kunjungan.docx'
        ];

        if (!array_key_exists($type, $templates)) {
            abort(404, 'Template tidak ditemukan');
        }

        $templatePath = $templates[$type];
        $fullPath = storage_path('app/public/' . $templatePath);

        if (!file_exists($fullPath)) {
            abort(404, 'File template tidak ditemukan');
        }

        $fileName = $type === 'pengujian' 
            ? 'Template_Surat_Pengajuan_Pengujian.docx'
            : 'Template_Surat_Pengajuan_Kunjungan.docx';

        return Response::download($fullPath, $fileName);
    }

    public function preview($type)
    {
        $templateData = $this->getTemplatePreviewData($type);
        return view('user.components.template-preview', compact('templateData', 'type'));
    }

    private function getTemplatePreviewData($type)
    {
        if ($type === 'pengujian') {
            return [
                'title' => 'Template Surat Pengajuan Pengujian',
                'content' => [
                    'header' => [
                        'kop_surat' => 'KOP SURAT INSTITUSI',
                        'alamat' => 'Alamat lengkap institusi',
                        'telepon' => 'Nomor telepon dan email'
                    ],
                    'tujuan' => [
                        'kepada' => 'Kepada Yth.',
                        'nama' => 'Sdr. Ketua Departemen Fisika',
                        'fakultas' => 'Fakultas MIPA USK',
                        'alamat' => 'Darussalam, Banda Aceh'
                    ],
                    'body' => [
                        'perihal' => 'Izin melaksanakan Penelitian',
                        'pembuka' => 'Dengan hormat,',
                        'isi' => 'Bersama ini disampaikan bahwa mahasiswa/staf/peneliti kami merencanakan akan melakukan penelitian di laboratorium saudara. Sehubungan dengan hal tersebut, maka saya mengharapkan kepada saudara untuk mengizinkan mahasiswa/staf/peneliti yang bersangkutan untuk dapat menggunakan fasilitas laboratorium yang saudara pimpin.',
                        'data_fields' => [
                            'Nama/NIM',
                            'No. HP/WA', 
                            'Pembimbing',
                            'Judul',
                            'Rencana Penelitian'
                        ],
                        'penutup' => 'Sebagai informasi kami sampaikan bahwa mahasiswa/staf/peneliti akan mematuhi semua peraturan yang telah ditetapkan oleh laboratorium saudara dan segala sesuatu yang menyebabkan kerugian akan menjadi tanggung jawab mahasiswa/staf/peneliti yang bersangkutan.'
                    ],
                    'footer' => [
                        'tempat_tanggal' => 'Darussalam, tanggal, bulan, tahun',
                        'jabatan' => 'Pimpinan,',
                        'instansi' => 'Instansi',
                        'ttd' => 'Nama\nNIP.'
                    ]
                ]
            ];
        } else {
            return [
                'title' => 'Template Surat Pengajuan Kunjungan',
                'content' => [
                    'header' => [
                        'kop_surat' => 'KOP SURAT INSTITUSI',
                        'alamat' => 'Alamat lengkap institusi',
                        'telepon' => 'Nomor telepon dan email'
                    ],
                    'tujuan' => [
                        'kepada' => 'Kepada Yth.',
                        'nama' => 'Sdr. Ketua Departemen Fisika',
                        'fakultas' => 'Fakultas MIPA USK',
                        'alamat' => 'Darussalam, Banda Aceh'
                    ],
                    'body' => [
                        'perihal' => 'Izin Kunjungan Laboratorium',
                        'pembuka' => 'Dengan hormat,',
                        'isi' => 'Bersama ini kami sampaikan permohonan izin kunjungan ke Laboratorium Fisika Material dan Energi dalam rangka [tujuan kunjungan]. Kunjungan ini direncanakan akan dilaksanakan pada:',
                        'data_fields' => [
                            'Tanggal',
                            'Waktu',
                            'Jumlah Peserta',
                            'Tujuan Kunjungan',
                            'Penanggung Jawab'
                        ],
                        'penutup' => 'Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.'
                    ],
                    'footer' => [
                        'tempat_tanggal' => 'Darussalam, tanggal, bulan, tahun',
                        'jabatan' => 'Pimpinan,',
                        'instansi' => 'Instansi',
                        'ttd' => 'Nama\nNIP.'
                    ]
                ]
            ];
        }
    }
}
