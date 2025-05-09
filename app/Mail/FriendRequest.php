<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use App\Models\Guardian;

class FriendRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $fromGuardian;
    public $toGuardian;

    /**
     * Create a new message instance.
     */
    public function __construct(Guardian $fromGuardian, Guardian $toGuardian)
    {
        $this->fromGuardian = $fromGuardian;
        $this->toGuardian = $toGuardian;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate a temporary signed URL for accepting the friend request
        $acceptUrl = URL::temporarySignedRoute(
            'friends.accept',
            now()->addDays(2),
            [
                'from' => $this->fromGuardian->id,
                'to' => $this->toGuardian->id,
            ]
        );

        return $this->subject("Let’s Coordinate Summer Plans – Can I be your friend!")
                    ->view('emails.friend_request')
                    ->with([
                        'fromGuardian' => $this->fromGuardian,
                        'toGuardian' => $this->toGuardian,
                        'acceptUrl' => $acceptUrl,
                    ]);
    }
}
