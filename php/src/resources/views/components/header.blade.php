<!DOCTYPE html>
    <header class="text-gray-600 body-font">
        <div class="mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" id="Allergens-Fish--Streamline-Flex-Gradient" height="25" width="25">
                <desc>
                    Allergens Fish Streamline Icon: https://streamlinehq.com
                </desc>
                <g id="allergens-fish--fish-produce-food-allergens-allergy">
                    <path id="Subtract" fill="url(#paint0_linear_9371_11622)" fill-rule="evenodd" d="M9.20672.0101937C10.5996.0860527 11.9618.582728 12.6894 1.31027c.7276.72754 1.2244 2.0897 1.3004 3.48254.0768 1.40876-.2689 2.98704-1.3973 4.11544-1.7644 1.76455-4.30922 2.38815-6.55018 2.45205-.15107.8316-.57953 1.615-.91692 2.1382-.48798.7569-1.50854.5979-1.90182-.0827l-.96615-1.6721-1.673228-.9668c-.6805823-.3933-.83959-1.41379-.082816-1.90179.523284-.33744 1.306634-.76599 2.138334-.91713.06375-2.24092.68719-4.78575 2.45159-6.55025C6.21965.279303 7.79793-.0665323 9.20672.0101937ZM7.31258 3.63911c.33169-.09556.67804.09585.77361.42754.19404.67349.71755 1.53356 1.84116 1.84813.33235.09306.52645.43795.43335.77035-.0931.33239-.43796.52641-.77036.43335-1.6661-.46644-2.43238-1.75849-2.70531-2.70578-.09556-.33168.09586-.67803.42755-.77359Zm2.46593.40326c-.24409-.24406-.24411-.63979-.00003-.88387.24402-.24409.63982-.2441.88392-.00003l.1795.17954c.2441.24406.2441.63979.0001.88387-.2441.24409-.6398.2441-.88393.00003l-.17956-.17954Z" clip-rule="evenodd"></path>
                </g>
                <defs>
                    <linearGradient id="paint0_linear_9371_11622" x1="13.953" x2="-2.626" y1="14.003" y2="4.677" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#ff51e3"></stop>
                        <stop offset="1" stop-color="#1b4dff"></stop>
                    </linearGradient>
                </defs>
            </svg>
            <span class="ml-3 text-2xl">辛ぇ辛ぇ草ｗｗ</span>
            </a>
            <div class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
                <div class="mb-1 xl:w-96">
                    <form action="{{ route('top.index') }}" method="GET" class="flex">
                        <input
                            type="search"
                            class="form-control block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded-l transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="search"
                            name="keyword"
                            placeholder="ニュースを検索..."
                            value="{{ request('keyword') }}"
                        />
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r flex items-center justify-center">
                            検索
                        </button>
                    </form>
                    @if (request('keyword'))
                    <p class="text-sm text-gray-500 mt-2">
                    「{{ request('keyword') }}」の検索結果: {{ $posts_count }}  件
                    </p>
                    @endif
                </div>
            </div>

            {{-- 認証によって、ボタン表示の切り替え --}}
            @auth
            <button class="inline-flex text-white items-center bg-emerald-500 border-0 py-1 px-3 mx-2 focus:outline-none hover:bg-emerald-400 rounded text-base mt-4 md:mt-0">
                <a href="{{ route('user.index', ['id' => Auth::id()]) }}">マイページ</a>
            </button>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="inline-flex text-white items-center bg-red-500 border-0 py-1 px-3 mx-2 focus:outline-none hover:bg-red-400 rounded text-base mt-4 md:mt-0">
                    ログアウト
                </button>
            </form>
            @else
                <button class="inline-flex text-white items-center bg-emerald-500 border-0 py-1 px-3 mx-2 focus:outline-none hover:bg-emerald-400 rounded text-base mt-4 md:mt-0">
                    <a href="{{ route('register') }}">新規登録</a>
                </button>
                <button class="inline-flex text-white items-center bg-emerald-500 border-0 py-1 px-3 mx-2 focus:outline-none hover:bg-emerald-400 rounded text-base mt-4 md:mt-0">
                    <a href="{{ route('login') }}">ログイン</a>
                </button>
            @endauth
        </div>
    </header>
</html>