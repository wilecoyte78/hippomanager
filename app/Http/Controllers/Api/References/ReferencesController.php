<?php

namespace App\Http\Controllers\Api\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Owner;

class ReferencesController extends ApiController
{
    public function owners()
    {
        return $this->respond(Owner::all());
    }
}
