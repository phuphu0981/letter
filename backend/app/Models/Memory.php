<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $table = 'memories';

    protected $fillable = [
        'lover_id',
        'image_url',
    ];

    public function lover()
    {
        return $this->belongsTo(Lover::class);
    }
}
