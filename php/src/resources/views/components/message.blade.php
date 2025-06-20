<div>
    @props(['message', 'type' => 'status']) {{-- 'type' を追加してメッセージの種類を動的に変更できるようにする --}}

    @php
        $class = '';
        $icon = '';
        $iconColorClass = ''; // アイコンの色を制御するためのクラス

        switch ($type) {
            case 'status': // 成功や通常の情報
                $class = 'bg-green-100 border border-green-400 text-green-700';
                $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'; // チェックマークアイコン (例)
                $iconColorClass = 'text-green-500';
                break;
            case 'error': // エラー
                $class = 'bg-red-100 border border-red-400 text-red-700';
                $icon = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'; // Xマークアイコン (例)
                $iconColorClass = 'text-red-500';
                break;
            case 'saveDraft': // 下書き保存
            case 'updateSaveDraft': // 更新：下書き保存
                $class = 'bg-blue-100 border border-blue-400 text-blue-700';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)
                $iconColorClass = 'text-blue-500';
                break;
            case 'release': // 公開
            case 'updateRelease': // 更新：公開
                $class = 'bg-green-100 border border-green-400 text-green-700';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)
                $iconColorClass = 'text-green-500';
                break;
            case 'reservationRelease': // 公開予約
            case 'updateReservationRelease': // 更新：公開予約
                $class = 'bg-amber-100 border border-amber-400 text-amber-700';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)
                $iconColorClass = 'text-amber-500';
                break;
            case 'moveTrash': // ゴミ箱:ゴミ箱に移動
                $class = 'bg-violet-200 border-t border-b border-violet-500 text-violet-700 text-center px-4 py-3 font-bold';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)

                break;
            case 'restore': // ゴミ箱：記事を復元
                $class = 'bg-sky-200 border-t border-b border-sky-500 text-sky-700 text-center px-4 py-3 font-bold';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)

                break;
            case 'delete': // ゴミ箱：記事を削除
                $class = 'bg-red-200 border-t border-b border-red-500 text-red-700 text-center px-4 py-3 font-bold';
                $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)

                break;

            default:
                $class = 'bg-gray-100 border border-gray-400 text-gray-700';
                $iconColorClass = 'text-gray-500';
                break;
        }
    @endphp

    @if(isset($message)) {{-- $messageが存在する場合にのみ表示 --}}
        <div class="border px-4 py-3 rounded relative {{ $class }}" role="alert">
            <div class="flex items-center">
                @if ($icon)
                    <svg class="h-5 w-5 {{ $iconColorClass }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                    </svg>
                @endif
                <div>
                    {{ $message }}
                </div>
            </div>
        </div>
    @endif
</div>