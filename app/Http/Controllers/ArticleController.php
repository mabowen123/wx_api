<?php


namespace App\Http\Controllers;


use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function  list(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', Rule::in(Article::$types)] //1-首页 2-推荐 3-关注
        ]);

        $data = Article::select('id', 'user_id', 'title', 'clicks', 'likes')
            ->withType($request->type, Auth::id())
            ->with('user:id,nick_name,avatar_url')
            ->simplePaginate(Article::PAGINATE)
            ->toArray();

        return success($data);
    }
}
