<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function expectancies(){
        return $this->hasMany(Expectancy::class);
    }
}
