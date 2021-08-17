<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Candidate::all(), 200);
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
        //Creating A New Candidate
        try{
            $validated_data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|max:32',
            ]);
            $admin = Candidate::create($validated_data);
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
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
    public function generateurl(Request $request)
    {
        try{
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|max:32',
            ]);

            $found = Candidate::firstOrCreate(
            ['email'=>$data['email'], 'password'=>$data['password']],
            ['name' => $data['name']]
            );
        
            if($found){
            $found->turnedinquiz = 0;
            $found->linkvisited = 0; 
            $email = $found->email;
            $password = $found->password;
            $found->save();
            
            $quizurl = URL::signedRoute('quiz',['email' => $email, 'password' => $password]);
            return response()->json(['success'=>true, 'url'=>$quizurl]);
            }
        }
        catch(Exception $e){
            $error = array(
                'success' => false,
                'fields' => 'Name, Email and Password fields are Required To Genrate URL',
                'email' => 'Please Enter a Valid Email',
                'password' => 'Please Enter a Password Min(6), Max(32) Characters Long',
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error);
        }
    }
    
}
