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

    public $screenshotPath;

    public function __construct($screenshotPath)
    {
        $this->screenshotPath = $screenshotPath;
    }

    public function build()
    {
        return $this->subject("Let’s Coordinate Summer Plans – Join Me on Summer Sanity!")
                    ->view('emails.calendar_invite')
                    ->attach(storage_path("app/public/" . $this->screenshotPath), [
                        'as' => 'camp_calendar.png',
                        'mime' => 'image/png',
                    ]);
    }
}
