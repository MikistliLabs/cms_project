<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $connection = 'pgsql_write';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }// Obtener artículos paginados
    public static function getPaginatedUsers($perPage = 5){
        return self::on('pgsql_read')->where('status', '!=', 0)->paginate($perPage);
    }
    public static function createUsuario($data){
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $data['role_id'];
        $data['created_by'] = 1;

        return self::on('pgsql_write')->create($data);
    }
    public function updateUser($data, $id){
        return self::on('pgsql_write')
            ->where('id', $id)
            ->update($data);
    }
    public function deleteUser($id){
        $category = $this->on('pgsql_write')->findOrFail($id);
        $category->update([
            'status'=> 0,
        ]);
    }
}
