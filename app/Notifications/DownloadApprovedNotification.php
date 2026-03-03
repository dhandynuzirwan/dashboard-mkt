<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DownloadApprovedNotification extends Notification
{
    use Queueable;

    protected $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'request_id' => $this->requestData->id,
            'message' => 'Request download kamu sudah disetujui',
            'url' => route('download.my'),
        ];
    }
}
