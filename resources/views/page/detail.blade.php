@extends('layouts.app')

<link rel = "stylesheet" href="{{ asset('css/detail.css') }}">

@section('content')

<h2>商品新規登録画面</h2>

<table class = "detail-table">
            <tr>
                <th><label for = "id">ID</label></th>
                <td>{{ $product -> id }}</td>
            </tr>
            <tr>
                <th><label for = "image">商品画像</label></th>
                <td>@if($product -> image) <img src = "{{ asset($product -> image) }}" alt = "商品画像" width = "50"> @else 画像なし @endif</td>
            </tr>
            <tr>
                <th><label for = "title">商品名</label></th>
                <td>{{ $product -> title }}</td>
            </tr>
            <tr>
                <th><label for = "stock">メーカー</label></th>
                <td>{{ $product -> maker }}</td>
            </tr>
            <tr>
                <th><label for = "title">価格</label></th>
                <td>{{ $product -> price }}</td>
            </tr>
            <tr>
                <th><label for = "title">在庫</label></th>
                <td>{{ $product -> stock }}</td>
            </tr>
            <tr>
                <th><label for = "comment">コメント</label></th>
                <td>{{ $product -> comment }}</td>
            </tr>
            <tr>
            <td colspan="2">
        <div class="button-container">
            <a href="{{ route('edit.show', $product->id) }}" class="detail-button">編集</a>
            <a href="{{ route('list') }}" class="back-button">戻る</a>
        </div>
            </td>
            </tr>
</table>
@endsection