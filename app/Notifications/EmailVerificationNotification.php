<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $token = random_int(100000, 999999);

        // Salva o token no banco de dados
        DB::table('email_verifications')->updateOrInsert(
            ['email' => $notifiable->email],
            [
                'token' => hash('sha256', $token), // Token hash para segurança
                'expires_at' => now()->addMinutes(60), // Token expira em 1 hora
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $verificationUrl = url('/verify-email?token='.$token);

        return (new MailMessage)
            ->subject('Confirme seu e-mail')
            ->line('Use o seguinte código para verificar seu endereço de e-mail:')
            ->line("**{$token}**")
            ->line('Se você não solicitou esta ação, ignore este e-mail.');
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
