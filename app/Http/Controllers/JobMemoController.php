<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\JobMemoRequest;
use App\Models\JobMemo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobMemoController extends Controller
{
    public function index()
    {
        try {
            $jobMemos = JobMemo::all();

            $response = ResponseHelper::successResponse("Received List of jobMemos!", $data = $jobMemos);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred while fetching job memos.", 500);
            return response()->json($response);
        }
    }

    public function show(JobMemo $jobMemo)
    {
        try {
            $response = ResponseHelper::successResponse("Received data requested jobMemo!", $data = $jobMemo);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred while fetching the job memo.", 500);
            return response()->json($response);
        }
    }

    public function store(JobMemoRequest $request)
    {  
// return $request;
// dd($request->all()); 
        try {

            $user = User::where('email', 'kader@gmail.com')->first();
            if (!$user) {
                $response = ResponseHelper::errorResponse("User not found.", 404);
                return response()->json($response);
            }
                // Create job memo
                $jobMemo = JobMemo::create([
                    'user_id' => $user->id,
                    'job_title' => $request->input('job_title'),
                    'deadline' => $request->input('deadline'),
                    'experience' => $request->input('experience'),
                    'tech_stack' => $request->input('tech_stack'),
                    'location' => $request->input('location'),
                    'interview_called' => $request->input('interview_called'),
                    'interview_attended' => $request->input('interview_attended'),
                ]);

            $response = ResponseHelper::successResponse("Job memo created successfully!", $data = $jobMemo);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred while creating the job memo.", 500);
            return response()->json($response);
        }
    }

    public function edit(JobMemo $jobMemo)
    {
        try {
            $response = ResponseHelper::successResponse("Edit job memo.", $data = $jobMemo);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred.", 500);
            return response()->json($response);
        }    
    }

    public function update(Request $request, $id)
    {
        try {  
            $user = User::where('email', 'kader@gmail.com')->first();
            if (!$user) {
                $response = ResponseHelper::errorResponse("User not found.", 404);
                return response()->json($response);
            }
            $jobMemos = jobMemo::find($id);
            // Update job memo
            $jobMemos->update([
                'user_id' => $user->id,
                'job_title' => $request->input('job_title'),
                'deadline' => $request->input('deadline'),
                'experience' => $request->input('experience'),
                'tech_stack' => $request->input('tech_stack'),
                'location' => $request->input('location'),
                'interview_called' => $request->input('interview_called'),
                'interview_attended' => $request->input('interview_attended'),
            ]);
            $response = ResponseHelper::successResponse("Job memo updated successfully!", $data = $jobMemos);
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred while update job memo.", 500);
            return response()->json($response);
        }
    }

    public function destroy(JobMemo $jobMemo)
    {
        try {
            // Delete job memo
            $jobMemo->delete();
            // Return success response
            $response = ResponseHelper::successResponse("Job memo deleted successfully!");
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ResponseHelper::errorResponse("An error occurred while deleting the job memo.", 500);
            return response()->json($response);
        }
    }
}
