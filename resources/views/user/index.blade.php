<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
    </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="">
                      <form method="get" action="{{ route('user.items.index') }}">
                        <div class="flex flex-wrap justify-between md:justify-end items-end mb-8">
                            <div class="w-48/100 md:w-auto mb-4 md:mb-0 text-center md:mr-4">
                              <p>カテゴリーを選ぶ</p>
                              <select class="fomrAction w-full md:w-auto" name="category" id="category">
                                  <option value="0" @if(\Request::get('category') === '0') selected @endif>全て</option>
                                  @foreach($categories as $category)
                                      <optgroup label="{{ $category->name }}">
                                          @foreach($category->secondary as $secondary)
                                              <option value="{{ $secondary->id }}" @if(\Request::get('category') == $secondary->id) selected @endif>
                                                  {{ $secondary->name }}
                                              </option>
                                          @endforeach
                                      </optgroup>
                                  @endforeach
                              </select>
                            </div>
                            <div class="w-48/100 md:w-auto mb-4 md:mb-0 text-center md:mr-4">
                                <p>キーワードで検索する</p>
                                <div class="flex">
                                    <input name="keyword" class="w-3/4 md:w-auto border border-gray-500 py-2 px-4" placeholder="キーワード">
                                    <button class="w-1/4 md:w-auto text-white bg-indigo-500 border-0 py-1 px-2 focus:outline-none hover:bg-indigo-600">検索</button>
                                </div>
                            </div>
                            <div class="w-48/100 md:w-auto text-center md:mr-4">
                                <p>表示件数</p>
                                <select class="fomrAction w-full md:w-auto" name="pagination" id="pagination">
                                    <option value="20" @if(\Request::get('pagination') === '20') selected @endif>
                                        20件
                                    </option>
                                    <option value="50" @if(\Request::get('pagination') === '50') selected @endif>
                                        50件
                                    </option>
                                    <option value="100" @if(\Request::get('pagination') === '100') selected @endif>
                                        100件
                                    </option>
                                    <option value="200" @if(\Request::get('pagination') === '200') selected @endif>
                                        200件
                                    </option>
                                </select>
                            </div>
                            <div class="w-48/100 md:w-auto text-center">
                              <p>表示順</p>
                              <select class="fomrAction w-full md:w-auto" name="sort" id="sort">
                                  <option value="{{ \Constants::SORT_ORDER['recommend'] }}"
                                    @if(\Request::get('sort') === \Constants::SORT_ORDER['recommend']) selected @endif>
                                      おすすめ
                                  </option>
                                  <option value="{{ \Constants::SORT_ORDER['order'] }}"
                                    @if(\Request::get('sort') === \Constants::SORT_ORDER['order']) selected @endif>
                                      新しい
                                  </option>
                                  <option value="{{ \Constants::SORT_ORDER['later'] }}"
                                    @if(\Request::get('sort') === \Constants::SORT_ORDER['later']) selected @endif>
                                      古い
                                  </option>
                                  <option value="{{ \Constants::SORT_ORDER['lowerPrice'] }}"
                                    @if(\Request::get('sort') === \Constants::SORT_ORDER['lowerPrice']) selected @endif>
                                      料金が低い
                                  </option>
                                  <option value="{{ \Constants::SORT_ORDER['higherPrice'] }}"
                                    @if(\Request::get('sort') === \Constants::SORT_ORDER['higherPrice']) selected @endif>
                                      料金が高い
                                  </option>
                              </select>
                            </div>
                        </div>
                      </form>
                  </div>
                  <div class="flex flex-wrap justify-between">
                      @foreach( $products as $product )
                          <a class="block w-48/100 md:w-3/9 my-2" href="{{ route( 'user.items.show' , [ 'item' => $product->id ] ) }}">
                              <div class="border rounded-md p-4">
                                  <x-thumbnail filename="{{ $product->filename ?? '' }}" type="products" />
                                  <div class="mt-4">
                                      <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category }}</h3>
                                      <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                      <p class="mt-1">{{ number_format($product->price) }}<span class="text-xs text-gray-600">円(税込み)</span></p>
                                  </div>
                              </div>
                          </a>
                      @endforeach
                  </div>
                  {{
                    // ページネーションで2ページ目以降に遷移したときに、
                    // ソートのデータが失われないようにappendsを使用する
                    $products->appends([
                        'sort' => \Request::get('sort'),
                        'pagination' => \Request::get('pagination'),
                    ])->links() 
                  }}
              </div>
          </div>
      </div>
  </div>
  <script>
      // カテゴリー
      const selectCategory = document.getElementById('category');
      selectCategory.addEventListener('change', function(){
          this.form.submit()
      });
      // 表示順
      const selectSort = document.getElementById('sort');
      selectSort.addEventListener('change', function(){
          this.form.submit()
      });
      // 表示件数
      const selectPagination = document.getElementById('pagination')
      selectPagination.addEventListener('change', function(){
          this.form.submit()
      });
  </script>
</x-app-layout>