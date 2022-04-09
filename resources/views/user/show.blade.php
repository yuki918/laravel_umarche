<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品の詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-between">
                      <div class="md:w-48/100">
                        <div class="swiper">
                          <div class="swiper-wrapper">
                            <div class="swiper-slide">
                              @if ($product->imageFirst->filename !== null)
                                  <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" alt="">
                              @endif
                            </div>
                            <div class="swiper-slide">
                              @if ($product->imageSecond->filename !== null)
                                  <img src="{{ asset('storage/products/' . $product->imageSecond->filename) }}" alt="">
                              @endif
                            </div>
                            <div class="swiper-slide">
                              @if ($product->imageThird->filename !== null)
                                  <img src="{{ asset('storage/products/' . $product->imageThird->filename) }}" alt="">
                              @endif
                            </div>
                            <div class="swiper-slide">
                              @if ($product->imageFourth->filename !== null)
                                  <img src="{{ asset('storage/products/' . $product->imageFourth->filename) }}" alt="">
                              @endif
                            </div>
                          </div>
                          <div class="swiper-pagination"></div>
                          <div class="swiper-button-prev"></div>
                          <div class="swiper-button-next"></div>
                          <div class="swiper-scrollbar"></div>
                        </div>
                      </div>
                      <div class="md:w-48/100">
                        <h2 class="text-sm title-font mb-1 text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-4">{{ $product->name }}</h1>
                        <p class="leading-relaxed mb-4">{{ $product->information }}</p>
                        <div class="flex items-end">
                          <div class="text-center mr-4">
                            <span>数量</span>
                            <div class="relative">
                              <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                              </select>
                            </div>
                          </div>
                          <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}<span class="text-xs">円(税込み)</span></span>
                          <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/swiper.js') }}"></script>
</x-app-layout>