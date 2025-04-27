<?php

namespace App\Notifications;

use App\Models\UserInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserInterest extends Notification
{
    use Queueable;

    protected $userInterest;

    public function __construct(UserInterest $userInterest)
    {
        $this->userInterest = $userInterest;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can add 'database' for in-app notifications
    }

    public function toMail($notifiable)
    {
        $itemName = $this->userInterest->interest->title_ar ?? $this->userInterest->interest->word_ar ?? 'غير معروف';

        return (new MailMessage)
                    ->subject('إهتمام جديد مضاف')
                    ->line('المستخدم ' . ($this->userInterest->user->name ?? 'غير معروف') . ' أضاف إهتمامًا جديدًا.')
                    ->line('نوع الإهتمام: ' . $this->userInterest->interest_type_name)
                    ->line('العنصر: ' . $itemName)
                    ->action('عرض التفاصيل', route('admin.user_interests.show', $this->userInterest->id))
                    ->line('شكرًا لاستخدامك النظام!');
    }
}