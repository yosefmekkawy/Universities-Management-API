<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['user_id','year_id','name','info'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function year()
    {
        return $this->belongsTo(colleges_years::class,'year_id');
    }
    public function image()
    {
        return $this->morphOne(Images::class,'imageable');
    }
}
