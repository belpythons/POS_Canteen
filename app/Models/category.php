<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'nama_produk',
        'is_expense',
        'image',
    ];
}
