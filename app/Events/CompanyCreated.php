<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompanyCreated
{
    use SerializesModels;

    /**
     * The authenticated company.
     *
     * @var \App\Models\Company
     */
    public $company;

     /**
     * Create a new event instance.
     *
     * @param \App\Models\Company $company
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }
}
