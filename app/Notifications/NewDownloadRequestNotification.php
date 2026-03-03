<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDownloadRequestNotification extends Notification
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
            'message' => 'Ada request download baru dari '.$this->requestData->user->name,
            'url' => route('download.approval'),
        ];
    }
}
