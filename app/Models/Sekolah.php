<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bantuan()
    {
        return $this->hasMany(Bantuan::class, 'sekolahs_id')->orderBy('id', 'asc');
    }

    public function sarana()
    {
        return $this->hasMany(Datasarana::class);
    }

    public function prasarana()
    {
        return $this->hasMany(Dataprasarana::class);
    }

    public function usulan()
    {
        return $this->hasMany(Usulan::class);
    }
}
