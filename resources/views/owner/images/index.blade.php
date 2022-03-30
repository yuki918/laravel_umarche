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
                    <a href="/owner/images/create" class="inline-block text-white bg-blue-500 border-0 py-2 px-8 mb-8 mr-auto focus:outline-none hover:bg-blue-300 rounded text-lg">新規登録</a>
                  </div>
                  <div class="flex flex-wrap justify-between">
                      @foreach( $images as $image )
                        <a class="block w-48/100 md:w-3/9 my-2" href="{{ route( 'owner.images.edit' , [ 'image' => $image->id ] ) }}">
                              <div class="border rounded-md p-4">
                                  <p class="text-xl">{{ $image->name }}</p>
                                  <x-thumbnail :filename="$image->filename" type="products" />
                              </div>
                          </a>
                      @endforeach
                  </div>
                  {{ $images->links() }}
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
