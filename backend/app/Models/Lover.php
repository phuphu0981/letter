<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lover extends Model
{
    protected $table = 'lover';

    protected $fillable = [
        'name',
        'avatar',
        'pass',
        'content_letter',
        'text_profile',
        'text_letter',
        'memory',
    ];

    public function memories()
    {
        return $this->hasMany(Memory::class);
    }
}
