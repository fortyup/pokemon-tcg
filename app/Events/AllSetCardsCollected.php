<?php

namespace App\Events;

use App\Models\User;
use App\Models\Set;

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
