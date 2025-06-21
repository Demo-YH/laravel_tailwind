<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\PostRequest;

class Post extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
        'publish_flg',
        'view_counter',
        'favorite_counter',
        'delete_flg',
        'created_at',
        'updated_at'
    ];

    /**
     * Categoryモデルとリレーション
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    /**
     * ユーザーIDに紐づいた投稿リストを全て取得する
     *
     * @param int $user_id ユーザーID
     * @return Post
     */
    public function getAllPostsByUserId(int $user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['delete_flg', 0],
                        ])
                        ->with('category')
                        ->orderBy('updated_at', 'DESC');
        return $result;
    }

    /**
     * カテゴリーごとの記事を全て取得
     *
     * @param int $category_id カテゴリーID
     */
    public function getPostByCategoryId(int $category_id)
    {
        $result = $this->where([
                            ['category_id', $category_id],
                            ['delete_flg', 0],
        ]);
        return $result;
    }

    /**
     * リクエストされたデータをpostsテーブルにinsertする
     *
     * @param int $user_id ログインユーザーID
     * @param int $flg 押下ボタン判別用
     * @param array $request リクエストデータ
     * @return object $result App\Models\Post
     */
    public function insertPostToArticle(int $user_id, PostRequest $request, int $flg)
    {
        // created_atやupdated_atはmDB登録時に自動的に今日の日時で登録されるので、記載しない
        $result = $this->create([
            'user_id'          => $user_id,
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => $flg,
            'view_counter'     => 0,
            'favorite_counter' => 0,
            'delete_flg'       => 0,
        ]);

        return $result;
    }

    /**
     * リクエストされたデータをもとにpostデータを更新する
     * 記事の更新処理
     *
     * @param int $flg 押下ボタン判別用
     * @param array $request リクエストデータ
     * @return object $result App\Models\Post
     */
    public function updatePostToSaveArticle(PostRequest $request, Post $post, int $flg)
    {
        $result = $post->fill([
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => $flg,
        ])->save();

        return $result;
    }

    /**
     * 投稿IDをもとにpostsテーブルから一意の投稿データを取得
     *
     * @param int $post_id 投稿ID
     * @return object $result App\Models\Post
     */
    public function feachPostDateByPostId(int $post_id)
    {
        $result = $this->find($post_id);
        return $result;
    }

    /**
     * 投稿データを全て取得し、最新更新日時順にソート
     */
    public function getPostsSortByLatestUpdate()
    {
        $result = $this->where([
                            ['publish_flg', 1],
                            ['delete_flg', 0],
                        ])
                       ->orderBy('updated_at', 'DESC')
                       ->with('user')
                       ->with('category')
                       ->get();
        return $result;
    }

    /**
     * ゴミ箱一覧の記事を取得
     *
     * @param int $user_id ユーザーID
     * @return object $result App\Models\Post
     */
    public function getTrashPostLists(int $user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['delete_flg', 1],
        ]);
        return $result;
    }

    /**
     * 記事の論理削除(ゴミ箱に移動)
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function moveTrashPostData(Post $post)
    {
        $result = $post->fill([
            'publish_flg' => 0,
            'delete_flg' => 1
        ]);
        $result->save();
        return $result;
    }

    /**
     * 記事の復元
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function restorePostData(Post $post)
    {
        $result = $post->fill([
            'publish_flg' => 0,
            'delete_flg' => 0
        ]);
        $result->save();
        return $result;
    }

    /**
     * 記事の削除
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function deletePostData(Post $post)
    {
        $result = $post->delete();
        return $result;
    }

    /**
     * 下書き保存の記事一覧を取得
     *
     * @param int $user_id ログイン中のユーザーID
     * @return object $result App\Models\Post
     */
    public function getArticlePosts(int $user_id, int $flg)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['publish_flg', $flg],
                            ['delete_flg', 0]
                        ])
                        ->orderBy('updated_at', 'DESC');
        return $result;
    }

}