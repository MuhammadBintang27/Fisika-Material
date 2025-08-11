<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\ProfilLaboratorium;
use App\Models\BiodataPengurus;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_articles' => Artikel::count(),
            'total_equipment' => Alat::count(),
            'pending_loans' => Peminjaman::where('status', 'PENDING')->count(),
            'total_staff' => BiodataPengurus::count(),
            'total_jenis_pengujian' => \App\Models\JenisPengujian::count(),
            'total_pengujian' => \App\Models\Pengujian::count(),
            'total_admins' => User::where('is_admin', true)->orWhere('is_super_admin', true)->count(),
            'total_super_admins' => User::where('is_super_admin', true)->count(),
        ];

        $recentLoans = Peminjaman::with('items.alat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentArticles = Artikel::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLoans', 'recentArticles'));
    }

    public function login()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            if (auth()->user()->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            } else {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses admin.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
} 
 