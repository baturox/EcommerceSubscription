<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'site_url',
        'company_name',
        'email',
        'password',
        'author_id',
        'api_key',
        'canceled_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'author_id' => 'integer',
        'api_key' => 'integer',
        'canceled_at' => 'timestamp',
    ];

    public function payments()
    {
        return $this->hasMany(CompanyPayment::class, 'company_id');
    }

    public function packages()
    {
        return $this->hasMany(CompanyPackage::class, 'company_id');
    }
}
