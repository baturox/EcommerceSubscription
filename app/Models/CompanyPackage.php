<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_id',
        'company_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'package_id' => 'integer',
        'company_id' => 'integer',
        'start_date' => 'timestamp',
        'end_date' => 'timestamp',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }
}
