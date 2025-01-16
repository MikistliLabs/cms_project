<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ArticleRequest;
use App\Models\ArticleModel;
use App\Models\CategoryModel as Category;

class ArticleController extends Controller
{
    // Mostrar lista de artículos paginados
    public function index()
    {
        $articles = ArticleModel::getPaginatedArticles(5);
        return view('articles.admin.index', compact('articles'));
    }

    // Mostrar formulario de creación
    public function create(){
        $categories = Category::all();
        return view('articles.admin.create', compact('categories'));
    }

    // Guardar artículo
    public function store(ArticleRequest $request){
        try {
            $article = ArticleModel::createArticle($request->validated());
            return redirect()->route('admin.dashboard')->with('success', 'Artículo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de edición
    public function edit($articleId){
        try {
            $article = ArticleModel::findOrFail($articleId);
            $categories = Category::all();
            return view('articles.admin.edit', compact('article', 'categories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Artículo no encontrado.');
        }
    }

    // Actualizar artículo
    public function update(ArticleRequest $request, ArticleModel $article){
        try {
            $updated = $article->updateArticle($request->validated(), $article->id);

            if ($updated) {
                return redirect()->route('admin.dashboard')->with('success', 'Artículo actualizado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'No se realizarón cambios en el artículo.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el artículo: ' . $e->getMessage());
        }
    }


    // Eliminar artículo
    public function destroy(ArticleModel $article)
    {
        try {
            $article->deleteArticle($article->id);
            return redirect()->route('admin.dashboard')->with('success', 'Artículo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
    // Funciones para el usuario final
    public function getArticulos(Request $request){
        // obtener los filtros de la solicitud
        $search = $request->get('search');
        $category = $request->get('category');
        // Obtener los artículos filtrados y paginados
        $articles = ArticleModel::filter($search, $category)->paginate(5);
        // Obtener todas las categorías para el filtro en la vista
        $categories = Category::all();
        // Pasar los datos a la vista
        return view('articles.index', compact('articles', 'categories'));
    }
    public function showArticulos($article){
        $articles = ArticleModel::getArticle($article);
        // dd($articles);
        return view('articles.show', compact('articles'));
    }
}
