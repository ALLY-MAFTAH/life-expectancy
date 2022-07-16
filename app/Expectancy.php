<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expectancy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_name',
        'country_code',
        'indicator_name',
        'total',
        'year_id'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
