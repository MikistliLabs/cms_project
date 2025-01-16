<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_write';
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'status',
        'created_by',
    ];
    // Obtener Categorias paginados
    public static function getPaginatedArticles($perPage = 5){
        return self::on('pgsql_read')->where('status', '!=', 0)->paginate($perPage);
    }
    // Crear artículo
    public static function createArticle($data)
    {
        $data['status'] = 1;
        $data['created_by'] = 1;
        // dd($data);
        return self::on('pgsql_write')->create($data);
    }

    // Actualizar artículo
    public function updateCategory($data, $id){
        // Actualizar los datos del artículo
        $category = $this->on('pgsql_write')->findOrFail($id);
        $category->update([
            'name' => $data['name'],
        ]);

        return $category;
    }

    // Eliminar artículo y su imagen
    public function deleteCategory($id)
    {
        $category = $this->on('pgsql_write')->findOrFail($id);
        $category->update([
            'status'=> 0,
        ]);
    }
}
