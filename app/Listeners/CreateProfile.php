<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateProfile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {   
        Profile::create([
            'user_id' => $event->user->id,
            // 'first_name' => 'omar', 
            // 'last_name' => 'khaled',  
            // 'profile_picture' => 'photophoto', 
        ]);
    }
}
