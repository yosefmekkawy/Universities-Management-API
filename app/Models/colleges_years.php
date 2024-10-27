<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colleges_years extends Model
{
    use HasFactory;
    protected $fillable = [
        'college_id',
        'year_id',
    ];

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
}
