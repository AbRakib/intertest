<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model {

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
        'invoice_no',
        'customer_id',
        'user_id',
        'refer_invoice_id',
        'invoice_date',
        'inspection_date',
        'next_inspection_date',
        'payment_date',
        'delivery_date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'title',
        'description',
        'report',
        'invoice_note',
        'payment_status',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'created_at');
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function invoice(): BelongsTo {
        return $this->belongsTo(Invoice::class, 'refer_invoice_id', 'id');
    }
}
