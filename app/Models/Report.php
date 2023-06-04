<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeReports() {
        $data = Report::all();
        foreach ($data as &$d) {
           $d->user;
        }
        return $data;
    }

    static function report(int $id) {
        $d = Report::find($id);
        $d->user;
        return $d;
    }
}
