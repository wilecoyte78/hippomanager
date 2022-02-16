<?php

namespace App\Models;

class Owner extends Model
{
    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'first_name' => [
            'searchable' => true
        ],
        'last_name' => [
            'searchable' => true
        ],
        'phone' => [
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
        'first_name',
        'last_name',
        'phone'
    ];

    /**
     * Access packages have many route permissions.
     *
     * Used for App\Http\Resources\Api\Admin\AccessPackageResource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany(Patient::class, 'owner', 'id');
    }
}
