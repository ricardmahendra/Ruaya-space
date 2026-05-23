<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public static function log(string $action, string $deskripsi, $modelType = null, $modelId = null): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
        ]);
    }
}
