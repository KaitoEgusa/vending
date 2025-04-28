@extends('layouts.app')

<link rel = "stylesheet" href = "{{ asset('css/list.css') }}">

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<h1>商品一覧画面</h1>

<div class = "search-container">
    <form action = "{{ route('search') }}" method="GET">
        @csrf
        <input type = "text" name = "keyword" value = "{{ old('keyword', $keyword) }}" placeholder = "検索キーワード">
        <select name="maker">
    <option value="">メーカー</option>
    @foreach ($companies as $company)
        <option value = "{{ $company -> company_name }}" {{ old('maker', $maker) == $company -> company ? 'selected' : '' }}>
            {{ $company -> company_name }}
        </option>
    @endforeach
</select>
        <input type = "submit" value = "検索">
    </form>
</div>

@if ($products -> isEmpty()) <p>該当する商品がありません。</p>
@else <table class = "product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>画像</th>
            <th>商品名</th>
            <th>メーカー</th>
            <th>価格</th>
            <th>在庫数</th>
            <th colspan = "2" style = "text-align: right;"><a href = "{{ route('regist.show') }}" class = "new-register-button">新規登録</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product -> id }}</td>
            <td>
                @if($product -> image)
                    <img src = "{{ asset($product -> image) }}" alt = "商品画像" width = "50">
                @else 画像なし
                @endif
            </td>
            <td>{{ $product -> title }}</td>
            <td>{{ $product -> maker }}</td>
            <td>{{ $product -> price }}</td>
            <td>{{ $product -> stock }}</td>
            <td>
                <a href = "{{ route('detail.show', $product->id) }}" class = "detail-button">詳細</a>
            </td>
            <td>
                <form action = "{{ route('delete', $product->id) }}" method = "POST" onsubmit = "return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type = "submit" class = "delete-button">削除</button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- ページネーション --}}
<div class = "d-flex justify-content-center">
    {{ $products -> links('pagination::bootstrap-4') }}
</div>


@endsection