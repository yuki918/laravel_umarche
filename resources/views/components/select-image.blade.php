@php
    if($name === 'image01') $modal = 'modal-1';
    if($name === 'image02') $modal = 'modal-2';
    if($name === 'image03') $modal = 'modal-3';
    if($name === 'image04') $modal = 'modal-4';
@endphp

<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
      <header class="modal__header">
        <h2 class="modal__title text-center " id="{{ $modal }}-title">
            ファイル選択してください
        </h2>
        <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="{{ $modal }}-content">
        <div class="flex flex-wrap justify-between">
            @foreach( $images as $image )
                <div class="border rounded-md my-2 p-2 md:p-4 w-48/100 md:w-24/100">
                    <img class="image" data-id="{{ $name }}_{{ $image->id }}"
                        data-file="{{ $image->filename }}"
                        data-path="{{ asset('storage/products/') }}"
                        data-modal="{{ $modal }}"
                        src="{{ asset('storage/products/' . $image->filename)}}" >
                    @if($image->title)
                        <p class="text-center text-sm mt-2 text-gray-600">{{ $image->title }}</p>
                    @else
                        <p class="text-center text-sm mt-2 text-gray-600">タイトルがありません</p>
                    @endif
                </div>
            @endforeach
        </div>
      </main>
      <footer class="modal__footer">
        <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
      </footer>
    </div>
  </div>
</div>


<div class="flex justify-around items-center m-4">
    <a data-micromodal-trigger="{{ $modal }}" href='javascript:;'>ファイルを選択する</a>
    <div class="w-1/2">
      <img id="{{ $name }}_thumbnail" src="">
    </div>
</div>
<input id="{{ $name}}_hidden" type="hidden"name="{{ $name }}" value="">