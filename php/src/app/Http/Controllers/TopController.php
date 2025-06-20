<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Services\UserService;

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
     */
    public function index()
    {
        $user_id = $this->userService->loginUserId();
        $categories = $this->category->getAllCategories();

        // 全ての投稿データを取得(publish_flgが公開のみ,最新更新日時順にソート)
        $posts = $this->post->getPostsSortByLatestUpdate();

        return view('top.index', compact(
            'user_id',
            'categories',
            'posts',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        $posts = $this->post->getPostByCategoryId($category_id);
        return view('article.category', compact(
            'user_id',
            'categories',
            'posts',
        ));
    }

}
