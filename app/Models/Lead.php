<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'email',
        'phone',
        'mortgage_request_amount',
        'purpose_mortgage',
        'score',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
