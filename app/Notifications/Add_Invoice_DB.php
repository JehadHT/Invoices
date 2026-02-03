<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class Add_Invoice_DB extends Notification
{
    use Queueable;
    private $invoice_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'id'=> $this->invoice_id,
            'title'   => 'فاتورة جديدة',
            'message' => 'تم إنشاء فاتورة جديدة بنجاح بواسطة:',
            'user' => Auth::user()->name,
        ];
    }

}
