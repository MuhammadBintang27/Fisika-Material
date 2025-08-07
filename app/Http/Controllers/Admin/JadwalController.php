<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        return view('admin.jadwal.index', compact('currentMonth'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'jamMulai' => 'required|date_format:H:i:s',
            'jamSelesai' => 'required|date_format:H:i:s|after:jamMulai',
            'isActive' => 'required|boolean',
        ]);

        try {
            $startTime = Carbon::parse($request->tanggal . ' ' . $request->jamMulai);
            $endTime = Carbon::parse($request->tanggal . ' ' . $request->jamSelesai);

            $overlap = Jadwal::where('tanggal', $request->tanggal)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('jamMulai', [$startTime->toTimeString(), $endTime->toTimeString()])
                          ->orWhereBetween('jamSelesai', [$startTime->toTimeString(), $endTime->toTimeString()])
                          ->orWhere(function ($query) use ($startTime, $endTime) {
                              $query->where('jamMulai', '<=', $startTime->toTimeString())
                                    ->where('jamSelesai', '>=', $endTime->toTimeString());
                          });
                })
                ->exists();

            if ($overlap) {
                return back()->with('error', 'Jadwal bertabrakan dengan jadwal lain pada tanggal tersebut.')->withInput();
            }

            $jadwal = Jadwal::create([
                'tanggal' => $request->tanggal,
                'jamMulai' => $request->jamMulai,
                'jamSelesai' => $request->jamSelesai,
                'isActive' => $request->isActive,
                'kunjunganId' => null,
            ]);
            Log::info("Jadwal created: ID={$jadwal->id}, Date={$request->tanggal}, User=" . auth()->id() . ", IP={$request->ip()}");
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Error creating jadwal: " . $e->getMessage() . ", User=" . auth()->id() . ", IP={$request->ip()}");
            return back()->with('error', 'Gagal menambahkan jadwal: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'jamMulai' => 'required|date_format:H:i:s',
            'jamSelesai' => 'required|date_format:H:i:s|after:jamMulai',
            'isActive' => 'required|boolean',
        ]);

        try {
            $jadwal = Jadwal::findOrFail($id);
            if ($jadwal->is_booked && !$request->isActive) {
                return back()->with('error', 'Tidak dapat menonaktifkan jadwal yang sudah dibooking.')->withInput();
            }

            $startTime = Carbon::parse($request->tanggal . ' ' . $request->jamMulai);
            $endTime = Carbon::parse($request->tanggal . ' ' . $request->jamSelesai);

            $overlap = Jadwal::where('tanggal', $request->tanggal)
                ->where('id', '!=', $id)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('jamMulai', [$startTime->toTimeString(), $endTime->toTimeString()])
                          ->orWhereBetween('jamSelesai', [$startTime->toTimeString(), $endTime->toTimeString()])
                          ->orWhere(function ($query) use ($startTime, $endTime) {
                              $query->where('jamMulai', '<=', $startTime->toTimeString())
                                    ->where('jamSelesai', '>=', $endTime->toTimeString());
                          });
                })
                ->exists();

            if ($overlap) {
                return back()->with('error', 'Jadwal bertabrakan dengan jadwal lain pada tanggal tersebut.')->withInput();
            }

            $jadwal->update([
                'tanggal' => $request->tanggal,
                'jamMulai' => $request->jamMulai,
                'jamSelesai' => $request->jamSelesai,
                'isActive' => $request->isActive,
            ]);
            Log::info("Jadwal updated: ID={$id}, Date={$request->tanggal}, User=" . auth()->id() . ", IP={$request->ip()}");
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating jadwal: " . $e->getMessage() . ", User=" . auth()->id() . ", IP={$request->ip()}");
            return back()->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);
            if ($jadwal->is_booked) {
                return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah dibooking.');
            }
            $jadwal->delete();
            Log::info("Jadwal deleted: ID={$id}, User=" . auth()->id() . ", IP=" . request()->ip());
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting jadwal: " . $e->getMessage() . ", User=" . auth()->id() . ", IP=" . request()->ip());
            return back()->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }

    public static function createDefaultSchedule($date)
    {
        $times = [
            ['jamMulai' => '08:00:00', 'jamSelesai' => '09:00:00'],
            ['jamMulai' => '09:00:00', 'jamSelesai' => '10:00:00'],
            ['jamMulai' => '10:00:00', 'jamSelesai' => '11:00:00'],
            ['jamMulai' => '11:00:00', 'jamSelesai' => '12:00:00'],
            ['jamMulai' => '13:00:00', 'jamSelesai' => '14:00:00'],
            ['jamMulai' => '14:00:00', 'jamSelesai' => '15:00:00'],
            ['jamMulai' => '15:00:00', 'jamSelesai' => '16:00:00'],
        ];

        foreach ($times as $time) {
            Jadwal::create([
                'tanggal' => $date,
                'jamMulai' => $time['jamMulai'],
                'jamSelesai' => $time['jamSelesai'],
                'isActive' => true,
                'kunjunganId' => null,
            ]);
        }
        Log::info("Default schedule created for: $date, User=" . auth()->id() . ", IP=" . request()->ip());
    }

    public function getAvailableSessions(Request $request)
    {
        $date = $request->input('date');
        if (!$date || !Carbon::parse($date)->isValid()) {
            return response()->json(['error' => 'Tanggal tidak valid'], 400);
        }

        try {
            if (Jadwal::where('tanggal', $date)->count() === 0) {
                self::createDefaultSchedule($date);
            }
            $available = Jadwal::where('tanggal', $date)
                ->where('isActive', true)
                ->whereNull('kunjunganId')
                ->orderBy('jamMulai')
                ->get(['id', 'jamMulai', 'jamSelesai']);
            Log::info("Available sessions for $date: " . $available->count() . " sessions, User=" . auth()->id() . ", IP=" . request()->ip());
            return response()->json(['available_sessions' => $available]);
        } catch (\Exception $e) {
            Log::error("Error fetching available sessions: " . $e->getMessage() . ", User=" . auth()->id() . ", IP=" . request()->ip());
            return response()->json(['error' => 'Gagal memuat sesi tersedia: ' . $e->getMessage()], 500);
        }
    }

    public function calendarData(Request $request)
{
    try {
        $month = $request->query('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        // Fetch existing schedules
        $schedules = Jadwal::with('kunjungan')
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->orderBy('tanggal')
            ->orderBy('jamMulai')
            ->get()
            ->groupBy('tanggal');

        $calendarData = [];
        $today = Carbon::today()->toDateString();
        
        // Generate all days in the month
        $currentDate = $startOfMonth->copy();
        while ($currentDate <= $endOfMonth) {
            $date = $currentDate->toDateString();
            $daySchedules = $schedules->get($date, collect([])); // Get schedules or empty collection

            $hasBookings = $daySchedules->contains('kunjunganId');
            $bookingInfo = $hasBookings ? $daySchedules->whereNotNull('kunjunganId')->pluck('kunjungan.namaPengunjung')->implode(', ') : '';

            $calendarData[] = [
                'day' => $currentDate->day,
                'date' => $date,
                'isToday' => $date === $today,
                'isPast' => $currentDate->isPast(),
                'hasBookings' => $hasBookings,
                'bookingInfo' => $bookingInfo,
                'schedules' => $daySchedules->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'isActive' => $schedule->isActive,
                        'isBooked' => $schedule->is_booked,
                        'timeLabel' => $schedule->time_label,
                        'kunjungan' => $schedule->kunjungan ? [
                            'namaPengunjung' => $schedule->kunjungan->namaPengunjung,
                            'isCompleted' => $schedule->kunjungan->status === 'COMPLETED',
                        ] : null,
                    ];
                })->toArray(),
            ];

            $currentDate->addDay();
        }

        Log::info('Calendar data generated for ' . $month . ': ' . count($calendarData) . ' days, User=' . auth()->id() . ', IP=' . request()->ip());
        return response()->json($calendarData);
    } catch (\Exception $e) {
        Log::error('Error in calendarData: ' . $e->getMessage() . ', User=' . auth()->id() . ', IP=' . request()->ip());
        return response()->json(['error' => 'Gagal memuat data kalender: ' . $e->getMessage()], 500);
    }
}

    public function scheduleSettings(Request $request)
    {
        try {
            $date = $request->query('date');
            if (!$date || !Carbon::parse($date)->isValid()) {
                return response()->json(['error' => 'Tanggal tidak valid'], 400);
            }

            if (Jadwal::where('tanggal', $date)->count() === 0) {
                self::createDefaultSchedule($date);
            }

            $schedules = Jadwal::with('kunjungan')
                ->where('tanggal', $date)
                ->orderBy('jamMulai')
                ->get()
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'timeLabel' => $schedule->time_label,
                        'isActive' => $schedule->isActive,
                        'isBooked' => $schedule->is_booked,
                        'kunjungan' => $schedule->kunjungan ? [
                            'namaPengunjung' => $schedule->kunjungan->namaPengunjung,
                            'isCompleted' => $schedule->kunjungan->status === 'COMPLETED',
                        ] : null,
                    ];
                });

            Log::info("Schedule settings for $date: " . $schedules->count() . " schedules, User=" . auth()->id() . ", IP=" . request()->ip());
            return response()->json(['schedules' => $schedules]);
        } catch (\Exception $e) {
            Log::error('Error in scheduleSettings: ' . $e->getMessage() . ', User=' . auth()->id() . ', IP=' . request()->ip());
            return response()->json(['error' => 'Gagal memuat pengaturan jadwal: ' . $e->getMessage()], 500);
        }
    }

    public function toggleAvailability(Request $request)
    {
        try {
            $request->validate([
                'scheduleId' => 'required|exists:jadwal,id',
                'isActive' => 'required|boolean',
            ]);

            return DB::transaction(function () use ($request) {
                $jadwal = Jadwal::lockForUpdate()->findOrFail($request->scheduleId);
                if ($jadwal->is_booked && !$request->isActive) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat menonaktifkan jadwal yang sudah dibooking.'], 422);
                }

                $jadwal->update(['isActive' => $request->isActive]);
                Log::info("Toggled schedule availability: ID={$request->scheduleId}, isActive={$request->isActive}, User=" . auth()->id() . ", IP=" . request()->ip());
                return response()->json(['success' => true, 'message' => 'Jadwal berhasil diperbarui.']);
            });
        } catch (\Exception $e) {
            Log::error('Error in toggleAvailability: ' . $e->getMessage() . ', User=' . auth()->id() . ', IP=' . request()->ip());
            return response()->json(['error' => 'Gagal mengubah ketersediaan jadwal: ' . $e->getMessage()], 500);
        }
    }
}