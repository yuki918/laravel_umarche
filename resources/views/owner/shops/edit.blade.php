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
                  <form method="post" action="{{ route( 'owner.shops.update' , ['shop' => $shop->id] ) }}" enctype="multipart/form-data">
                      @csrf
                      <div class="flex flex-wrap justify-center -m-2">
                          <div class="p-2 w-full md:w-1/2">
                              <div class="relative">
                                  <label for="image" class="leading-7 text-sm text-gray-600">店舗の画像を選択する</label>
                                  <input type="file" id="image" name="image" accept="image/png,image/jpg,image/jpeg" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                          </div>
                          <div class="flex justify-around p-2 w-full mt-6">
                              <button type="button" onclick="location.href='{{route('owner.shops.index')}}'" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                              <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-400 rounded text-lg">更新</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
