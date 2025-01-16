<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class articleModel extends Model
{
    protected $connection = 'pgsql_read';
    protected $table = 'articles';   
    protected $fillable = [
        'name',
        'status',
    ];

    
}
