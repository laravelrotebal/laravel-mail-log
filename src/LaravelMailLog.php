<?php

namespace Giuga\LaravelMailLog;

use Giuga\LaravelMailLog\Models\MailLog;
use Giuga\LaravelMailLog\Traits\Occurrable;
use Giuga\LaravelMailLog\Traits\Recipientable;
use Illuminate\Database\Eloquent\Model;
use Swift_Message;

class LaravelMailLog
{

    public function saveLog(Swift_Message $msg, array $data, $status = MailLog::STATUS_SENDING) {
        $parts = $msg->getChildren();
        $body = $msg->getBody();
        if (! empty($parts)) {
            foreach ($parts as $part) {
                if (stripos($part->getBodyContentType(), 'image') !== false) {
                    $ptr = str_replace("\n", '', trim(str_replace($part->getHeaders(), '', $part->toString())));
                    $body = str_replace('cid:'.$part->getId(), 'data:'.$part->getBodyContentType().';base64,'.$ptr, $body);
                }
            }
        }

        $to = $msg->getTo() ?? [];
        $cc = $msg->getCc() ?? [];
        $bcc = $msg->getBcc() ?? [];
        $insert = [
            'to' => implode(', ', is_array($to) ? array_keys($to) : $to),
            'cc' => implode(', ', is_array($cc) ? array_keys($cc) : $cc),
            'bcc' => implode(', ', is_array($bcc) ? array_keys($bcc) : $bcc),
            'subject' => $msg->getSubject(),
            'message_id' => $msg->getId(),
            'message' => $body,
            'status' => $status,
            'data' => [],
        ];
        $log = MailLog::create($insert);

        $occuredEntity = $data[Occurrable::getOccuredEntityKey()] ?? null;
        $occuredProcess = $data[Occurrable::getOccuredProcessKey()] ?? null;

        if ($occuredEntity && $occuredEntity instanceof Model) {
            $log->occurredEntity()->associate($occuredEntity)->save();
        }

        if ($occuredProcess && $occuredProcess instanceof Model) {
            $log->occurredProcess()->associate($occuredProcess)->save();
        }

        $recipient = $data[Recipientable::getRecipientKey()] ?? null;

        if ($recipient && $recipient instanceof Model) {
            $log->recipient()->associate($recipient)->save();
        }
    }

}
