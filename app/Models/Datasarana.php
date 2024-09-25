<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datasarana extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolahs_id')->orderBy('id', 'asc');
    }
}
