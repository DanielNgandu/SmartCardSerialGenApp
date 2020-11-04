<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewCard
{
    use SerializesModels;

    public $card;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($card)
    {
        $this->card = $card;
    }
}
