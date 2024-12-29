<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
        ]);

        if($validatedData->fails()){
            return response()->json([
                'error' => $validatedData->errors()
            ],422);
        };

        $appointment = Appointment::create($validatedData->validate());
    
        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validatedData = Validator::make($request->all(),[
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
        ]);

        if($validatedData->fails()){
            return response()->json([
                'error' => $validatedData->errors()
            ],422);
        };

        $appointment->update($validatedData->validate());

        return response()->json([
            'appoiment updated succes' => $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json([
            'appoimente deleted success'
        ]);
    }
    
    public function markAsPaid(Request $request, Appointment $appointment)
    {
        $request->validate([
            'payment_type' => 'required|in:card,pix',
        ]);

        $appointment->update([
            'payment_type' => $request->payment_type,
            'payment_status' => 'paid',
        ]);

        return response()->json([
            'message' => 'Pagamento registrado com sucesso.',
            'appointment' => $appointment,
        ]);
    }

    
}
