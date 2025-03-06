<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailProfile extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'detail_profiles'; // Pastikan sesuai dengan nama tabel

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
