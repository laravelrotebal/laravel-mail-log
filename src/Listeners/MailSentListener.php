<?php

namespace Giuga\LaravelMailLog\Listeners;

use Giuga\LaravelMailLog\LaravelMailLog;
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
     * @param LaravelMailLog $mailLog
     * @return void
     */
    public function handle(MessageSent $event, LaravelMailLog $mailLog)
    {
        try {
            $log = MailLog::whereMessageId($event->message->getId())->first();

            if($log) {
                $log->status = MailLog::STATUS_SENT;
                $log->save();
            } else {
                $mailLog->saveLog($event->message, MailLog::STATUS_SENT);
            }

        } catch (\Throwable $e) {
            Log::debug('Failed to save mail log ['.$e->getMessage().']');
        }
    }
}
