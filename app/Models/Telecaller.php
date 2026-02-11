<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telecaller extends Model
{
    protected $table = 'telecallers';

    protected $fillable = [
        'business',
        'name',
        'address',
        'mobile',
        'user_id',
        'meeting_datetime',
        'interest',
        'status'
    ];

    protected $casts = [
        'product_name' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bdm()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
