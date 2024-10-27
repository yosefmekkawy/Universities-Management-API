<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
        [
            'government_id',
            'name',
            'info',
        ];

    public function government()
    {
        return $this->belongsTo(Government::class, 'government_id')
            ->withTrashed()
            ;
    }

//    public function years()
//    {
//        return $this->hasMany(colleges_years::class, 'college_id');
//    }
    public function years()
    {
        return $this->belongsToMany(Year::class,colleges_years::class, 'college_id','year_id')
            ->withPivot('created_at','updated_at')->as('middle_table');
    }
}
