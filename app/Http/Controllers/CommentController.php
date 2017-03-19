<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function index($article_id)
    {
    	//return Response::json(Comment::where('article_id',$article_id)->oldest()->get());
    }

    public function store(Request $request)
    {
    	Comment::create($request->all());
    	return redirect()->back();
    }

    public function destroy($id)
    {
    	Comment::destroy($id);
    }
}
