@extends('layouts.app')

<link rel = "stylesheet" href = "{{ asset('css/regist.css') }}">

@section('content')
<form action = "{{ route('regist') }}" method = "POST" enctype = "multipart/form-data">
    @csrf
    @if ($errors->any())
    <div class = "alert alert-danger">
        <ul>
            @foreach ($errors -> all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2>商品新規登録画面</h2>

    <div class = "form-group">
        <table class = "regist-table">
            <tr>
                <th><label for = "title">商品名*</label></th>
                <td><input type = "text" class = "form-control" id = "title" name = "title" value = "{{ old('title') }}"></td>
            </tr>
            <tr>
                <th><label for = "maker">メーカー*</label></th>
                <td>
                <select class="form-control" id="maker" name="maker">
    <option value="">メーカー</option>
    @foreach ($companies as $company)
        <option value="{{ $company->id }}" {{ old('maker') == $company->id ? 'selected' : '' }}>
            {{ $company->company_name }}
        </option>
    @endforeach
</select>

                </td>
            </tr>
            <tr>
                <th><label for = "price">価格*</label></th>
                <td><input type = "text" class = "form-control" id = "price" name = "price" value = "{{ old('price') }}"></td>
            </tr>
            <tr>
                <th><label for = "stock">在庫数*</label></th>
                <td><input type = "text" class = "form-control" id = "stock" name = "stock" value = "{{ old('stock') }}"></td>
            </tr>
            <tr>
                <th><label for = "comment">コメント</label></th>
                <td><textarea class = "form-control" id = "comment" name = "comment">{{ old('comment') }}</textarea></td>
            </tr>
            <tr>
                <th><label for="image">商品画像</label></th>
                <td>
                    <label for = "image" class = "file-label">ファイルを選択</label>
                    <input type = "file" id = "image" name = "image">
                </td>
            </tr>
            <tr>
                <td colspan = "2">
                    <div class = "button-container">
                        <button type = "submit" class = "regist-button">新規登録</button>
                        <a href = "{{ route('list') }}" class = "back-button">戻る</a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>
@endsection