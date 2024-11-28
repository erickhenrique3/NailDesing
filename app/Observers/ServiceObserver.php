<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service)
    {
        // Se o pagamento foi marcado como 'paid', atualiza os agendamentos relacionados
        if ($service->isDirty('payment_status') && $service->payment_status === 'paid') {
            $service->appointments()->update(['status' => 'completed']);
        }

        // Caso o pagamento seja revertido para 'unpaid', volta os agendamentos para 'incomplete'
        if ($service->isDirty('payment_status') && $service->payment_status === 'unpaid') {
            $service->appointments()->update(['status' => 'incomplete']);
        }
    }
    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }
}
