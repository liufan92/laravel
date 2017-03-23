<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Like;
use Auth;
use DB;

class ArticlesController extends Controller
{
    public function index()
    {
        //Eloquent way
        //$articles = Article::all(); //get all
        $articles = Article::latest('created_at')->paginate(10);
        //$articles = Article::withTrashed()->paginate(10); //Get back soft deleted articles
        //$articles = Article::onlyTrashed()->paginate(10);
        //$articles = Article::whereLive(1)->get(); //get all articles where live = 1

        //Query Builder way
        //$articles = DB::table('articles')->get(); //get all
        //$articles = DB::table('articles')->whereLive(1)->get(); //get all articles where live = 1
        //$article = DB::table('articles')->whereLive(1)->first();
        //dd($article);

        //return $articles;
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //Validation
        $this->validate($request,[
            'content' => 'required|max:1000',
        ]);
        $message = 'Sorry! Post creation failed.';
        /*Method 1 for saving data into database
        $article = new Article;
        $article->user_id = Auth::user()->id;
        $article->content = $request->content;
        $article->live = (boolean)$request->live;
        $article->post_on = $request->post_on;

        $article->save();
        */

        //Method 2
        if(Article::create($request->all())){
            $message = 'Post successfully created!';
        };

        /*DB::table('articles')->insert([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
            'live'=> (boolean)$request->live,
            'post_on' => $request->post_on
        ]);*/

        //or the following if html field name does not match db_table coloumn names
        /*Article::create([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
            'live'=> $request->live,
            'post_on' => $request->post_on
        ]);*/
        //return redirect('/articles');
        return redirect()->back()->with(['message' => $message]);
    }

    public function show($id)
    {
        //$article = Article::find($id);
        //$article = Article::findOrFail($id);
        //return view('articles.show', compact('article'));

        $article = Article::findOrFail($id);
        $comments = $article->comments;
        return view('articles.show')
            ->with('article', $article)
            ->with('comments', $comments);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        echo $id;
        $article = Article::findOrFail($id);
        if(!isset($request->live))
            $article->update(array_merge($request->all(), ['live' => false]));
        else{
            $article->update($request->all());
        }

        //return redirect('/articles');
        return redirect('/articles');
    }

    public function destroy($id)
    {
        //Prevent other users from submitted delete request
        $article = Article::where('id', $id)->first();
        if(Auth::user() != $article->user){
            return redirect()->back();
        }

        //Destroy: Soft delete, mark article as delete
        Article::destroy($id);
            //Article::destroy([1,2,3,4]); //for multiple
        //Force delete in softDelete enabled table
        //$article = Article::findOrFail($id);
        //$article->forceDelete();

        //Delete: delete record from database permanently
        //$article = Article::findOrFail($id);
        //$article->delete();

        //return redirect('/articles');
        return redirect()->back();
    }

    public function postLikeArticle(Request $request)
    {
        $article_id = $request['articleId'];
        $article = Article::find($article_id);
        if(!$article){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('article_id', $article_id)->first();
        if($like){
            $like->delete();
            return null;
        }else{
            $like = new Like();
            $like->like = true;
            $like->user_id = $user->id;
            $like->article_id = $article->id;
            $like->save();
        }
        return null;
    }

    /* Unimplemented: restore soft deleted article
    public function restore($id)
    {
        $article = Article::findOrFail($id);
        $article->restore();
    }
    */
}
