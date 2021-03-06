<?php

namespace DummyNamespace;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DummyClass extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace DummyNamespace;

use NamespacedDummyModel;

class DummyClass
{
    /**
     * Handle the DocDummyModel "created" event.
     *
     * @param  \NamespacedDummyModel  $dummyModel
     * @return void
     */
    public function created(DummyModel $dummyModel)
    {
        //
    }

    /**
     * Handle the DocDummyModel "updated" event.
     *
     * @param  \NamespacedDummyModel  $dummyModel
     * @return void
     */
    public function updated(DummyModel $dummyModel)
    {
        //
    }

    /**
     * Handle the DocDummyModel "deleted" event.
     *
     * @param  \NamespacedDummyModel  $dummyModel
     * @return void
     */
    public function deleted(DummyModel $dummyModel)
    {
        //
    }

    /**
     * Handle the DocDummyModel "restored" event.
     *
     * @param  \NamespacedDummyModel  $dummyModel
     * @return void
     */
    public function restored(DummyModel $dummyModel)
    {
        //
    }

    /**
     * Handle the DocDummyModel "force deleted" event.
     *
     * @param  \NamespacedDummyModel  $dummyModel
     * @return void
     */
    public function forceDeleted(DummyModel $dummyModel)
    {
        //
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                