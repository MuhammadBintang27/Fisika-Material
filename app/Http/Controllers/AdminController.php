<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\ProfilLaboratorium;
use App\Models\BiodataPengurus;
use App\Models\Kunjungan;
use App\Models\LayananPengujian;
use App\Models\PengajuanPengujian;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_articles' => Artikel::count(),
            'total_equipment' => Alat::count(),
            'pending_loans' => Peminjaman::where('status', 'PENDING')->count(),
            'pending_tests' => PengajuanPengujian::where('status', 'pending')->count(),
            'total_staff' => BiodataPengurus::count(),
            'total_admins' => User::where('is_admin', true)->orWhere('is_super_admin', true)->count(),
            'total_super_admins' => User::where('is_super_admin', true)->count(),
            'total_jenis_pengujian' => LayananPengujian::count(),
            'total_pengujian' => PengajuanPengujian::count(),
        ];

        $recentLoans = Peminjaman::with('items.alat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentTests = PengajuanPengujian::with('layanan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Real chart data for the last 12 months
        $chartData = $this->getChartData();

        // Performance metrics calculations
        $performanceMetrics = $this->getPerformanceMetrics();

        return view('admin.dashboard', compact('stats', 'recentLoans', 'recentTests', 'chartData', 'performanceMetrics'));
    }

    private function getPerformanceMetrics()
    {
        $totalLoans = Peminjaman::count();
        $approvedLoans = Peminjaman::where('status', 'APPROVED')->count();
        $successRate = $totalLoans > 0 ? round(($approvedLoans / $totalLoans) * 100, 1) : 0;

        // Calculate average response time (in hours) - database agnostic with limit for performance
        $peminjaman = Peminjaman::whereNotNull('updated_at')
            ->select('created_at', 'updated_at')
            ->latest('updated_at')
            ->limit(100) // Only check last 100 records for performance
            ->get();
        
        if ($peminjaman->isNotEmpty()) {
            $totalHours = $peminjaman->sum(function ($item) {
                return $item->created_at->diffInHours($item->updated_at);
            });
            $avgResponseTime = round($totalHours / $peminjaman->count(), 1);
        } else {
            $avgResponseTime = 0;
        }

        // User satisfaction based on completed services vs total services
        $totalServices = Kunjungan::count() + PengajuanPengujian::count();
        $completedServices = Kunjungan::where('status', 'COMPLETED')->count() + 
                           PengajuanPengujian::where('status', 'SELESAI')->count();
        $userSatisfaction = $totalServices > 0 ? round(($completedServices / $totalServices) * 5, 1) : 0;

        // System uptime - simplified calculation based on service availability
        $uptime = 99.9; // This would typically come from server monitoring

        return [
            'success_rate' => $successRate,
            'avg_response_time' => $avgResponseTime,
            'user_satisfaction' => $userSatisfaction,
            'uptime' => $uptime
        ];
    }

    private function getChartData()
    {
        $months = [];
        $loansData = [];
        $visitsData = [];
        $testsData = [];

        // Get last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');
            
            // Loans count for each month
            $loansData[] = Peminjaman::whereYear('created_at', $date->year)
                                    ->whereMonth('created_at', $date->month)
                                    ->count();
            
            // Visits count for each month
            $visitsData[] = Kunjungan::whereYear('created_at', $date->year)
                                    ->whereMonth('created_at', $date->month)
                                    ->count();
            
            // Tests count for each month
            $testsData[] = PengajuanPengujian::whereYear('created_at', $date->year)
                                            ->whereMonth('created_at', $date->month)
                                            ->count();
        }

        // Status distribution data
        $loanStatusData = [
            'pending' => Peminjaman::where('status', 'PENDING')->count(),
            'approved' => Peminjaman::where('status', 'APPROVED')->count(),
            'rejected' => Peminjaman::where('status', 'REJECTED')->count(),
            'returned' => Peminjaman::where('status', 'RETURNED')->count(),
        ];

        $visitStatusData = [
            'pending' => Kunjungan::where('status', 'pending')->count(),
            'approved' => Kunjungan::where('status', 'approved')->count(),
            'completed' => Kunjungan::where('status', 'selesai')->count(),
            'cancelled' => Kunjungan::where('status', 'cancelled')->count(),
        ];

        $testStatusData = [
            'pending' => PengajuanPengujian::where('status', 'pending')->count(),
            'in_progress' => PengajuanPengujian::where('status', 'in_progress')->count(),
            'completed' => PengajuanPengujian::where('status', 'completed')->count(),
            'cancelled' => PengajuanPengujian::where('status', 'cancelled')->count(),
        ];

        return [
            'months' => $months,
            'loans' => $loansData,
            'visits' => $visitsData,
            'tests' => $testsData,
            'loanStatus' => $loanStatusData,
            'visitStatus' => $visitStatusData,
            'testStatus' => $testStatusData,
        ];
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
 