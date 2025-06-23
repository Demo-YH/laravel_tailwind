{{-- resources/views/user/list/monthly_graph.blade.php --}}

<x-user-app>

    {{-- ページのタイトルをuser-appコンポーネントの'title'スロットに渡す --}}
    <x-slot:title>
        月別記事数グラフ
    </x-slot:title>

    {{-- サイドバーは、user-appコンポーネントの'sidebar_user'スロットに渡す --}}
    <x-slot:sidebar_user>
        <x-sidebar_user />
    </x-slot:sidebar_user>

    <section class="p-6"> {{-- セクションに余白を追加してコンテンツが見やすくなるようにしました --}}
        <div class="container mx-auto bg-white rounded-lg shadow-md p-6"> {{-- コンテナ全体を囲む --}}
            <h1 class="text-2xl font-bold mb-6 text-center">月別記事数グラフ</h1>

            {{-- グラフのコンテナの幅と高さを調整 --}}
            {{-- Tailwind CSS のクラスで幅と高さを調整。mx-auto で中央寄せ --}}
            <div class="mx-auto" style="width: 80%; height: 500px;"> {{-- 幅を80%に、高さを500pxに設定 --}}
                {{-- canvas の ID を JavaScript と一致させました --}}
                <canvas id="monthlyPostsChart"></canvas>
            </div>

        </div>
    </section>

    {{-- Chart.js のCDNとグラフ描画スクリプト --}}
    {{-- スクリプトはページコンテンツの後に配置し、DOMがロードされてから実行されるようにします --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // コントローラーから渡されたデータをJavaScript変数に代入
        const labels = @json($labels); // 月のラベル (例: ['2023-01', '2023-02'])
        const data = @json($data);     // 各月の記事数 (例: [10, 15])

        // canvas 要素を取得。IDを 'monthlyPostsChart' に統一しました
        const ctx = document.getElementById('monthlyPostsChart').getContext('2d');
        const monthlyPostsChart = new Chart(ctx, {
            type: 'line', // 折れ線グラフに設定
            data: {
                labels: labels,
                datasets: [{
                    label: '記事数',
                    data: data,
                    fill: false, // 線の下を塗りつぶさない
                    borderColor: 'rgba(75, 192, 192, 1)', // 線の色
                    tension: 0.1, // 線を滑らかにする
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)', // 点の色
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // コンテナのサイズに合わせて調整
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: '記事数'
                        },
                        // Y軸の目盛りを整数に限定 (記事数は整数なので)
                        ticks: {
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: '月'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // 凡例を非表示
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    </script>
</x-user-app>