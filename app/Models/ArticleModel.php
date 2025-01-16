<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ArticleModel extends Model
{
    protected $connection = 'pgsql_write';
    protected $table = 'articles';
    protected $fillable = ['title', 'content', 'image', 'status', 'publish', 'category_id', 'created_by'];

    // Obtener artículos paginados con filtros
    public static function filter($search = null, $category = null)
    {
        return self::on('pgsql_read')->where('status', '!=', 0)
            ->when($search, function ($query, $search) {
                return $query->where('title', 'ILIKE', "%$search%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            });
    }

    // Obtener artículos paginados (sin filtros)
    public static function getPaginatedArticles($perPage = 5)
    {
        return self::filter()->paginate($perPage);
    }

    // Crear artículo
    public static function createArticle($data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('articles', 'public');
        }
        $data['created_by'] = 1;

        return self::on('pgsql_write')->create($data);
    }

    // Obtener un artículo con categoría
    public static function getArticle($id)
    {
        return self::on('pgsql_read')->with('category')->findOrFail($id);
    }

    // Actualizar artículo
    public function updateArticle($data, $id){
        // Verificar y actualizar la imagen si es válida
        if (isset($data['image']) && $data['image']->isValid()) {
            // Eliminar la imagen anterior si existe
            if ($this->image) {
                Storage::disk('public')->delete($this->image);
            }
            // Guardar nueva imagen
            $data['image'] = $data['image']->store('articles', 'public');
        }

        // Actualizar los datos del artículo
        $article = $this->on('pgsql_write')->findOrFail($id);
        $article->update([
            'title'     => $data['title'],
            'content'   => $data['content'],
            'image'     => $data['image'] ?? $article->image,
            'status'    => $data['status'] ?? $article->status,
            'publish'   => $data['publish'] ?? $article->publish,
        ]);

        return $article;
    }

    // Eliminar artículo y su imagen
    public function deleteArticle($id)
    {
        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }

        // return $this->delete();
        $article = $this->on('pgsql_write')->findOrFail($id);
        $article->update([
        // return $this->on('pgsql_write')->update([
            'image'=> null,
            'status'=> 0,
        ]);
    }

    // Relación con categorías
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

}
