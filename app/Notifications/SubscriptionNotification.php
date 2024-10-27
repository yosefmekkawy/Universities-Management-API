<?php

namespace App\Notifications;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
//        return ['mail'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        $subject = Subject::query()->with('user')->find($this->data->subject_id);
        $data = [
            'data' => json_encode([
                'ar' =>'تم اضافة اشتراك جديد في مادة '.
                    json_decode($subject->name,true)['ar'].
                    'تبع دكتور '.
                    $subject->user->username,
                'en'=> 'New Subscription added at subject '. $subject->id],JSON_UNESCAPED_SLASHES),
            'sender_id' => $subject->user->id
        ];
        return $data;
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
