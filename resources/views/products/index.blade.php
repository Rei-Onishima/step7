@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>商品一覧画面</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">新規登録</a>
    </div>
    
    <!-- 検索フォームのセクション -->
    <div class="search mt-5">
        <form id="searchForm" action="{{ route('products.index') }}" method="GET" class="row g-3">
            <!-- 商品名検索用の入力欄 -->
            <div class="col-sm-12 col-md-3">
                <input type="text" id="searchQuery" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
            </div>

            <!-- メーカー名検索用のセレクトボックス -->
            <div class="col-sm-12 col-md-3">
                <select id="companySelect" class="form-select" name="company_id">
                    <option value="" disabled selected>メーカー名</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 絞り込みボタン -->
            <div class="col-sm-12 col-md-1">
                <button class="btn btn-outline-secondary" type="submit">検索</button>
            </div>
        </form>
    </div>

    <!-- 検索結果表示のセクション -->
    <div class="products mt-5">
        <table class="table table-striped" id="resultsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    <th>その他</th>
                </tr>
            </thead>
            <tbody id="resultsBody">
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm mx-1">詳細表示</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- JavaScriptファイルの読み込み -->
<script src="{{ asset('js/confirmDelete.js') }}" defer></script>
<script src="{{ asset('js/searchProducts.js') }}" defer></script>
@endsection
