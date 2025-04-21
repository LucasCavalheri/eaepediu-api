<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\AwsSns\SnsChannel;
use NotificationChannels\AwsSns\SnsMessage;

class ForgotPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public int $token, public string $frontendUrl)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return $this->method === 'email' ? ['mail'] : [SnsChannel::class];
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->frontendUrl . '/reset-password?token=' . $this->token;

        return (new MailMessage)
            ->subject('Recuperação de Senha')
            ->line('Clique no link abaixo para recuperar sua senha')
            ->action('Redefinir Senha', $url)
            ->line('Se você não solicitou esta recuperação, ignore este e-mail.');
    }

    // public function toSns(object $notifiable)
    // {
    //     $token = $this->token;
    //     return SnsMessage::create([
    //         'subject' => 'Recuperação de Senha',
    //         'body' => "Seu token de redefinição de senha é: {$token}",
    //     ]);
    // }

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
