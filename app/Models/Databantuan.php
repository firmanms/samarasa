<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Databantuan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bantuan()
    {
        return $this->hasMany(Bantuan::class);
    }
}
