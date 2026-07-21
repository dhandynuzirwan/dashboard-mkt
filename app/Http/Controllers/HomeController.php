<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AbsensiLog;
use App\Models\DailyLog;
use App\Models\Perizinan;
use App\Models\ModulPelatihan;
use App\Models\Holiday;
use App\Models\Pengumuman;
use App\Models\PelatihanBerjalan;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 1. Logika Papan Pengumuman
        $pengumuman = Pengumuman::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 2. Logika Aktivitas Feed (Timeline)
        $feedQuery = \App\Models\ActivityLog::query();
        
        if (in_array($user->role, ['spv', 'spv_marketing', 'superadmin'])) {
            $targetRoles = ['rnd', 'admin', 'admin_marketing'];
            $otherIds = \App\Models\User::whereIn('role', $targetRoles)->pluck('id')->toArray();
            $targetIds = array_merge([$user->id], $otherIds);
            $feedQuery->whereIn('user_id', $targetIds);
        } else {
            $feedQuery->where('user_id', $user->id);
        }

        $feed = $feedQuery->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($log) {
                $userActor = \App\Models\User::find($log->user_id);
                $actorName = $userActor ? ($userActor->nama_lengkap ?? $userActor->name) : 'Sistem';
                
                return [
                    'type' => $log->type,
                    'color' => $log->color,
                    'title' => $log->title . ' (' . $actorName . ')',
                    'time' => $log->updated_at,
                ];
            });

        // 2.5 Cek Keterangan Hari Ini (Cuti/Sakit/Holiday)
        $todayStr = $now->format('Y-m-d');
        $statusHariIni = null;
        
        $liburHariIni = Holiday::where('tanggal', $todayStr)->first();
        if ($liburHariIni) {
            $statusHariIni = [
                'tipe' => 'Holiday',
                'keterangan' => $liburHariIni->keterangan,
                'color' => 'danger',
                'icon' => 'fas fa-calendar-day'
            ];
        } else {
            $izinHariIni = Perizinan::where('user_id', $user->id)
                ->where('tanggal', $todayStr)
                ->where('status', 'approved')
                ->first();
            if ($izinHariIni) {
                $tipeIzin = strtolower($izinHariIni->tipe ?? 'izin'); // fallback if tipe is not available directly, wait Perizinan table structure
                $statusHariIni = [
                    'tipe' => ucfirst($tipeIzin), // e.g. Sakit, Cuti
                    'keterangan' => $izinHariIni->keterangan,
                    'color' => 'warning',
                    'icon' => 'fas fa-procedures'
                ];
                if (in_array(strtolower($tipeIzin), ['cuti', 'izin'])) {
                    $statusHariIni['icon'] = 'fas fa-plane-departure';
                }
            }
        }

        // 3. Logika Absensi Pribadi Bulan Ini
        $absensi = AbsensiLog::where('user_id', $user->id)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->get()
            ->unique('tanggal');

        $hadir = 0;
        $telat = 0;

        foreach ($absensi as $log) {
            // Kita skip jika tipenya bukan 'in' (Masuk)
            if (isset($log->tipe) && strtolower($log->tipe) !== 'in') continue;

            if ($log->jam <= '07:30:00') {
                $hadir++;
            } else {
                $telat++;
            }
        }

        // Kalkulasi Hari Kerja (Senin-Jumat) dari tgl 1 s.d hari ini
        $startOfMonth = $now->copy()->startOfMonth();
        $today = $now->copy();
        
        $workDays = 0;
        $currentDate = $startOfMonth->copy();
        while ($currentDate <= $today) {
            if (!$currentDate->isWeekend()) {
                $workDays++;
            }
            $currentDate->addDay();
        }

        // Kurangi libur nasional
        $holidaysCount = Holiday::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('tanggal', '<=', $today->format('Y-m-d'))
            ->count();
        
        $workDays -= $holidaysCount;
        if ($workDays < 0) $workDays = 0;

        $absen = $workDays - ($hadir + $telat);
        if ($absen < 0) $absen = 0;

        $attendanceRate = $workDays > 0 ? round((($hadir + $telat) / $workDays) * 100) : 100;

        // 4. Logika Kalender Dinamis
        $calendarEvents = [];
        $upcomingAgendas = collect();

        // Libur
        $holidays = Holiday::whereMonth('tanggal', $now->month)->whereYear('tanggal', $now->year)->get();
        foreach ($holidays as $h) {
            $day = Carbon::parse($h->tanggal)->day;
            $calendarEvents[$day] = 'danger'; // merah
            $upcomingAgendas->push([
                'title' => Str::limit($h->keterangan, 30),
                'date' => Carbon::parse($h->tanggal),
                'color' => 'danger'
            ]);
        }

        // Pengumuman Event
        foreach ($pengumuman as $p) {
            if ($p->tanggal_event) {
                $eventDate = Carbon::parse($p->tanggal_event);
                if ($eventDate->month == $now->month && $eventDate->year == $now->year) {
                    $day = $eventDate->day;
                    $color = $p->kategori == 'hari_besar' ? 'success' : ($p->kategori == 'urgent' ? 'danger' : 'primary');
                    $calendarEvents[$day] = $color;
                }
                $color = $p->kategori == 'hari_besar' ? 'success' : ($p->kategori == 'urgent' ? 'danger' : 'primary');
                $upcomingAgendas->push([
                    'title' => Str::limit($p->judul, 30),
                    'date' => $eventDate,
                    'color' => $color
                ]);
            }
        }

        // Pelatihan Berjalan
        $pelatihans = PelatihanBerjalan::with('training')
            ->whereMonth('tanggal_pelatihan', $now->month)
            ->get();
            
        foreach ($pelatihans as $pel) {
            if ($pel->tanggal_pelatihan) {
                $day = Carbon::parse($pel->tanggal_pelatihan)->day;
                $calendarEvents[$day] = 'warning';
                $upcomingAgendas->push([
                    'title' => 'Training: ' . Str::limit($pel->training->nama_pelatihan ?? 'Tanpa Nama', 20),
                    'date' => Carbon::parse($pel->tanggal_pelatihan),
                    'color' => 'warning'
                ]);
            }
        }

        $upcomingAgendas = $upcomingAgendas->filter(function($item) use ($now) {
            return $item['date']->format('Y-m-d') >= $now->format('Y-m-d');
        })->sortBy('date')->take(3);

        // Tambahkan Tanggal Kontrak Berakhir jika ada
        if ($user->tanggal_kontrak_berakhir) {
            $kontrakEnd = Carbon::parse($user->tanggal_kontrak_berakhir);
            if ($kontrakEnd->month == $now->month && $kontrakEnd->year == $now->year) {
                $calendarEvents[$kontrakEnd->day] = 'danger'; // Merah
            }
            if ($kontrakEnd->format('Y-m-d') >= $now->format('Y-m-d')) {
                $upcomingAgendas->push([
                    'title' => 'Kontrak Berakhir',
                    'date' => $kontrakEnd,
                    'color' => 'danger'
                ]);
                $upcomingAgendas = $upcomingAgendas->sortBy('date')->take(3); // Re-sort and take top 3
            }
        }

        
        // ================= QUICK ACCESS LOGIC =================
        $userRole = $user->role ?? 'karyawan';
        $quickAccess = [];
        
        // 1. Fetch top 4 visited routes from database
        $topVisits = \App\Models\UserPageVisit::where('user_id', $user->id)
            ->orderBy('visits', 'desc')
            ->take(4)
            ->get();
            
        $trackableRoutes = config('quickaccess', []);
        
        foreach ($topVisits as $visit) {
            $routeName = $visit->route_name;
            if (isset($trackableRoutes[$routeName]) && \Illuminate\Support\Facades\Route::has($routeName)) {
                $item = $trackableRoutes[$routeName];
                $item['route'] = route($routeName);
                $quickAccess[] = $item;
            }
        }
        
        // 2. If less than 4, fill with defaults
        if (count($quickAccess) < 4) {
            $defaultRoutes = [];
            if ($userRole == 'superadmin') {
                $defaultRoutes = ['dashboard.progress', 'simulasi-gaji', 'riwayat.pelatihan', 'absensi'];
            } elseif ($userRole == 'spv' || $userRole == 'spv_marketing') {
                $defaultRoutes = ['dashboard.progress', 'pipeline', 'revenue', 'operational.data-pendaftaran'];
            } elseif (in_array($userRole, ['admin', 'rnd', 'digitalmarketing'])) {
                $defaultRoutes = ['dashboard.progress', 'data-masuk.index', 'pipeline', 'master-training.index'];
            } elseif (in_array($userRole, ['operasional', 'graphic', 'team_leader', 'web_dev'])) {
                $defaultRoutes = ['operational.aktivitas-harian', 'operational.data-pendaftaran', 'monitoring.pelatihan', 'riwayat.pelatihan'];
            } elseif ($userRole == 'marketing') {
                $defaultRoutes = ['pipeline', 'simulasi-gaji', 'revenue', 'data-kpi'];
            } else {
                $defaultRoutes = ['absensi', 'pengajuan-izin.index'];
            }
            
            $existingRoutes = array_column($quickAccess, 'route');
            
            foreach ($defaultRoutes as $defRouteName) {
                if (count($quickAccess) >= 4) break;
                
                if (isset($trackableRoutes[$defRouteName]) && \Illuminate\Support\Facades\Route::has($defRouteName)) {
                    $defRoute = route($defRouteName);
                    if (!in_array($defRoute, $existingRoutes)) {
                        $item = $trackableRoutes[$defRouteName];
                        $item['route'] = $defRoute;
                        $quickAccess[] = $item;
                        $existingRoutes[] = $defRoute;
                    }
                }
            }
        }

        // 2.6 Logika Permintaan Perizinan (Hanya untuk superadmin)
        $pendingPerizinan = collect([]);
        if (in_array($userRole, ['superadmin'])) {
            $cutis = \App\Models\Perizinan::where('status', 'pending')->with('user')->get()->map(function($c) {
                return [
                    'tipe' => 'Izin Cuti/Absen',
                    'nama' => $c->user->nama_lengkap ?? $c->user->name,
                    'waktu' => $c->created_at,
                    'color' => 'warning'
                ];
            });
            $unduhs = \App\Models\DownloadRequest::where('status', 'pending')->with('user')->get()->map(function($d) {
                return [
                    'tipe' => 'Izin Unduh Data',
                    'nama' => $d->user->nama_lengkap ?? $d->user->name,
                    'waktu' => $d->created_at,
                    'color' => 'info'
                ];
            });
            // Akses Halaman (Dummy)
            $akses = collect([
                [
                    'tipe' => 'Izin Akses Halaman',
                    'nama' => 'Jhon Doe (Dummy)',
                    'waktu' => now()->subHours(2),
                    'color' => 'danger'
                ]
            ]);

            $pendingPerizinan = $cutis->concat($unduhs)->concat($akses)->sortByDesc('waktu')->take(5);
        }

        return view('home', compact('quickAccess', 
            'pengumuman', 'feed', 'hadir', 'telat', 'absen', 'attendanceRate', 'calendarEvents', 'upcomingAgendas', 'statusHariIni', 'pendingPerizinan'
        ));
    }
}
