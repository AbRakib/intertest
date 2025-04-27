<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Authenticatable {

    use HasFactory, Notifiable;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUES = [
        self::STATUS_ACTIVE => 'Yes',
        self::STATUS_INACTIVE => 'No',
    ];

    const DELETED_YES = 1;
    const DELETED_NO = 0;
    const DELETES = [
        self::DELETED_YES => 'Yes',
        self::DELETED_NO => 'No',
    ];
    
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'password',
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

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'password' => 'hashed',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }
}
