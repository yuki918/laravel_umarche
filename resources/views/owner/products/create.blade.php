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
                  <form method="post" action="{{ route( 'owner.products.store' ) }}">
                      @csrf
                      <div class="p-2 w-full md:w-1/2 m-auto">
                          <div class="relative">
                              <label for="name" class="leading-7 text-sm text-gray-600">商品名　※必須</label>
                              <input type="text" id="name" required name="name" value="{{ old('name') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="information" class="leading-7 text-sm text-gray-600">商品情報</label>
                              <textarea name="information" id="information" cols="30" rows="5" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                          </div>
                          <div class="relative mt-5">
                              <label for="price" class="leading-7 text-sm text-gray-600">価格　※必須</label>
                              <input type="number" id="price" required name="price" value="{{ old('price') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫　※必須</label>
                              <input type="number" id="quantity" required name="quantity" value="{{ old('quantity') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                              <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          </div>
                          <div class="relative mt-5">
                              <label for="shop_id" class="leading-7 text-sm text-gray-600">店舗名</label>
                              <select name="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  @foreach($shops as $shop)
                                      <option value="{{ $shop->id }}">
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
                                              <option value="{{ $secondary->id }}">
                                                  {{ $secondary->name }}
                                              </option>
                                          @endforeach
                                      </optgroup>
                                  @endforeach
                              </select>
                          </div>
                          <div class="relative mt-5">
                              <p class="leading-7 text-sm text-gray-600">商品の画像</p>
                              <x-select-image :images="$images" name="image01" />
                              <x-select-image :images="$images" name="image02" />
                              <x-select-image :images="$images" name="image03" />
                              <x-select-image :images="$images" name="image04" />
                              <x-select-image :images="$images" name="image05" />
                          </div>
                          <div class="flex items-center justify-center my-5">
                              <div class="flex items-center mr-8">
                                  <input type="radio" name="is_selling" value="1" checked class="mr-2">
                                  <span>販売中</span>
                              </div>
                              <div class="flex items-center">
                                  <input type="radio" name="is_selling" value="0" class="mr-2">
                                  <span>停止中</span>
                              </div>
                          </div>
                          <div class="flex justify-around p-2 w-full mt-6 my-5">
                              <button type="button" onclick="location.href='{{route('owner.products.index')}}'" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                              <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-400 rounded text-lg">登録</button>
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