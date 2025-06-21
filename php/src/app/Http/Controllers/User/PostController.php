<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\User\TrashController;
use App\Http\Controllers\TopController;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    /**
     * __construct
     */
    public function __construct(protected Post $post, protected Category $category)
    {
    }

    /**
     * 投稿リスト
     *
     * @param int $id ユーザーID
     * @return Response src/resources/views/user/list/index.blade.phpを表示
     */
    public function index(int $id)
    {
        // ユーザーIDと一致する投稿データを取得
        $posts = $this->post->getAllPostsByUserId($id)->Paginate(10);
        $categories = $this->category->getAllCategories();
        return view('user.list.index', compact(
            'posts',
            'categories',
        ));
    }

    /**
     * 記事投稿画面
     *
     * @return Response src/resources/views/user/list/create.blade.phpを表示
     */
    public function create()
    {
        $categories = $this->category->getAllCategories();
        return view('user.list.create', compact(
            'categories',
        ));
    }

    /**
     * 記事投稿処理
     *
     * @param string $request リクエストデータ
     * @return Response src/resources/views/user/list/index.blade.phpを表示
     */
    public function store(PostRequest $request)
    {
        // ログインしているユーザー情報を取得
        $user_id = auth()->user()->id;

        $validatedData = $request->validated();

        if ($request->has('release')) {
            $publish_flg = 1; // 公開
            $request->session()->flash('release', '記事を公開しました。');
        } elseif ($request->has('reservation_release')) {
            $publish_flg = 2; // 予約公開
            $request->session()->flash('reservationRelease', '記事を予約公開しました。');
        } else {
            $publish_flg = 0; // デフォルトは下書き (save_draft)
            $request->session()->flash('saveDraft', '記事を下書きで保存しました。');
        }

        $this->post->insertPostToArticle($user_id, $request, $publish_flg);

        return to_route('user.index', ['id' => $user_id]);
    }

    /**
     * 記事詳細
     *
     * @param int int $post_id 投稿ID
     * @return Response src/resources/views/user/list/show.blade.phpを表示
     */
    public function show(int $post_id)
    {
        // リクエストされた投稿IDをもとにpostsテーブルから一意のデータを取得
        $showPostData = $this->post->feachPostDateByPostId($post_id);
        return view('user.list.show', compact(
            'showPostData',
        ));
    }

    public function edit(int $post_id)
    {
        $categories = $this->category->getAllCategories();
        // 投稿IDをもとに特定の投稿データを取得
        $post = $this->post->feachPostDateByPostId($post_id);
        return view('user.list.edit', compact(
            'categories',
            'post',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, int $post_id)
    {
        $user_id = auth()->user()->id;

        $post = $this->post->feachPostDateByPostId($post_id);

        $validatedData = $request->validated();

        if ($request->has('release')) {
            $publish_flg = 1; // 公開
            $request->session()->flash('updateRelease', '記事を更新し公開しました。');
        } elseif ($request->has('reservation_release')) {
            $publish_flg = 2; // 予約公開
            $request->session()->flash('updateReservationRelease', '記事を予約公開で更新しました。');
        } else {
            $publish_flg = 0; // デフォルトは下書き (save_draft)
            $request->session()->flash('updateSaveDraft', '記事を下書き保存で更新しました。');
        }

        $this->post->updatePostToSaveArticle($request, $post, $publish_flg);

        return to_route('user.index', ['id' => $user_id]);

    }

    /**
     * 下書き保存一覧
     *
     * @return Response src/resources/views/user/list/saveDraft.blade.phpを表示
     */
    public function saveDraft(Request $request)
    {
        $user_id = auth()->user()->id;
        $publish_flg = 0;

        // 下書き保存の記事一覧を取得
        $saveDrafts = $this->post->getArticlePosts($user_id, $publish_flg)->Paginate(10);
        return view('user.list.saveDraft', compact(
            'saveDrafts',
        ));
    }

    /**
     * 公開中記事一覧
     *
     * @return Response src/resources/views/user/list/release.blade.phpを表示
     */
    public function release(Request $request)
    {
        $user_id = auth()->user()->id;

        $publish_flg = 1;

        // 公開中の記事一覧を取得
        $releases = $this->post->getArticlePosts($user_id, $publish_flg)->Paginate(10);
        return view('user.list.release', compact(
            'releases',
        ));
    }

    /**
     * 予約公開記事一覧
     *
     * @return Response src/resources/views/user/list/release.blade.phpを表示
     */
    public function reservationRelease()
    {
        $user_id = auth()->user()->id;

        $publish_flg = 2;

        // 予約公開の記事一覧を取得
        $reservationPosts = $this->post->getArticlePosts($user_id, $publish_flg)->Paginate(10);
        return view('user.list.reservationRelease', compact(
            'reservationPosts',
        ));
    }

}