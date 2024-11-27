<?php

namespace App\Observers;

use App\Models\Appointment;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment)
    {
        // Se o pagamento foi marcado como 'paid', atualiza o serviço para 'completed'
        if ($appointment->isDirty('payment_status') && $appointment->payment_status === 'paid') {
            $appointment->service->update(['status' => 'completed']);
        }

        // Caso o pagamento seja revertido para 'unpaid', volta o serviço para 'incomplete'
        if ($appointment->isDirty('payment_status') && $appointment->payment_status === 'unpaid') {
            $appointment->service->update(['status' => 'incomplete']);
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
