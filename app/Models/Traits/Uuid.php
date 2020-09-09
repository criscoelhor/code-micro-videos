<?php

namespace App\Models\Traits;
use Ramsey\Uuid\Uuid as RanseyUuid;

trait Uuid
{
    public static function boot()
    {
        parent::boot();
        static::creating(function($obj){
            $obj->id = RanseyUuid::Uuid4()->toString();
        });
    }
}
