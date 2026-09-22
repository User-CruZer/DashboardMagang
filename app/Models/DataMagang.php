<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataMagang extends Model
{
    use HasFactory;

    protected $table = 'data_magang';

    protected $fillable = [
        'nama',
        'nim',
        'program_studi',
        'tempat_magang',
        'pembimbing_lapangan',
    ];

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
