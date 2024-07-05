<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $level_id
 * @property string $name
 * @property float $purchase_amount
 * @property-read Level $level
 * @property-read Collection|CompletedUserTask[] $completedUserTasks
 */
class Task extends Model
{
    protected $fillable = ['level_id', 'name', 'purchase_amount'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function completedUserTasks()
    {
        return $this->hasMany(CompletedUserTask::class);
    }
}

