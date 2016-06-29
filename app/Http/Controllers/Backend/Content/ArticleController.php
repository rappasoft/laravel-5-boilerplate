<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Controllers\Controller;
use App\Models\Content\Article\Article;
use App\Http\Requests\Backend\Content\Article\StoreArticleRequest;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        javascript()->put([
            'test' => 'it works!',
        ]);

        $models = Article::withTrashed()->paginate(10);
        
        return view('backend.content.article.index', ['models'=> $models]);
    }
    
    /**
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function view(int $id)
    {
        $model = Article::withTrashed()->find($id);
        
        return view('backend.content.article.view', ['model' => $model]);
    }
    
    /**
     * 
     * @param \Illuminate\Http\Request; $request
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new Article();
        
        return view('backend.content.article.create', ['model' => $model]);
    }
    
    /**
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $model = Article::withTrashed()->find($id);
        
        return view('backend.content.article.edit', ['model' => $model]);
    }
    
    /**
     * 
     * @param \Illuminate\Http\Request; $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function update(Request $request, int $id)
    {
        $model = Article::withTrashed()->find($id);
        $model->fill($request->all())->save();
        
        return redirect('admin/content/article');
    }
    
    /**
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function store(StoreArticleRequest $request)
    {
        Article::create($request->all());
        
        return redirect('admin/content/article');
    }
    
    /**
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function destroy(int $id)
    {
        Article::destroy($id);
        
        return redirect()->back();
    }
    
    /**
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function restore(int $id)
    {
        Article::withTrashed()->find($id)->restore();
        
        return redirect()->back();
    }
}
