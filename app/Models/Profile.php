<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Profile extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
