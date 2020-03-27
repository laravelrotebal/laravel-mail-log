<?php

namespace Giuga\LaravelMailLog\Traits;

use Illuminate\Database\Eloquent\Model;

trait Recipientable
{
    public static function getRecipientKey()
    {
        return 'event.occurred_process';
    }

    public function recipient(Model $recipient = null)
    {
        $this->with(static::getRecipientKey(), $recipient);

        return $this;
    }
}
