<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Models\ReservationPost;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\User\TrashController;
use App\Http\Controllers\TopController;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    /**
     * __construct
     */
    public function __construct(protected Post $post, protected Category $category, protected ReservationPost $reservationPost)
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
        $user_id = auth()->user()->id;

        $categories = $this->category->getAllCategories();
        // 投稿IDをもとに特定の投稿データを取得
        $post = $this->post->feachPostDateByPostId($post_id);

        // 記事のステータスが予約公開以外はそもそも予約公開データはないので初期値はnullをセット
        $date = null;
        $time = null;
        // 投稿IDをもとに予約公開データを取得
        $reservationPost = $this->reservationPost->getReservationPostByUserIdAndPostId($user_id, $post_id);
        // 予約公開データがあれば予約日時を取得
        if (isset($reservationPost)) {
            // 年・月・日にそれぞれ文字を切り出し
            // (20220530→2022)
            $year = substr($reservationPost->reservation_date, 0, 4);
            // (20220530→05)
            $month = substr($reservationPost->reservation_date, 4, 2);
            // (20220530→30)
            $day = substr($reservationPost->reservation_date, 6, 2);
            // 上記に年月日をつける(2022年05月30日)
            $date = $year . '年' . $month . '月' . $day;

            // 時・分にそれぞれ文字を切り出し
            // (083200→08)
            $hour = substr($reservationPost->reservation_time, 0, 2);
            // (083200→32)
            $minute = substr($reservationPost->reservation_time, 2, 2);
            // 上記に時・分をつける
            $time = $hour . '時' . $minute . '分';
        }


        return view('user.list.edit', compact(
            'categories',
            'post',
            'date',
            'time'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, int $post_id)
    {
        $user_id = auth()->user()->id;

        $post = $this->post->feachPostDateByPostId($post_id);
        $reservationPost = $this->reservationPost->getReservationPostByUserIdAndPostId($user_id, $post_id);

        $validatedData = $request->validated();

        if ($request->has('release')) {
            $publish_flg = 1; // 公開
            if (isset($reservationPost)) {
                // 予約公開データの削除
                $this->reservationPost->deleteData($reservationPost);
            }
            $request->session()->flash('updateRelease', '記事を更新し公開しました。');

        } elseif ($request->has('reservation_release')) {
            $publish_flg = 2; // 予約公開
            // 上記でもしデータがあれば、ステータスを下書きに戻すため予約公開データは不要のため削除する
            if (isset($reservationPost)) {
                // 予約公開データの削除
                $this->reservationPost->deleteData($reservationPost);
            }
            $request->session()->flash('updateReservationRelease', '記事を予約公開で更新しました。');

        } else {
            $publish_flg = 0; // デフォルトは下書き (save_draft)
            // 上記でもしデータがあれば、ステータスを下書きに戻すため予約公開データは不要のため削除する
            if (isset($reservationPost)) {
                // 予約公開データの削除
                $this->reservationPost->deleteData($reservationPost);
            }
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

    public function reservationUpdate(Request $request, $post_id)
    {
        // ログインユーザー情報を取得
        $user_id = auth()->user()->id;

        // 投稿IDをもとに特定の投稿データを取得
        $post = $this->post->feachPostDateByPostId($post_id);
        // 投稿データを更新
        $this->post->updatePostToReservationRelease($request, $post);

        // 画面で入力した予約設定_日付を取得
        $date = $request->reservation_date;
        // リクエストが2022-04-30とくるので、20220430に整形
        $reservation_date = str_replace('-', '', $date);
        // 画面で入力した予約時間_時を取得
        $hour = $request->reservation_hour;
        // 画面で入力した予約時間_分を取得
        $minute = $request->reservation_minute;
        // 予約時間_時と予約時間_分を合体し、末尾に00をつけてデータを整形。ex.173100
        $reservation_time = $hour . $minute . '00';

        // ユーザーIDと投稿IDをもとに更新する予約公開記事のデータを1件取得
        $reservationPost = $this->reservationPost->getReservationPostByUserIdAndPostId($user_id, $post_id);

        // 下書き→公開予約する際、そもそも予約公開データはないので$reservationPostはnullになり、画面でエラーになる。そのため制御
        if (!isset($reservationPost)) {
            // 予約公開設定内容をreservation_postsテーブルにinsert
            $this->reservationPost->insertReservationPostData(
                $post,
                $reservation_date,
                $reservation_time
            );

            // セッションにフラッシュメッセージを格納
            $request->session()->flash('updateReservationRelease', '記事を予約公開で更新しました。');
            // 投稿一覧画面にリダイレクト
            return to_route('user.index', ['id' => $user_id]);
        }

        // すでに投稿IDに紐づく予約公開データがあれば、その予約公開データを更新
        $this->reservationPost->updateReservationPost(
            $reservationPost,
            $reservation_date,
            $reservation_time
        );

        // セッションにフラッシュメッセージを格納
        $request->session()->flash('updateReservationRelease', '記事を予約公開で更新しました。');
        // 投稿一覧画面にリダイレクト
        return to_route('user.index', ['id' => $user_id]);
    }
}