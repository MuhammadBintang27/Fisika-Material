<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataPengurus;
use App\Models\Gambar;

class StaffController extends Controller
{
    public function index()
    {
        $staff = BiodataPengurus::with(['gambar' => function($q) {
            $q->where('kategori', 'PENGURUS');
        }])->get();

        // Ambil semua jabatan unik dan hitung jumlahnya
        $jabatanList = $staff->groupBy('jabatan')->map(function($group) {
            return $group->count();
        });

        $stats = [
            'total_staff' => $staff->count(),
            'jabatan_list' => $jabatanList,
        ];

        return view('user.staff.staff', compact('staff', 'stats'));
    }

    public function show($id)
    {
        $staff = BiodataPengurus::with(['gambar' => function($q) {
            $q->where('kategori', 'PENGURUS');
        }])->findOrFail($id);
        return view('user.staff.staff.show', compact('staff'));
    }
}