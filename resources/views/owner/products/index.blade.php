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
                  <x-flash-message status="session('status')" />
                  <div class="text-right lg:w-2/3 w-full mx-auto">
                    <a href="/owner/products/create" class="inline-block text-white bg-blue-500 border-0 py-2 px-8 mb-8 mr-auto focus:outline-none hover:bg-blue-300 rounded text-lg">新規登録</a>
                  </div>
                  <div class="flex flex-wrap justify-between">
                      @foreach( $ownerInfo as $owner )
                          @foreach( $owner->shop->product as $product )
                              <a class="block w-48/100 md:w-3/9 my-2" href="{{ route( 'owner.products.edit' , [ 'product' => $product->id ] ) }}">
                                  <div class="border rounded-md p-4">
                                      <x-thumbnail :filename="$product->imageFirst->filename" type="products" />
                                      <p class="text-center mt-2 text-gray-600">{{ $product->name }}</p>
                                  </div>
                              </a>
                          @endforeach
                      @endforeach
                  </div>
                  {{-- {{ $images->links() }} --}}
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
