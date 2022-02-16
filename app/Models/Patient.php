<?php

namespace App\Models;

use Illuminate\Support\Facades\Date;

class Patient extends Model
{
    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true
        ],
        'species' => [
            'searchable' => true
        ],
        'color' => [
            'searchable' => true
        ],
        'dob' => [
            'searchable' => true
        ],
        'owner' => [
            'searchable' => true
        ]
    ];

    protected $dataTableRelationships = [
        //
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'species',
        'color',
        'dob',
        'owner'
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d'
    ];

    /**
     * Access packages have many route permissions.
     *
     * Used for App\Http\Resources\Api\Admin\AccessPackageResource
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function owner()
    {
        return $this->hasOne(Owner::class, 'id', 'owner');
    }
}
