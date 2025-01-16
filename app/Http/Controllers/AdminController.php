<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CategoryModel;
use App\Models\ArticleModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $users = User::getPaginatedUsers(10);
        $categories = CategoryModel::getPaginatedArticles(10);
        $articles = ArticleModel::getPaginatedArticles(5);
        return view('admin.dashboard', compact('users', 'categories', 'articles'));
    }
}

