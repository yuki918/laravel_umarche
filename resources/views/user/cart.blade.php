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
                            <div class="product flex items-start justify-between mb-8">
                                @if($product->imageFirst->filename)
                                    <img class="w-48/100" src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" alt="{{ $product->name }}の画像">
                                @else
                                    <img class="w-48/100" src="{{ asset('storage/products/' . 'no_image.jpg') }}" alt="{{ $product->name }}の画像">
                                @endif
                                <div class="w-48/100">
                                  <h3 class="text-sm title-font mb-1 text-gray-500 tracking-widest">{{ $product->category->name }}</h3>
                                  <h2 class="text-gray-900 text-3xl title-font font-medium mb-4">{{ $product->name }}</h2>
                                  <p>{{ $product->information }}</p>
                                  <div class="flex items-start text-center mt-4">
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