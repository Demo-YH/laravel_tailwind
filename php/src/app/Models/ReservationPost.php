<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationPost extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'reservation_posts';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'reservation_date',
        'reservation_time',
        'created_at',
        'updated_at'
    ];

    /**
     * 予約公開設定データをDBにinsert
     *
     * @param $post 投稿データ
     * @param $reservation_date 予約公開_日付
     * @param $reservation_time 予約公開_時間
     */
    public function insertReservationPostData(Post $post, string $reservation_date, string $reservation_time)
    {
        return $this->create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time
        ]);
    }

    /**
     * ユーザーIDと投稿IDをもとに予約公開予定の投稿データを取得
     *
     * @param int $user_id ユーザーID
     * @param int $post_id 投稿ID
     */
    public function getReservationPostByUserIdAndPostId(int $user_id, int $post_id)
    {
        return $this->where([
            ['user_id', $user_id],
            ['post_id', $post_id]
        ])
        ->first();
    }

    /**
     * 予約公開データを更新
     *
     * @param $reservationPost 予約公開データ
     * @param $reservation_date 予約日付
     * @param $reservation_time 予約時間
     */
    public function updateReservationPost(ReservationPost $reservationPost, string $reservation_date, string $reservation_time)
    {
        return $reservationPost->fill([
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time,
        ])->save();
    }

    /**
     * 予約公開データの削除
     *
     * @param $reservationPost 予約公開データ
     */
    public function deleteData($reservationPost)
    {
        return $reservationPost->delete();
    }

}
