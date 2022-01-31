<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    use HasFactory;

    protected $appends = [
        'user_refer',
        'user_refered'
    ];

    public function user () {
        return $this->belongsTo(User::class, 'user');
    }

    public function history() {
        return $this->hasMany(History::class, 'user_id', 'refer_id');
    }

    public function getUserReferAttribute() {
        return User::find($this->user_id);
    }

    public function getUserReferedAttribute() {
        return User::find($this->refer_id);
    }
}
