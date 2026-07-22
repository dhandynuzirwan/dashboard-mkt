<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FingerspotService
{
    protected $cloudId;
    protected $apiKey;

    public function __construct()
    {
        $this->cloudId = config('services.fingerspot.cloud_id');
        $this->apiKey = config('services.fingerspot.api_key');
    }

    /**
     * Get attendance log from Fingerspot.io
     *
     * @param string $date Date in Y-m-d format (e.g. 2024-08-05)
     * @return array|null Array of data or null on failure
     */
    public function getAttendanceLog($date)
    {
        if (empty($this->cloudId) || empty($this->apiKey)) {
            Log::error('Fingerspot API configuration is missing.');
            return null;
        }

        // Parameters
        $attendanceUpload = $date; 
        $formatDate = '0'; // 0 defaults to Y-m-d H:i:s
        $property = 'date_time'; // sorting property
        $direction = 'asc'; // direction
        $exportType = 'json'; // JSON format
        $currentTime = Carbon::now()->format('YmdHis'); // yyyyMMddhhmmss

        // Generate Auth (MD5)
        // MD5(Cloud_ID[tanpa_spasi] attendance_upload [tanpa_spasi] current_time [tanpa_spasi] kode_API_KEY)
        $authString = $this->cloudId . $attendanceUpload . $currentTime . $this->apiKey;
        $auth = md5($authString);

        // Build URL
        $baseUrl = 'https://api.fingerspot.io/api/download/attendance_log';
        $url = sprintf('%s/%s/%s/%s/%s/%s/%s/%s/%s', 
            $baseUrl, 
            $this->cloudId, 
            $attendanceUpload, 
            $formatDate, 
            $property, 
            $direction, 
            $exportType, 
            $auth, 
            $currentTime
        );

        try {
            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['success']) && $responseData['success'] === true) {
                    return $responseData['data'] ?? [];
                } else {
                    Log::error('Fingerspot API Error: ' . json_encode($responseData));
                    return null;
                }
            } else {
                Log::error('Fingerspot API HTTP Error: ' . $response->status() . ' - ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Fingerspot API Exception: ' . $e->getMessage());
            return null;
        }
    }
}
