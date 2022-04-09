<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('ホーム') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="flex flex-wrap justify-between">
                      @foreach( $products as $product )
                          <a class="block w-48/100 md:w-3/9 my-2" href="">
                              <div class="border rounded-md p-4">
                                  <x-thumbnail filename="{{ $product->imageFirst->filename ?? '' }}" type="products" />
                                  <p class="text-center mt-2 text-gray-600">{{ $product->name }}</p>
                              </div>
                          </a>
                      @endforeach
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>