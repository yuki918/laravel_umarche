<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">削除済みオーナー一覧</h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <section class="text-gray-600 body-font">
                    <div class="container mx-auto sm:px-5 sm:py-6">
                      <x-flash-message status="session('status')" />
                      <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        @if(!$expiredOwners->isEmpty())
                          <table class="w-full table-auto text-left whitespace-no-wrap">
                            <thead>
                              <tr>
                                <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除日</th>
                                <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">完全に削除</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($expiredOwners as $expiredOwner)
                                <tr>
                                  <td class="px-4 py-3 border border-solid border-gray-300">{{$expiredOwner->name}}</td>
                                  <td class="px-4 py-3 border border-solid border-gray-300">{{$expiredOwner->email}}</td>
                                  <td class="px-4 py-3 border border-solid border-gray-300">{{$expiredOwner->deleted_at->format('Y年m月d日')}}</td>
                                  <td class="px-4 py-3 border border-solid border-gray-300 text-center">
                                    <form id="delete_{{$expiredOwner->id}}" method="post" action="{{route('admin.expired-owners.destroy',['owner' => $expiredOwner->id])}}">
                                      @csrf
                                      {{-- @method("delete") --}}
                                      <a data-id="{{$expiredOwner->id}}" onclick="deletePost(this)" class="text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-400 rounded">完全に削除</a>
                                    </form>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        @else
                          <p class="text-center">削除済みのオーナーはありません。</p>
                        @endif
                      </div>
                    </div>
                  </section>
              </div>
          </div>
      </div>
  </div>
  <script>
    function deletePost(e) {
      'use strict';
      if (confirm('本当に削除してもいいですか?')) {
        document.getElementById('delete_' + e.dataset.id).submit();
      }
    }
  </script>
</x-app-layout>
