<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TodoAffected extends Notification
{
    use Queueable;
    public $todo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($todo)
    {
        $this->todo = $todo;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('diawa727@gmail.com','Todo Project')
                    ->subject('Tu as une nouvelle todo a finir')
                    ->line("la todo(#".$this->todo->id.")'"."'vient d'etre affecte par".$this->todo->todoAffectedBy->name.".")
                    ->line('The introduction to the notification.')
                    ->action('Voir toutes mes todos', url('/todos'))
                    ->line("Merci d'utiliser notre applicatopn!");
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
            'todo_id' => $this->todo->id,
            'affected_by' => $this->todo->todoAffectedBy->name,
            'todo_name' => $this->todo->name

        ];
    }
}
