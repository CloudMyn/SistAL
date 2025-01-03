<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Praktikan extends Model
{
    /** @use HasFactory<\Database\Factories\PraktikanFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas',
        'jurusan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
