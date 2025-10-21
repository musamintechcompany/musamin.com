<?php

namespace App\Observers;

use App\Models\Idea;
use App\Models\Admin;
use App\Notifications\Admin\IdeaSubmittedNotification;

class IdeaObserver
{
    public function created(Idea $idea): void
    {
        $admins = Admin::where('is_active', true)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new IdeaSubmittedNotification($idea));
        }
    }
}