<?php

namespace Giuga\LaravelMailLog\Listeners;

use Giuga\LaravelMailLog\Models\MailLog;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MailSentListener
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
     * @param MessageSent $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        try {
            $log = MailLog::whereMessageId($event->message->getId())->first();

            $log->status = MailLog::STATUS_SENT;
            $log->save();

        } catch (\Throwable $e) {
            Log::debug('Failed to save mail log ['.$e->getMessage().']');
        }
    }
}
