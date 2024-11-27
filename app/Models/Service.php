<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
      'name',
      'price',
      'status'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
