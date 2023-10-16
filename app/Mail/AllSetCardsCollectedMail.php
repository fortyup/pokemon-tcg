<?php

namespace App\Mail;

use App\Models\Set;
use Illuminate\Mail\Mailable;

class AllSetCardsCollectedMail extends Mailable
{
    public $set;
    public $user;

    public function __construct(Set $set)
    {
        $this->set = $set;
    }

    public function build()
    {
        return $this->markdown('emails.all-set-cards-collected')
            ->with([
                'set' => $this->set,
            ]);
    }


}
