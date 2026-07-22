<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDealNotification extends Notification
{
    use Queueable;

    protected $cta;
    protected $prospek;

    public function __construct($cta, $prospek)
    {
        $this->cta = $cta;
        $this->prospek = $prospek;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_deal',
            'message' => 'Ada Deal Baru dari ' . ($this->prospek->perusahaan ?? 'Perusahaan'),
            'cta_id' => $this->cta->id,
            'prospek_id' => $this->prospek->id,
        ];
    }
}
