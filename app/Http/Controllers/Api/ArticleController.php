<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    //save
    public function save(Request $request)
    {
        $data = $request->validate([
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|min:4',
            'text' => 'required|min:10',
        ]);

        return new ArticleResource(Article::create([
            'author_id' => $data['author_id'],
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'text' => $data['text'],
        ]));
    }
}
