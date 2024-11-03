<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'appointment_date',
        'scheduling',
    ];

      // Relacionamento com User (Um agendamento pertence a um único usuário)
      public function user()
      {
          return $this->belongsTo(User::class);
      }
  
      // Relacionamento com Service (Um agendamento pertence a um único serviço)
      public function service()
      {
          return $this->belongsTo(Service::class);
      }
}
