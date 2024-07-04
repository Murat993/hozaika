<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    const EVENT_USER_CREATE = 'user_create';
    const EVENT_USER_UPDATE = 'user_update';
    const EVENT_USER_DELETE = 'user_delete';
    const EVENT_MANAGER_CREATE = 'manager_create';
    const EVENT_MANAGER_UPDATE = 'manager_update';
    const EVENT_MANAGER_DELETE = 'manager_delete';


    protected $fillable = [
        'user_id', 'description', 'event', 'old_value', 'new_value'
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formatValues($values)
    {
        $translatedFields = [
            'email' => 'Электронная почта',
            'roles' => 'Роли',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];

        $formatted = [];
        foreach ($values as $key => $value) {
            if (isset($translatedFields[$key])) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                $formatted[] = $translatedFields[$key] . ': ' . $value;
            }
        }

        return implode("\n", $formatted);
    }
}
