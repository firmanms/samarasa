<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sumberdana' => 'array',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolahs_id')->orderBy('id', 'asc');
    }

    public function databantuan()
    {
        return $this->belongsTo(Databantuan::class, 'databantuans_id')->orderBy('id', 'asc');
    }
}
