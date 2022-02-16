<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * Override the default per page values to have per page custom value.
     *
     * @var integer
     */
    protected $perPage = 60;
}
