@php
    $queryParams = request()->all();
    $sort = $sort ?? 'id';
    $order = $order ?? 'desc';
@endphp
<table class = "product-table">
<thead>
    <tr>
        <th>
            <a href="{{ route('list', array_merge($queryParams, ['sort' => 'id', 'order' => ($sort === 'id' && $order === 'asc') ? 'desc' : 'asc'])) }}">ID</a>
        </th>
        <th>画像</th>
        <th>
            <a href="{{ route('list', array_merge($queryParams, ['sort' => 'product_name', 'order' => ($sort === 'product_name' && $order === 'asc') ? 'desc' : 'asc'])) }}">商品名</a>
        </th>
        <th>
            <a href="{{ route('list', array_merge($queryParams, ['sort' => 'company_id', 'order' => ($sort === 'company_id' && $order === 'asc') ? 'desc' : 'asc'])) }}">メーカー</a>
        </th>
        <th>
            <a href="{{ route('list', array_merge($queryParams, ['sort' => 'price', 'order' => ($sort === 'price' && $order === 'asc') ? 'desc' : 'asc'])) }}">価格</a>
        </th>
        <th>
            <a href="{{ route('list', array_merge($queryParams, ['sort' => 'stock', 'order' => ($sort === 'stock' && $order === 'asc') ? 'desc' : 'asc'])) }}">在庫数</a>
        </th>
        <th colspan="2" style="text-align: right;">
            <a href="{{ route('regist.show') }}" class="new-register-button">新規登録</a>
        </th>
    </tr>
</thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="商品画像" width="50">
                @else
                    画像なし
                @endif
            </td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->maker }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('detail.show', $product->id) }}" class="detail-button">詳細</a>
            </td>
            <td>
                <button class="delete-button" data-id="{{ $product->id }}">削除</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>