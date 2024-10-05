<?php

namespace App\Http\Controllers\K12;

use App\Http\Controllers\Controller;
use App\Models\K12\Level;
use App\Models\K12\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the Subjects.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $subjects = Subject::all();
            return response()->json($subjects, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Subjects', 'error' => $e->getMessage()], 500);
        }
    }

    public function levelSubjects(Level $level)
    {
        try {
            $subjects = $level->subjects;
            return response()->json($subjects, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Subjects', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created Subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',   
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $subject = Subject::create($request->all());
            return response()->json(['message' => 'Subject created successfully', 'data' => $subject], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Subject', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified Subject.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            return response()->json($subject, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Subject not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Subject', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified Subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
              
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $subject->update($request->all());
            return response()->json(['message' => 'Subject updated successfully', 'data' => $subject], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Subject not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating Subject', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified Subject from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();
            return response()->json('Subject deleted successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Subject not found', 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Subject', 'error' => $e->getMessage()], 500);
        }
    }
}