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
                    エロクアント
                    @foreach($e_all as $e_owner)
                        {{$e_owner->name}}
                        {{-- {{$e_owner->created_at}} --}}
                        {{-- 出力結果：2022-01-01 11:11:11 --}}

                        {{-- カーボンインスタンスを利用する場合 --}}
                        {{$e_owner->created_at->diffForHumans()}}
                        {{-- 出力結果：1ヶ月前 --}}
                    @endforeach
                    <br>
                    クエリビルダー
                    @foreach($q_get as $e_owner)
                        {{$e_owner->name}}
                        {{-- {{$e_owner->created_at}} --}}
                        {{-- カーボンインスタンスを利用する場合 --}}
                        {{Carbon\Carbon::parse($e_owner->created_at)->diffForHumans()}}
                    @endforeach
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
