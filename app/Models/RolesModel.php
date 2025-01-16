<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolesModel extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_write';
    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];
}
