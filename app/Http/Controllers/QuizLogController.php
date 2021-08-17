<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;
use App\Models\QuizLog;
use App\Models\Video;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $response = DB::table('quiz_logs')
            ->join('candidates', 'quiz_logs.candidate_id', '=', 'candidates.id')
            ->select('candidates.*', 'quiz_logs.recording_path', 'quiz_logs.task', 'quiz_logs.id as LogID')
            ->get();
        return response($response, 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizLog  $quizLog
     * @return \Illuminate\Http\Response
     */
    public function show(QuizLog $quizLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuizLog  $quizLog
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizLog $quizLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizLog  $quizLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizLog $quizLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizLog  $quizLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        try{
        $data = $request->validate([
            'LogID'=>'required'
        ]);
         
        $log = QuizLog::find($data['LogID']);

        $path = $log->recording_path;
        $path = storage_path('app/public/'.$path);
        File::delete($path);
        
        $log=QuizLog::destroy($data['LogID']);
        $success = array(
            'success' => true,
            'message' => 'Log Deleted Successfully'
        );
        return response($success);
    }
    catch(Exception $e)
    {
        $error = array(
            'success' => false,
            'message' => 'There was an error: {'.
                $e->getMessage().'}'
        );
        return response($error, 404);
    }
    }

    public function download(Request $request)
    {
        try{
        $data = $request->validate([
                'LogID' => 'required',
                ]);
        
        $log = QuizLog::find($data['LogID']);

        if($log){
            $path = $log->recording_path;
            $path = storage_path('app\public/'.$path);
            
            //'C:\Users\user_\Desktop\Developers Studio\Laravel Projects\Quiz_Project\storage\app\public/uploads/1628859572_blob'
            // return Storage::download(Storage::url('1628856704_avatar2.png')) ;

            return response()->download($path);
        }
        
        }
        catch(Exception $e){
            $error = array(
                'success' => false,
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error, 404);
        }
        

    }

    public function play(Request $request)
    {
        try{
        $data = $request->validate([
                'LogID' => 'required',
                ]);
        
        $log = QuizLog::find($data['LogID']);

        if($log){
            $path = $log->recording_path;
            $path = storage_path('app\public/'.$path);
            
            // $video_path = 'D:\xampp\laravel\test.mkv';
            $tmp = new Video($path);
            return response($tmp->start());
            
            //'C:\Users\user_\Desktop\Developers Studio\Laravel Projects\Quiz_Project\storage\app\public/uploads/1628859572_blob'
            // return Storage::download(Storage::url('1628856704_avatar2.png')) ;
            
            //return response()->stream($path);
        }
        
        }
        catch(Exception $e){
            $error = array(
                'success' => false,
                'message' => 'There was an error: {'.
                    $e->getMessage().'}'
            );
            return response($error, 404);
        }
        

    }
    
}
