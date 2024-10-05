<?php

namespace App\Http\Controllers\K12;

use App\Http\Controllers\Controller;
use App\Models\K12\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the Levels.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $levels = Level::all();
            return response()->json($levels, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Levels', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created Level in storage.
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

            $level = Level::create($request->all());
            return response()->json(['message' => 'Level created successfully', 'data' => $level], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Level', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified Level.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $level = Level::findOrFail($id);
            return response()->json($level, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Level not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving Level', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified Level in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $level = Level::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
              
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $level->update($request->all());
            return response()->json(['message' => 'Level updated successfully', 'data' => $level], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Level not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating Level', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified Level from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $level = Level::findOrFail($id);
            $level->delete();
            return response()->json('Level deleted successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Level not found', 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Level', 'error' => $e->getMessage()], 500);
        }
    }
}