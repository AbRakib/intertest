<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN    = 1;
    const ROLE_CUSTOMER = 0;
    const ROLES         = [
        self::ROLE_ADMIN    => 'admin',
        self::ROLE_CUSTOMER => 'customer',
    ];

    const IS_ADMIN    = 1;
    const IS_CUSTOMER = 0;

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;
    const STATUES         = [
        self::STATUS_ACTIVE   => 'Yes',
        self::STATUS_INACTIVE => 'No',
    ];

    const DELETED_YES = 1;
    const DELETED_NO  = 0;
    const DELETES     = [
        self::DELETED_YES => 'Yes',
        self::DELETED_NO  => 'No',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'is_admin',
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'address',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
