<?php

namespace App\Http\Controllers\K12;

use App\Http\Controllers\Controller;
use App\Models\K12\EducationProgramme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationProgrammeController extends Controller
{
    /**
     * Display a listing of the EducationProgrammes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $educationProgrammes = EducationProgramme::all();
            return response()->json($educationProgrammes, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving EducationProgrammes', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created EducationProgramme in storage.
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

            $educationProgramme = EducationProgramme::create($request->all());
            return response()->json(['message' => 'EducationProgramme created successfully', 'data' => $educationProgramme], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating EducationProgramme', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified EducationProgramme.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $educationProgramme = EducationProgramme::findOrFail($id);
            return response()->json($educationProgramme, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'EducationProgramme not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving EducationProgramme', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified EducationProgramme in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $educationProgramme = EducationProgramme::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
              
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $educationProgramme->update($request->all());
            return response()->json(['message' => 'EducationProgramme updated successfully', 'data' => $educationProgramme], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'EducationProgramme not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating EducationProgramme', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified EducationProgramme from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $educationProgramme = EducationProgramme::findOrFail($id);
            $educationProgramme->delete();
            return response()->json('EducationProgramme deleted successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('EducationProgramme not found', 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting EducationProgramme', 'error' => $e->getMessage()], 500);
        }
    }
}