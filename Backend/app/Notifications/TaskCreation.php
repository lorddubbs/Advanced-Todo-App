<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreation extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $task)
    {
        $this->user = $user;
        $this->task = $task; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("Your TASK ".$this->task->title." has been created")
                    ->action("View Task", url(config('app.frontend').'/task'.'/'.$this->task->id.'/'.$this->task->slug))
                    ->line('Cmon, you got this!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Task ".$this->task->title." starts ".$this->task->created_at,
            'link' => url(config('app.frontend').'/task'.'/'.$this->task->slug),
            'notification_type' => "Task Creation"
        ];
    }
}
