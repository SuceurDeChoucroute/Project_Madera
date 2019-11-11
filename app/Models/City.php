<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'zipcode', 'name',
    ];

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
