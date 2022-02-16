<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class PatientController extends ApiController
{
    public function index(Request $request)
    {
        return new DataTableCollectionResource(Patient::with(['owner'])->paginate());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'dob' => 'required|date',
            'owner' => 'required|integer|exists:owners,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Patient::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'color' => $request->input('color'),
            'dob' => $request->input('dob'),
            'owner' => $request->input('owner')
        ]);

        return new DataTableCollectionResource(Patient::paginate());
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return new DataTableCollectionResource(Patient::paginate());
    }
}
