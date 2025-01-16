<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CategoryRequest;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function index(){
        $categorias = CategoryModel::getPaginatedArticles(5);
        return view('categorias.index', compact('categorias'));
    }
    // Mostrar formulario de creación
    public function create(){
        return view('categorias.create');
    }

    // Guardar artículo
    public function store(CategoryRequest $request){
        try {
            $article = CategoryModel::createArticle($request->validated());
            return redirect()->route('admin.dashboard')->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de edición
    public function edit($articleId){
        try {
            $category = CategoryModel::findOrFail($articleId);
            return view('categorias.edit', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Categoría no encontrada.');
        }
    }

    // Actualizar artículo
    public function update(CategoryRequest $request, CategoryModel $category){
        try {
            $updated = $category->updateCategory($request->validated(), $category->id);

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
    public function destroy(CategoryModel $category)
    {
        try {

            $category->deleteCategory($category->id);
            return redirect()->route('admin.dashboard')->with('success', 'Artículo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
}
