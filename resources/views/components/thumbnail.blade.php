<?php
  if( $type === "shops" ) {
    $path = "storage/shops/";
  } elseif( $type === "products" ) {
    $path = "storage/products/";
  }
?>

<div class="">
    @if( !empty( $filename ) )
        <img src="{{ asset( $path . $filename ) }}" alt="">
    @else
        <img src="{{ asset( 'img/no_image.jpg' ) }}" alt="">
    @endif
</div>