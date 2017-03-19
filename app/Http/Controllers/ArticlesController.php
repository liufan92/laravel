<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Auth;
use DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent way
        //$articles = Article::all(); //get all
        $articles = Article::paginate(10);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Method 1 for saving data into database
        $article = new Article;
        $article->user_id = Auth::user()->id;
        $article->content = $request->content;
        $article->live = (boolean)$request->live;
        $article->post_on = $request->post_on;

        $article->save();
        */

        //Method 2
        Article::create($request->all());

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
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        if(!isset($request->live))
            $article->update(array_merge($request->all(), ['live' => false]));
        else
            $article->update($request->all());

        //return redirect('/articles');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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

    /* Unimplemented: restore soft deleted article
    public function restore($id)
    {
        $article = Article::findOrFail($id);
        $article->restore();
    }
    */
}
