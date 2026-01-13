<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;

class TopController extends Controller
{
    public function __construct(Post $post, Category $category, UserService $userService)
    {
        $this->post = $post;
        $this->category = $category;
        $this->userService = $userService;
    }
    /**
     * 総合トップ画面
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user_id = $this->userService->loginUserId(); // ユーザーIDが必要であれば残す
        $categories = $this->category->getAllCategories();

        $keyword = $request->input('keyword'); // リクエストからキーワードを取得

        // Postモデルのクエリビルダーを初期化
        $postsQuery = Post::query()
            ->where('publish_flg', 1) // 公開済みの投稿のみ
            ->where('delete_flg', 0);  // 削除されていない投稿のみ

        // キーワードが存在する場合のみ検索条件を追加
        if (!empty($keyword)) {
            $postsQuery->where(function ($query) use ($keyword) {
                // 論理的なAND (タイトルにキーワード OR 本文にキーワード)
                $query->where('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('body', 'LIKE', "%{$keyword}%");
            });
        }

        // 最終的な結果を取得し、並べ替える
        $posts = $postsQuery->get(); // コレクションを取得

        $posts_count = count($posts);

        return view('top.index', compact(
            'user_id',
            'categories',
            'posts',
            'keyword',
            'posts_count',
        ));
    }

    /**
     * 記事詳細
     *
     * @param int $post_id 記事ID
     * @return Response src/resources/views/article/show.blade.php
     */
    public function articleShow(int $post_id)
    {
        $user_id = $this->userService->loginUserId();

        // カテゴリーを全て取得
        $categories = $this->category->getAllCategories();
        // 記事IDをもとに特定の記事のデータを取得
        $post = $this->post->feachPostDateByPostId($post_id);
        return view('article.show', compact(
            'user_id',
            'categories',
            'post',
        ));
    }

    /**
     * カテゴリーごとの記事
     *
     * @param int $category_id カテゴリーID
     * @return Response src/resources/views/article/category.blade.php
     */
    public function articleCategory(int $category_id)
    {
        $user_id = $this->userService->loginUserId();

        $categories = $this->category->getAllCategories();
        // カテゴリーIDをもとにカテゴリーごとの記事を取得
        $posts = $this->post->getPostByCategoryId($category_id)->Paginate(3);
        return view('article.category', compact(
            'user_id',
            'categories',
            'posts',
        ));
    }

}