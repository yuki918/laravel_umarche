<p class="mb-4">{{ $user->name }}様</p>
<p class="mb-4">この度はご注文いただきありがとうございました。</p>
<p>商品情報一覧</p>
@foreach($products as $product)
    <ul>
        <li>商品名：{{ $product['name'] }}</li>
        <li>商品金額：{{ number_format($product['price']) }}円</li>
        <li>商品数：{{ $product['quantity'] }}</li>
        <li>商品金額：{{ number_format($product['price']) * $product['quantity'] }}円</li>
    </ul>
@endforeach