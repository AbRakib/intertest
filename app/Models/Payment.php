<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model {

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

    const PAYMENT_PAID = 1;
    const PAYMENT_UNPAID = 0;
    const PAYMENT_PARTIAL = 2;
    const PAYMENTS = [
        self::PAYMENT_PAID => 'Paid',
        self::PAYMENT_UNPAID => 'Unpaid',
        self::PAYMENT_PARTIAL => 'Partial Paid',
    ];

    
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'payment_date',
        'payment_method',
        'amount',
        'note',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function customer():BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function invoice():BelongsTo {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
