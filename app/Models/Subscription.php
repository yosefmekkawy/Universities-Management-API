<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'user_id',
        'subject_id',
        'price',
        'discount',
        'is_locked',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')
            ->withTrashed();
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id')
            ->withTrashed();
    }
}
