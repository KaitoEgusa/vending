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
    <form id="search-form" action = "{{ route('list') }}" method="GET">
        @csrf
        <input type = "text" name = "keyword" value = "{{ old('keyword', $keyword) }}" placeholder = "検索キーワード">
        <select name="maker">
    <option value="">メーカー</option>
    @foreach ($companies as $company)
        <option value = "{{ $company -> company_name }}" {{ old('maker', $maker) == $company -> company_name ? 'selected' : '' }}>
            {{ $company -> company_name }}
        </option>
    @endforeach
</select>
<br>
        <input type="number" name="price_min" placeholder="価格下限">
        <input type="number" name="price_max" placeholder="価格上限">
        <input type="number" name="stock_min" placeholder="在庫下限">
        <input type="number" name="stock_max" placeholder="在庫上限">
        <input type = "submit" value = "検索">
<br>
@php
$queryParams = request()->all();
@endphp
    </form>
<div id="product-table-container">
    @if ($products->isEmpty())
        <p>該当する商品がありません。</p>
    @else
        @include('partials.product_table')
    @endif
</div>

{{-- ページネーション --}}
<div class = "d-flex justify-content-center">
    {{ $products -> links('pagination::bootstrap-4') }}
</div>

<script>
//検索する
$(document).ready(function () {
    $('form#search-form').on('submit', function (e) {
        e.preventDefault(); // ページ遷移をストップする

        $.ajax({
            url: '{{ route("list") }}',
            type: 'GET',
            data: $(this).serialize(),
            success: function (data) {
                $('#product-table-container').html(data); // テーブルだけ置き換える
            },
            error: function () {
                alert('検索に失敗しました');
            }
        });
    });
});
//削除する
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $(document).ready(function () {
        $(document).on('click', '.delete-button', function () {
            if (!confirm('本当に削除しますか？')) return;

            const id = $(this).data('id');

            $.ajax({
                url: `/delete/${id}`,
                type: 'DELETE',
                success: function () {
                    $(`button[data-id="${id}"]`).closest('tr').remove();
                    alert('削除されました');
                },
                error: function () {
                    alert('削除に失敗しました');
                }
            });
        });
    });
</script>
@endsection