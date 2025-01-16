<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = ArticleModel::all();
        $articles = ArticleModel::paginate(5);
        // $articles = [];
        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $articles = ArticleModel::findOrFail($id);
        return view('articles.show', compact('articles'));
    }
}
