<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registries extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'operator',
        'country',
        'status',
        'date_sub',
        'date_valid',
        'commentaire'
    ];
}
