<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name'
    ];

    public $timestamps = false;

    // リレーション：companies → products
    public function products()
    {
        return $this->hasMany(Vending::class, 'company_id');
    }
}