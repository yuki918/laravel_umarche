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
                          <div class="relative text-center">
                              <select name="category" id="">
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
                          <x-select-image :images="$images" name="image01" />
                          <x-select-image :images="$images" name="image02" />
                          <x-select-image :images="$images" name="image03" />
                          <x-select-image :images="$images" name="image04" />
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