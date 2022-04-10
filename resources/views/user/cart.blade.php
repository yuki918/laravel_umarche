<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($products) > 0)
                        @foreach($products as $product)
                            <div class="product md:flex items-start justify-between mb-8">
                                @if($product->imageFirst->filename)
                                    <img class="w-full md:w-48/100" src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" alt="{{ $product->name }}の画像">
                                @else
                                    <img class="w-full md:w-48/100" src="{{ asset('storage/products/' . 'no_image.jpg') }}" alt="{{ $product->name }}の画像">
                                @endif
                                <div class="w-full md:w-48/100 mt-4 md:mt-0">
                                  <h3 class="text-sm title-font mb-1 text-gray-500 tracking-widest">カテゴリー：{{ $product->category->name }}</h3>
                                  <h2 class="text-gray-900 text-3xl title-font font-medium mb-4">{{ $product->name }}</h2>
                                  <p>{{ $product->information }}</p>
                                  <div class="flex items-start justify-between flex-wrap md:flex-nowrap text-center mt-4">
                                    <div class="flex items-start">
                                      <p class="mr-4">
                                        <span class="block text-xs">金額</span>
                                        <span class="block">{{ number_format($product->price) }}<small class="text-xs">円</small></span>
                                      </p>
                                      <p class="mr-4">
                                        <span class="block text-xs">個数</span>
                                        <span class="block">{{ $product->pivot->quantity }}</span>
                                      </p>
                                      <p>
                                        <span class="block text-xs">合計金額</span>
                                        <span class="block">{{ number_format($product->price * $product->pivot->quantity) }}<small class="text-xs">円(税込)</small></span>
                                      </p>
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                      <form method="post" action="{{ route('user.cart.delete' , ['item' => $product->id]) }}">
                                          @csrf
                                          <button class="flex items-center text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="ml-2">削除する</span>
                                          </button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>カートに商品はありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>