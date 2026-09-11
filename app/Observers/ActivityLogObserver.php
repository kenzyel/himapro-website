<?php

namespace App\Observers;

use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

class ActivityLogObserver
{
    public function created(Model $model): void
    {
        ActivityLogService::logCreated($model);
    }

    public function updated(Model $model): void
    {
        ActivityLogService::logUpdated($model);
    }

    public function deleted(Model $model): void
    {
        ActivityLogService::logDeleted($model);
    }
}