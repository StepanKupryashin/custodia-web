<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];


    public function users()
    {
        return $this->belongsToMany(User::class, 'positions_users', 'position_id', 'id');
    }

}
