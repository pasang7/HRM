<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprove extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $approvedBy;
    protected $start;
    protected $end;
    protected $reason;
    protected $url;
    public function __construct($user,$approvedBy,$start,$end,$reason)
    {
        $this->approvedBy=$approvedBy;
        $this->user=$user;
        $this->start=$start;
        $this->end=$end;
        $this->reason=$reason;
        $this->url=SITE_URL;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.leave.approval_inform_to_ceo')
                    ->with('approvedBy',$this->approvedBy)
                    ->with('start',$this->start)
                    ->with('end',$this->end)
                    ->with('reason',$this->reason)
                    ->with('url',$this->url)
                    ->with('user',$this->user);
    }
}
