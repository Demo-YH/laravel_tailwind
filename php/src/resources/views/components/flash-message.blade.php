@props(['message', 'type' => 'status']) {{-- 'type' を追加してメッセージの種類を動的に変更できるようにする --}}

@php
    $class = '';
    $icon = '';
    switch ($type) {
        case 'status': // 成功や通常の情報
            $class = 'bg-green-100 border-green-400 text-green-700';
            $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'; // チェックマークアイコン (例)
            break;
        case 'error': // エラー
            $class = 'bg-red-100 border-red-400 text-red-700';
            $icon = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'; // Xマークアイコン (例)
            break;
        case 'saveDraft': // 下書き
            $class = 'bg-blue-100 border-blue-400 text-blue-700';
            $icon = 'M8 7V3m8 4V3m-9 8h8m-8 4h8m-8 4h8M3 4h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z'; // ドキュメントアイコン (例)
            break;
        // 必要に応じて他のタイプを追加
        default:
            $class = 'bg-gray-100 border-gray-400 text-gray-700';
            break;
    }
@endphp

@if(isset($message))
<div class="border px-4 py-3 rounded relative {{ $class }}" role="alert">
    <div class="flex items-center">
        @if ($icon)
            <svg class="h-5 w-5 {{ $type === 'error' ? 'text-red-500' : ($type === 'saveDraft' ? 'text-blue-500' : 'text-green-500') }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
            </svg>
        @endif
        <div>
            {{ $message }}
        </div>
    </div>
</div>
@endif