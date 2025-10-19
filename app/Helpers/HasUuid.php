<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Uuid::uuid4()->toString();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public static function findByUuidOrFail(UuidInterface $uuid): self
    {
        return static::where('id', $uuid->toString())->firstOrFail();
    }
}
