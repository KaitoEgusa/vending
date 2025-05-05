<link rel = "stylesheet" href = "{{ asset('css/list.css') }}">

<table class = "product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>画像</th>
            <th>商品名</th>
            <th>メーカー</th>
            <th>価格</th>
            <th>在庫数</th>
            <th colspan = "2" style = "text-align: right;">
                <a href = "{{ route('regist.show') }}" class = "new-register-button">新規登録</a>
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