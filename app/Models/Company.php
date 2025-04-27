<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

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
        'company_name',
        'company_details',
        'email',
        'phone',
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
}
