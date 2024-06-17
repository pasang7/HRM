<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $random_password;
    protected $random_pin;
    protected $user;
    protected $url;
    public function __construct($user,$random_password,$random_pin,$url)
    {
        $this->random_password=$random_password;
        $this->random_pin=$random_pin;
        $this->user=$user;
        $this->url=$url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.user.register')
                    ->with('password',$this->random_password)
                    ->with('pin',$this->random_pin)
                    ->with('user',$this->user)
                    ->with('url',$this->url);
    }
}
