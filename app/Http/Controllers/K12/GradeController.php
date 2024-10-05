<?php

namespace App\Http\Controllers\K12;

use App\Http\Controllers\Controller;
use App\Models\K12\Grade;
use App\Models\K12\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the Grades.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $grades = Grade::all();
            return response()->json($grades, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Grades', 'error' => $e->getMessage()], 500);
        }
    }

    public function levelGrades(Level $level)
    {
        try {
            $grades = $level->grades;
            return response()->json($grades, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving grades', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created Grade in storage.
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

            $grade = Grade::create($request->all());
            return response()->json(['message' => 'Grade created successfully', 'data' => $grade], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Grade', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified Grade.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            return response()->json($grade, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Grade not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Grade', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified Grade in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $grade = Grade::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
              
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $grade->update($request->all());
            return response()->json(['message' => 'Grade updated successfully', 'data' => $grade], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Grade not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating Grade', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified Grade from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
            return response()->json('Grade deleted successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Grade not found', 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Grade', 'error' => $e->getMessage()], 500);
        }
    }
}