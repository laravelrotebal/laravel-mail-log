<?php

namespace Giuga\LaravelMailLog\Listeners;

use Giuga\LaravelMailLog\LaravelMailLog;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;

class MessageSendingListener
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
     * @param MessageSending $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        try {
            $this->mailLog->saveLog($event->message, $event->data);
        } catch (\Throwable $e) {
            Log::debug('Failed to save mail log ['.$e->getMessage().']');
        }
    }
}
