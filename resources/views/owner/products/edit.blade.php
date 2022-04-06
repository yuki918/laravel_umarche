<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <x-auth-validation-errors class="mb-4" :errors="$errors" />
                  <x-flash-message status="session('alert')" />
                  <form method="post" action="{{ route( 'owner.products.update' , ['product' => $product->id] ) }}">
                      @csrf
                      @method('put')
                      <div class="p-2 w-full md:w-1/2 m-auto">
                          <div class="relative">
                              <label for="name" class="leading-7 text-sm text-gray-600">商品名　※必須</label>
                              <input type="text" id="name" required name="name" value="{{ $product->name }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="information" class="leading-7 text-sm text-gray-600">商品情報</label>
                              <textarea name="information" id="information" cols="30" rows="5" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{$product->information }}</textarea>
                          </div>
                          <div class="relative mt-5">
                              <label for="price" class="leading-7 text-sm text-gray-600">価格　※必須</label>
                              <input type="number" id="price" required name="price" value="{{ $product->price }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="current_quantity" class="leading-7 text-sm text-gray-600">在庫数</label>
                              <input type="hidden" id="current_quantity" name="current_quantity" value="{{ $quantity }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              <div class="w-full bg-gray-100 bg-opacity-50 rounded text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $quantity }}</div>
                          </div>
                          <div class="flex items-center justify-center my-5">
                              <div class="flex items-center mr-8">
                                  <input type="radio" name="type" value="{{ \Constants::PRODUCT_LIST['add'] }}" checked class="mr-2">
                                  <span>在庫の追加</span>
                              </div>
                              <div class="flex items-center">
                                  <input type="radio" name="type" value="{{ \Constants::PRODUCT_LIST['reduce'] }}" class="mr-2">
                                  <span>在庫の削減</span>
                              </div>
                          </div>
                          <div class="relative mt-5">
                              <label for="quantity" class="leading-7 text-sm text-gray-600">在庫の増減　※必須</label>
                              <input type="number" id="quantity" required name="quantity" value="0" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              <span class="text-sm">※0から99までの数字で入力してください</span>
                          </div>
                          <div class="relative mt-5">
                              <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                              <input type="number" id="sort_order" name="sort_order" value="{{ $product->sort_order }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="shop_id" class="leading-7 text-sm text-gray-600">店舗名</label>
                              <select name="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  @foreach($shops as $shop)
                                      <option value="{{ $shop->id }}" @if($shop->id === $product->shop_id) selected @endif>
                                          {{ $shop->name }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="relative mt-5">
                              <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー名</label>
                              <select name="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  @foreach($categories as $category)
                                      <optgroup label="{{ $category->name }}">
                                          @foreach($category->secondary as $secondary)
                                              <option value="{{ $secondary->id }}" @if($secondary->id === $product->secondary_category_id) selected @endif>
                                                  {{ $secondary->name }}
                                              </option>
                                          @endforeach
                                      </optgroup>
                                  @endforeach
                              </select>
                          </div>
                          <div class="relative mt-5">
                              <p class="leading-7 text-sm text-gray-600">商品の画像</p>
                              <x-select-image :images="$images" name="image01" currentId="{{ $product->image01 }}" currentImage="{{ $product->imageFirst->filename ?? '' }}"/>
                              <x-select-image :images="$images" name="image02" currentId="{{ $product->image02 }}" currentImage="{{ $product->imageSecond->filename ?? '' }}"/>
                              <x-select-image :images="$images" name="image03" currentId="{{ $product->image03 }}" currentImage="{{ $product->imagethird->filename ?? '' }}"/>
                              <x-select-image :images="$images" name="image04" currentId="{{ $product->image04 }}" currentImage="{{ $product->imageFourth->filename ?? '' }}"/>
                              <x-select-image :images="$images" name="image05" display="hidden" />
                          </div>
                          <div class="flex items-center justify-center my-5">
                              <div class="flex items-center mr-8">
                                  <input type="radio" name="is_selling" value="1" class="mr-2" @if( $product->is_selling === 1 ) checked @endif>
                                  <span>販売中</span>
                              </div>
                              <div class="flex items-center">
                                  <input type="radio" name="is_selling" value="0" class="mr-2" @if( $product->is_selling === 0 ) checked @endif>
                                  <span>停止中</span>
                              </div>
                          </div>
                          <div class="flex justify-around p-2 w-full mt-6 my-5">
                              <button type="button" onclick="location.href='{{route('owner.products.index')}}'" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                              <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-400 rounded text-lg">更新</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <script>
    'use strict'
    const images = document.querySelectorAll('.image') //全てのimageタグを取得
    images.forEach(image => { // 1つずつ繰り返す
      image.addEventListener('click', function(e){ // クリックしたら
        const imageName = e.target.dataset.id.substr(0, 7) //data-idの6文字
        const imageId = e.target.dataset.id.replace(imageName + '_', '') // 6文字カット
        const imageFile = e.target.dataset.file
        const imagePath = e.target.dataset.path
        const modal = e.target.dataset.modal
        // サムネイルと input type=hiddenのvalueに設定
        document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
        document.getElementById(imageName + '_hidden').value = imageId
        MicroModal.close(modal); //モーダルを閉じる
      })
    })
  </script>
</x-app-layout>