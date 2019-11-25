<?php


namespace App\Events;


class t
{
    public function getLoyaltyCardAttribute()
    {
        return $this->user->loyalty_card_number ?? null;
    }
}
