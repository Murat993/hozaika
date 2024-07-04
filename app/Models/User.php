<?php

namespace App\Models;

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
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname','lastname','roles',
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

    protected static function boot(): void
    {
        parent::boot();
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
}
