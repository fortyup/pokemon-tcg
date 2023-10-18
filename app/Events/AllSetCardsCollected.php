<?php

namespace App\Events;

use App\Models\Set;
use App\Models\User;

class AllSetCardsCollected
{
    public $user;
    public $set;

    public function __construct(User $user, Set $set)
    {
        $this->user = $user;
        $this->set = $set;
    }
}
