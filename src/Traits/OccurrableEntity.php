<?php

namespace Giuga\LaravelMailLog\Traits;

use Illuminate\Database\Eloquent\Model;

trait OccurrableEntity {



    public static function getOccuredKey() {
        return 'event.occurred';
    }



    public function occurred(Model $entity) {
        $this->with(static::getOccuredKey(), $entity);

        return $this;
    }



}
