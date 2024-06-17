<?php

namespace App\Notifications\Leave;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification
{
    use Queueable;

     /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $receivedUser, User $sentUser)
    {    
        $this->receivedUser = $receivedUser;
        $this->sentUser = $sentUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => "Leave Request",
            'text' =>"Leave requested by " . $this->sentUser->name, 
            'receiver_id' => $this->receivedUser->id,
            'sender_id' => $this->sentUser->id,
        ];
    }
}
