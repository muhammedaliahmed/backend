<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all records of admin table
        return response(Admin::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validated_data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|max:32',
            ]);
            $admin = Admin::create($validated_data);
            return response($admin, 200);
        }
        catch(Exception $e){
            $error = array(
                'success' => false,
                'fields' => '"Name" "Email" and "Password" fields are Required(*)',
                'email' => 'Please Enter a Valid Email',
                'password' => 'Please Enter a Password Min(6), Max(32) Characters Long',
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error, 417);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
    public function login(Request $request)
    {
        try{
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|max:32',
            ]);
            $found = Admin::where(['email'=>$data['email'], 'password'=>$data['password']])->first();
            if($found == null){
                $error = array(
                    'success' => false,
                    'message' => 'You are not an [Admin] {No Record Found}'
                );
                return response($error, 404);
            }
            else{
                return response($found, 200);
            }
        }
        catch(Exception $e){
            $error = array(
                'success' => false,
                'fields' => 'Both Email and Password fields are Required To Login',
                'email' => 'Please Enter a Valid Email',
                'password' => 'Please Enter a Password Min(6), Max(32) Characters Long',
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error, 417);
        }
        
    }
    
}
