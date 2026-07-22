<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FingerspotService;
use App\Models\User;
use App\Models\AbsensiLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SyncFingerspot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:sync {--days=1 : Number of past days to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize attendance data from Fingerspot API';

    /**
     * Execute the console command.
     */
    public function handle(FingerspotService $fingerspotService)
    {
        $this->info('Starting Fingerspot Synchronization...');
        $days = (int) $this->option('days');
        
        $successCount = 0;
        
        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $this->info("Fetching data for date: {$date}");
            
            $data = $fingerspotService->getAttendanceLog($date);
            
            if ($data === null) {
                $this->error("Failed to fetch data for {$date}");
                continue;
            }
            
            if (empty($data)) {
                $this->info("No data found for {$date}");
                continue;
            }

            $scansData = [];
            
            // Parse data
            foreach ($data as $row) {
                // $row['PIN'] usually maps to fingerspot_id
                $pin = $row['PIN'] ?? null;
                $dateTime = $row['Date Time'] ?? null; // e.g. "2024-08-05 08:00" or similar depending on property
                
                if (!$pin || !$dateTime) continue;
                
                $user = User::where('fingerspot_id', $pin)->first();
                if ($user) {
                    try {
                        $parsedTime = Carbon::parse($dateTime);
                        $scansData[$user->id][$parsedTime->format('Y-m-d')][] = $parsedTime->format('H:i:s');
                    } catch (\Exception $e) {
                        Log::error("Failed to parse time: $dateTime");
                    }
                }
            }

            // Save to DB
            foreach ($scansData as $userId => $dates) {
                foreach ($dates as $tanggal => $times) {
                    $times = array_unique($times);
                    sort($times);

                    $jamMasuk = $times[0];
                    $jamPulang = count($times) > 1 ? end($times) : null;

                    // Simpan Masuk
                    AbsensiLog::updateOrCreate(
                        ['user_id' => $userId, 'tanggal' => $tanggal, 'tipe' => 'in'],
                        ['jam' => $jamMasuk, 'source' => 'api']
                    );
                    $successCount++;

                    // Simpan Pulang
                    if ($jamPulang) {
                        AbsensiLog::updateOrCreate(
                            ['user_id' => $userId, 'tanggal' => $tanggal, 'tipe' => 'out'],
                            ['jam' => $jamPulang, 'source' => 'api']
                        );
                        $successCount++;
                    }
                }
            }
        }

        $this->info("Sync completed! Successfully synced $successCount records.");
        Log::info("Fingerspot auto sync completed. Records updated: $successCount");
    }
}
