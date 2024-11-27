<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json([
            'appoimente delted success'
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
