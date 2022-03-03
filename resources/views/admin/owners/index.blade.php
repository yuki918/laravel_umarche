<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーナー一覧</h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                    {{-- エロクアント
                    @foreach($e_all as $e_owner)
                        {{$e_owner->name}}
                        {{$e_owner->created_at}}
                        出力結果：2022-01-01 11:11:11

                        カーボンインスタンスを利用する場合
                        {{$e_owner->created_at->diffForHumans()}}
                        出力結果：1ヶ月前
                    @endforeach
                    <br>
                    クエリビルダー
                    @foreach($q_get as $e_owner)
                        {{$e_owner->name}}
                        {{$e_owner->created_at}}
                        カーボンインスタンスを利用する場合
                        {{Carbon\Carbon::parse($e_owner->created_at)->diffForHumans()}}
                    @endforeach --}}

                  {{-- @foreach($owners as $owner)
                      {{$owner->name}}
                      {{$owner->email}}
                      {{$owner->created_at->diffForHumans()}}
                  @endforeach --}}
                  <section class="text-gray-600 body-font">
                    <div class="container mx-auto sm:px-5 sm:py-6">
                      <x-flash-message status="info" />
                      <div class="text-right lg:w-2/3 w-full mx-auto">
                        <a href="/admin/owners/create" class="inline-block text-white bg-blue-500 border-0 py-2 px-8 mb-8 mr-auto focus:outline-none hover:bg-red-600 rounded text-lg">新規登録</a>
                      </div>
                      <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <table class="w-full table-auto text-left whitespace-no-wrap">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                              <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                              <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">登録日</th>
                              <th class="px-4 py-3 text-center title-font border border-solid border-gray-300 border-opacity-50 tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">情報の編集</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($owners as $owner)
                              <tr>
                                <td class="px-4 py-3 border border-solid border-gray-300">{{$owner->name}}</td>
                                <td class="px-4 py-3 border border-solid border-gray-300">{{$owner->email}}</td>
                                <td class="px-4 py-3 border border-solid border-gray-300">{{$owner->created_at->diffForHumans()}}</td>
                                <td class="px-4 py-3 border border-solid border-gray-300 text-center">
                                  <button type="onclick" onclick="location.href='{{route('admin.owners.edit',['owner' => $owner->id])}}'" class="text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-400 rounded">編集する</button>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </section>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
