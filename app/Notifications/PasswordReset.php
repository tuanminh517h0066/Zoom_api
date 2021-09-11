<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordReset extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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

        $link = url(config('app.url'). route('password.reset.token', [$this->token, urlencode($notifiable->email)], false));

        return ( new MailMessage )
          //->view('auth.emails.password')
          ->from('info@kick-start.jp', '起業家実践会運営事務局')
          ->subject( $notifiable->last_name . $notifiable->first_name .'様へのパスワードリセット確認' )
          ->line( $notifiable->last_name . $notifiable->first_name . "様" )
          ->line( "" )
          ->line( "いつもRNをご利用いただきありがとうございます。" )
          ->line( "お客様のアカウントのパスワード変更についてリクエストを承りました。" )
          ->line( "このパスワード変更リクエストが間違いない場合は、次のリンクをクリックしてお持ちのパスワードをリセットしてください。" )
          ->action( 'パスワードリセット', $link )
          ->line( "リンクをクリックしても何も起こらない場合には、お手数ですが代わりに、リンクURLの全てをお使いのブラウザへコピー＆ペーストしアクセスください。" )
          ->line( "万一、このリクエストがお客様による物で無い場合には、このメッセージを無視して頂ければパスワードは変更されません。")
          
          //->attach('reset.attachment')
          ->line( '以上、よろしくお願いいたします。' );
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
