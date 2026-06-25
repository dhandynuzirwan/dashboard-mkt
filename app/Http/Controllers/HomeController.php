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
        $feed = \App\Models\ActivityLog::orderBy('updated_at', 'desc')->take(5)->get()->map(function($log) {
            return [
                'type' => $log->type,
                'color' => $log->color,
                'title' => $log->title,
                'time' => $log->updated_at,
            ];
        });

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

        return view('home', compact(
            'pengumuman', 'feed', 'hadir', 'telat', 'absen', 'attendanceRate', 'calendarEvents', 'upcomingAgendas'
        ));
    }
}
