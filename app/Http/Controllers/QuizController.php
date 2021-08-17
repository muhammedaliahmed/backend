<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\QuizLog;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Contracts\Session\Session;

class QuizController extends Controller
{
    // public function quizhome1(Request $request)
    // {   
    //     return redirect()->route('quizstart',['email'=>$request->email,'password'=>$request->password]);
    //     // try{
    //     //     $email = $request->email;
    //     //     $password = $request->password;

    //     //     $candidate = Candidate::where(['email'=>$email, 'password'=>$password])->first();
            
    //     //     $candidate_id = $candidate->id;
    //     //     $candidate_name = $candidate->name;
    //     //     $turnedinquiz = $candidate->turnedinquiz;
    //     //     if($turnedinquiz == 0){
    //     //         $quizlog = QuizLog::create([
    //     //             'candidate_id' => $candidate_id,
    //     //             'candidate_name' => $candidate_name,
    //     //             'quiz_url' => $request->fullUrl(),
    //     //         ]);
    //     //         return response($quizlog, 200);
    //     //     }
    //     //     else{
    //     //         return response('You Have Already Submitted Your Response');
    //     //     }
            
    //     // }
    //     // catch(Exception $e){
    //     //     $error = array(
    //     //         'message' => 'There was an error: {'.
    //     //             $e->getMessage().'}'
    //     //     );
    //     //     return response($error);
    //     // }
    // }
    public function quizhome(Request $request){
        try{
            $email = $request->email;
            $password = $request->password;

            $candidate = Candidate::where(['email'=>$email, 'password'=>$password])->first();
            
            $candidate_id = $candidate->id;
            $candidate_name = $candidate->name;
            $turnedinquiz = $candidate->turnedinquiz;
            $linkvisited = $candidate->linkvisited;
            if($turnedinquiz == 0 && $linkvisited == 0){
                $quizlog = QuizLog::create([
                    'candidate_id' => $candidate_id,
                    'candidate_name' => $candidate_name,
                    'quiz_url' => $request->fullUrl(),
                    'start_time' => now(),
                ]);
                $candidate->linkvisited = 1;
                $candidate->save();
                // session(['LogID'=> $quizlog->id]);
                // $success = array(
                //     'success' => true,
                //     'message' => 'Quiz Started'
                // );
                return response($quizlog, 200);
            }
            else{
                $error = array(
                    'success' => false,
                    'message' => 'You Have Already Submitted Your Response'
                );
                return response($error, 404);
            }
            
        }
        catch(Exception $e){
            $error = array(
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error, 404);
        }
    }

    public function download(Request $request){

        $data= QuizLog::find($request->id);
        $filePath= $data->recording_path;
        return response()->download($filePath);
    }

    public function onSubmit(Request $req){
        try{
            
            $req_data = $req->validate([
            'video' => 'required',
            'LogID' => 'required'
            ]);

            // $fileName = time().'_'.$req->video->getClientOriginalName().'.mp4';
            //     $filePath = $req->file('video')->storeAs('uploads', $fileName, 'public');
            //     //$fileModel->recording_path = '/storage/' . $filePath;
                
            // return response("File Uploaded", 200);
            

            $fileModel = QuizLog::find($req_data['LogID']);
            
            $user= Candidate::find($fileModel->candidate_id);
        
            if($req->file()) {
                $fileName = $user->id.$user->name.'_'.$req->video->getClientOriginalName().'.mp4';
                $filePath = $req->file('video')->storeAs('uploads', $fileName, 'public');
                $fileModel->recording_path = $filePath;
                $fileModel->end_time= now();
                $user->turnedinquiz=1;
                $user->save();
                $fileModel->save();
                session()->flush();
                $success = array(
                    'success' => true,
                    'message' => 'Quiz Submitted Successfully'
                );
                return response($success, 200);
                
                // return back()
                // ->with('success','File has been uploaded.')
                // ->with('file', $fileName);
            }
        else{
            $error = array(
                    'success' => false,
                    'message' => 'You Have Already Submitted Your Response'
                );
                return response(session()->all(), 404);
        }
    }
        catch(Exception $e)
        {
            $error = array(
                'success' => false,
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error);
        }
    }

}
