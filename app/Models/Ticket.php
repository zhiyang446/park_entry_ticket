<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['ticket_id', 'creation_date', 'redemption_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function redeemer()
    {
        return $this->belongsTo(User::class, 'redeemer_id');
    }
}
