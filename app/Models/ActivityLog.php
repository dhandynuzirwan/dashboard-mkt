<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action_name',
        'type',
        'color',
        'item_count',
        'title_template',
        'title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper statis untuk melog aktivitas dengan mass-grouping.
     *
     * @param string $actionName Identifier unik dari aksi (e.g. 'insert_modul')
     * @param string $type       Label modul (e.g. 'Marketing', 'Modul')
     * @param string $color      Warna (e.g. 'info', 'success', 'primary')
     * @param string $titleTemplate Template judul dengan placeholder {count} (e.g. 'Anda mengunggah {count} modul baru')
     * @param int $minutes       Waktu grouping, default 15 menit. Jika user yang sama melakukan action yang sama dalam X menit, akan digabung.
     */
    public static function log(string $actionName, string $type, string $color, string $titleTemplate, int $minutes = 15)
    {
        $userId = Auth::id();
        if (!$userId) {
            $firstUser = User::first();
            $userId = $firstUser ? $firstUser->id : null;
        }

        $recentLog = self::where('user_id', $userId)
            ->where('action_name', $actionName)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->orderBy('created_at', 'desc')
            ->first();

        if ($recentLog) {
            $recentLog->item_count += 1;
            $recentLog->title = str_replace('{count}', $recentLog->item_count, $recentLog->title_template);
            $recentLog->updated_at = now();
            $recentLog->save();
        } else {
            self::create([
                'user_id' => $userId,
                'action_name' => $actionName,
                'type' => $type,
                'color' => $color,
                'item_count' => 1,
                'title_template' => $titleTemplate,
                'title' => str_replace('{count}', 1, $titleTemplate),
            ]);
        }
    }
}
