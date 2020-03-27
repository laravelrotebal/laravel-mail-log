<?php

namespace Giuga\LaravelMailLog\Listeners;

use Giuga\LaravelMailLog\LaravelMailLog;
use Giuga\LaravelMailLog\Models\MailLog;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MailSentListener
{
    /**
     * @var LaravelMailLog
     */
    private $mailLog;

    /**
     * Create the event listener.
     *
     * @param LaravelMailLog $mailLog
     */
    public function __construct(LaravelMailLog $mailLog)
    {
        $this->mailLog = $mailLog;
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

            if($log) {
                $log->status = MailLog::STATUS_SENT;
                $log->save();
            } else {
                $this->mailLog->saveLog($event->message, MailLog::STATUS_SENT);
            }

        } catch (\Throwable $e) {
            Log::debug('Failed to save mail log ['.$e->getMessage().']');
        }
    }
}
