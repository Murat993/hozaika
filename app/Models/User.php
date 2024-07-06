<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Entity\User
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $notifications_count
 * @property-read array $roles
 * @property-read int $level_id
 * @property-read string $gender
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @property-read Collection|CompletedUserTask[] $completedUserTasks
 * @property-read Collection|UserProductSum[] $productsSum
 * @property-read Level $level
 */
class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_USER = 'user';

    public const GENDERS = [
        'man' => 'Мужчина',
        'woman' => 'Женщина',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname','lastname','roles', 'level_id', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    public function productsSum(): HasMany
    {
        return $this->hasMany(UserProductSum::class, 'user_id', 'id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function completedUserTasks(): HasMany
    {
        return $this->hasMany(CompletedUserTask::class);
    }

    public function hasRole($role): bool
    {
        return in_array($role, $this->roles, true);
    }

    public function hasAnyRole(array $roles): bool
    {
        return !empty(array_intersect($roles, $this->roles));
    }

    public function addRole($role): void
    {
        $roles = $this->roles;
        if (!in_array($role, $roles, true)) {
            $roles[] = $role;
            $this->roles = $roles;
            $this->save();
        }
    }

    public function removeRole($role): void
    {
        $roles = $this->roles;
        if (($key = array_search($role, $roles, true)) !== false) {
            unset($roles[$key]);
            $this->roles = array_values($roles);
            $this->save();
        }
    }

    public function getFullName()
    {
        return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function isManager(): bool
    {
        return $this->hasRole(self::ROLE_MANAGER);
    }

    public function isUser(): bool
    {
        return $this->hasRole(self::ROLE_USER);
    }

    public function checkTasksCompletion(): bool
    {
        $tasks = $this->level->tasks;
        foreach ($tasks as $task) {
            if (!$this->completedUserTasks()->where('task_id', $task->id)->exists()) {
                return false;
            }
        }
        return true;
    }

    public function promoteToNextLevel(): void
    {
        if ($this->checkTasksCompletion()) {
            $nextLevel = Level::where('id', '>', $this->level_id)->orderBy('id')->first();
            if ($nextLevel) {
                $this->level_id = $nextLevel->id;
                $this->save();
            }
        }
    }
}
