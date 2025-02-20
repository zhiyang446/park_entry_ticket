<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'ticket_id',
        'ticket_type',
        'ticket_price',
        'ticket_quantity',
        'creation_date',
        'redemption_date',
        'status',
        'qr_code'
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'redemption_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function redeemer()
    {
        return $this->belongsTo(User::class, 'redeemer_id');
    }

    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code ? asset('storage/' . $this->qr_code) : null;
    }
}
