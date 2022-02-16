<?php

namespace App\Http\Controllers\Api;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class OwnerController extends ApiController
{
    public function index(Request $request)
    {
        return new DataTableCollectionResource(Owner::paginate());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Owner::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone')
        ]);

        return new DataTableCollectionResource(Owner::paginate());
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return new DataTableCollectionResource(Owner::paginate());
    }

    public function patients(Owner $id)
    {
        $query = $id::patients()->get();

        return $this->respond($query);
    }
}
