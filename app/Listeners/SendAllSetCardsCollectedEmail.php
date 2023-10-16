<?php

namespace App\Listeners;

use App\Events\AllSetCardsCollected;
use App\Mail\AllSetCardsCollectedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAllSetCardsCollectedEmail
{
    public function __construct()
    {
        //
    }

    public function handle(AllSetCardsCollected $event)
    {
        // Vérifiez si l'utilisateur a collecté toutes les cartes de l'ensemble
        $user = $event->user;
        $set = $event->set;

        if ($user->hasAllSetCards($set)) {
            // Envoyez un e-mail à l'utilisateur
            Mail::to($user->email)->send(new AllSetCardsCollectedMail($set));
        }
    }
}
