<?php

namespace Giuga\LaravelMailLog\Models;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $table = 'mail_log';
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];

    public const STATUS_SENDING = 'sending';
    public const STATUS_SENT = 'sent';
    public const STATUS_ERROR = 'error';

    public function occurredProcess()
    {
        return $this->morphTo();
    }

    public function occurredEntity()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo();
    }

    public function errors()
    {
        return $this->hasMany(MailLogError::class);
    }
}
