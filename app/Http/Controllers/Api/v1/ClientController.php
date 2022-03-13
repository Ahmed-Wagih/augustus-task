<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = cache()->remember('clients', 60*60*24 ,function(){
            return Client::paginate(2);
        });
        return response(['data'=> $clients], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        // Validation 
          $validator = Validator::make($request->all(), [
            'client_name' => ['required', 'max:100'],
            'address1' => ['required'],
            'address2' => ['nullable'],
            'city' => ['required' , 'max:100'],
            'state' => ['required' , 'max:100'],
            'country' => ['required' , 'max:100'],
            'phone_no1' => ['required' , 'max:20'],
            'phone_no2' => ['required' , 'max:20'],
            'zip' => ['required' , 'max:20'],
            'first_name' => ['required' , 'max:50'],
            'last_name' => ['required' , 'max:50'],
            'email'=> ['required' , 'email', 'max:150'],
            'password' => ['required', 'min:6', 'confirmed'],
            'phone' => ['required' , 'max:20'],
            'profile_uri' => ['required' , 'max:255', 'url'],
            'status'  => 'required|in:Active,Inactive',
        ]);

        // Check Validation Errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Store order details
        $client = Client::create([
            'client_name'   => $request->client_name,
            'address1'      => $request->address1,
            'address2'      => $request->address2,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'phone_no1'     => $request->phone_no1,
            'phone_no2'     => $request->phone_no2,
            'zip'           => $request->zip,
            'start_validity' => Carbon::now(),
            'end_validity'  => Carbon::now()->addDays(15),
            'status'        => $request->status,

        ]);

        User::create([
            'client_id' => $client->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'profile_uri' => $request->profile_uri,
            'status' => $request->status,
        ]);

        cache()->forget('clients');
        cache()->remember('clients', 60*60*24 ,function(){
            return Client::paginate(2);
        });


        // Return success response
        return response(['message' => ' Created Successfully'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
