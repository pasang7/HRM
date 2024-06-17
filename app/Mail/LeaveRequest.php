<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $start;
    protected $end;
    protected $reason;
    protected $leave_type;
    protected $url;

    public function __construct($user,$start,$end,$reason,$leave_type)
    {
        $this->user=$user;
        $this->start=$start;
        $this->end=$end;
        $this->reason=$reason;
        $this->leave_type=$leave_type;
        $this->url = SITE_URL;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.leave.request')
                    ->with('start',$this->start)
                    ->with('end',$this->end)
                    ->with('reason',$this->reason)
                    ->with('user',$this->user)
                    ->with('leave_type',$this->leave_type)
                    ->with('url',$this->url);
    }
}
