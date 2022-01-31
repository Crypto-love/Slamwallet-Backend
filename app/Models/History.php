<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

}
