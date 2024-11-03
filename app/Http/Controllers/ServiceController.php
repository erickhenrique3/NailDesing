<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $service = Service::all();
       
       return response()->json([
        'services' => $service
       ]);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validationData = Validator::make($request->all(),
        [
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if($validationData->fails()){
            return response()->json([
                'error' => $validationData->errors()
            ]);
        }

        $service = Service::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return response()->json([
            'service created success' => $service
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}