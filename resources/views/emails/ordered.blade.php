<p class="mb-4">{{ $product['ownerName'] }}様の商品が注文されました。</p>
<p>商品情報一覧</p>
<ul>
    <li>商品名：{{ $product['name'] }}</li>
    <li>商品金額：{{ number_format($product['price']) }}円</li>
    <li>商品数：{{ $product['quantity'] }}</li>
    <li>商品金額：{{ number_format($product['price'] * $product['quantity']) }}円</li>
</ul>
<p>購入者情報</p>
<ul>
    <li>購入者名：{{ $user->name }}様</li>
</ul>