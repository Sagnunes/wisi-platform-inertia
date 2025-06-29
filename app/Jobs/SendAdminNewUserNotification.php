<?php

namespace App\Jobs;

use App\Mail\AdminNewUserNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminNewUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    private string $STI_EMAIL = 'sti.drabl@madeira.gov.pt';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        Mail::to(ENV('IT_DEPARTMENT_EMAIL', $this->STI_EMAIL))
            ->send(new AdminNewUserNotification($this->user));
    }
}
