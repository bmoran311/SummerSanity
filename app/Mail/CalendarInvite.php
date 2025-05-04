<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class CalendarInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $guardian_id;
    public $email;

    public function __construct($guardian_id, $email)
    {
        $this->guardian_id = $guardian_id;
        $this->email = $email;
    }

    public function build_old()
    {
        return $this->subject("Let’s Coordinate Summer Plans – Join Me on Summer Sanity!")
                    ->view('emails.calendar_invite_screenshot')
                    ->attach(storage_path("app/public/" . $this->screenshotPath), [
                        'as' => 'camp_calendar.png',
                        'mime' => 'image/png',
                    ]);
    }

    public function build()
    {
        return $this->subject("Let’s Coordinate Summer Plans – Join Me on Summer Sanity!")
                    ->view('emails.calendar_invite')
                    ->with([
                        'guardian_id' => $this->guardian_id,
                        'email' => $this->email,
                    ]);
    }
}
