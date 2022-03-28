<div class="">
    @if( !empty( $filename ) )
        <img src="{{ asset( 'storage/shops/' . $filename ) }}" alt="">
    @else
        <img src="{{ asset('img/no_image.jpg') }}" alt="">
    @endif
</div>