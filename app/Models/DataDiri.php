<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDiri extends Model
{
    protected $table = 'data_diri';
 
    protected $fillable = [
        'user_id', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'no_hp', 'email',
    ];
}
