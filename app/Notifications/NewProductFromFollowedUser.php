<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductFromFollowedUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $item;

    // 2. RECIBIR EL ITEM EN EL CONSTRUCTOR
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function via(object $notifiable): array
    {
        // Guardamos en la base de datos para que aparezca en la "campanita"
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'item_name' => $this->item->name,
            'user_name' => $this->item->user->name,
            'message' => 'ha publicado un nuevo producto: '.$this->item->name,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
}
