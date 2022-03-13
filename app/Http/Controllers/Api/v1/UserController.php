<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = cache()->remember('users', 60*60*24 ,function(){
            return User::paginate(2);
        });
        return response(['data'=> $users], 200)->header('Content-Type', 'application/json');
        
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
            'client_id',
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
            'profile_uri',
            'last_password_reset',
            'status',
            
            'offer_id'      => 'required|exists:offers,id',
            'affiliate_id'  => 'required:exists:users,id',
            'order_id'      => 'required',
            'sales'         => 'required',
            'order_status'  => 'nullable|in:pending,canceled,completed',
        ]);

        // Check Validation Errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Store order details
        $client = Client::firstOrCreate([
            'order_id'      => $request->order_id,
            'sales'         => $request->sales,
            'order_status'  => $request->order_status ?? 'pending',
            'offer_id'      => $request->offer_id,
            'user_id'       => $request->affiliate_id,

        ]);

        $user = User::create();

        // Return success response
        return response(true, 200)->header('Content-Type', 'application/json');
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
