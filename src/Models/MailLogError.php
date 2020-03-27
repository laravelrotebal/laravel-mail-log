<?php

namespace Giuga\LaravelMailLog\Models;

use Illuminate\Database\Eloquent\Model;

class MailLogError extends Model
{
    protected $guarded = [];

    public function mailLog()
    {
        return $this->belongsTo(MailLog::class);
    }
}
