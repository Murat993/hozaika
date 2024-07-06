<?php

namespace App\Services;

use App\Models\UserLog;

class UserLogService
{
    public function __construct(private readonly TelegramHistory $telegramHistory)
    {
    }

    public function create(string $description, string $event, ?array $newValue, $oldValue = null): void
    {
        UserLog::create([
            'user_id' => auth()->id(),
            'description' => $description,
            'event' => $event,
            'new_value' => $newValue,
            'old_value' => $oldValue,
        ]);

        $this->telegramHistory->send($description);
    }
}
