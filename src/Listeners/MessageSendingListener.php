<?php

namespace Giuga\LaravelMailLog\Listeners;

use Giuga\LaravelMailLog\LaravelMailLog;
use Giuga\LaravelMailLog\Models\MailLog;
use Giuga\LaravelMailLog\Traits\Occurrable;
use Giuga\LaravelMailLog\Traits\Recipientable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;

class MessageSendingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MessageSending $event
     * @param LaravelMailLog $mailLog
     * @return void
     */
    public function handle(MessageSending $event, LaravelMailLog $mailLog)
    {
        try {
            $mailLog->saveLog($event->message);
        } catch (\Throwable $e) {
            Log::debug('Failed to save mail log ['.$e->getMessage().']');
        }
    }
}
