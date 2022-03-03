<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーナーの情報編集</h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-6 mx-auto">
              <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">オーナーの情報編集</h1>
              </div>
              <div class="lg:w-2/3 md:w-2/3 mx-auto">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- 「admin/owner/{owners}/update」の「{owners}」に対して「$owners->id」を渡す --}}
                <form method="post" action="{{route('admin.owners.update',['owner' => $owners->id])}}">
                  @method('PUT')
                  @csrf
                  <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-full md:w-1/2">
                      <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-600">オーナー名</label>
                        <input type="text" id="name" required name="name" value="{{$owners->name}}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-full md:w-1/2">
                      <div class="relative">
                        <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                        <input type="email" id="email" required name="email" value="{{$owners->email}}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-full md:w-1/2">
                      <div class="relative">
                        <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                        <input type="password" id="password" required name="password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-full md:w-1/2">
                      <div class="relative">
                        <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード（再確認）</label>
                        <input type="password" id="password_confirmation" required name="password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="flex justify-around p-2 w-full mt-6">
                      {{-- 両方とも「type="submit"」の場合エラーが出る --}}
                      <button type="button" onclick="location.href='{{route('admin.owners.index')}}'" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                      <button type="submit" onclick="" class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">更新する</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
