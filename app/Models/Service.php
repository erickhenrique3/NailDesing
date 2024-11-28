<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
      'name',
      'price',
      'payment_type',
      'payment_status'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
