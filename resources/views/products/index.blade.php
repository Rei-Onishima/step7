@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>商品一覧画面</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">新規登録</a>
    </div>
    
    <!-- 検索フォームのセクション -->
    <div class="search mt-5">
        <form id="searchForm" action="{{ route('products.index') }}" method="GET" class="container">
            <!-- 1段目 -->
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <input type="text" id="searchQuery" name="search" class="form-control form-control-sm" placeholder="キーワード" value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <select id="companySelect" class="form-select form-select-sm" name="company_id">
                        <option value="">メーカー名</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <!-- 2段目 -->
            <div class="row g-2 align-items-center mt-2">
                <!-- 価格 -->
                <div class="col-auto d-flex align-items-center">
                    <label for="priceMin" class="form-label mb-0 me-1">価格</label>
                    <input type="number" id="priceMin" name="price_min" class="form-control form-control-sm me-1" style="width: 80px;" value="{{ request('price_min') }}">
                    <span class="me-1">〜</span>
                    <input type="number" id="priceMax" name="price_max" class="form-control form-control-sm me-3" style="width: 80px;" value="{{ request('price_max') }}">
                </div>
    
                <!-- 在庫数 -->
                <div class="col-auto d-flex align-items-center">
                    <label for="stockMin" class="form-label mb-0 me-1">在庫数</label>
                    <input type="number" id="stockMin" name="stock_min" class="form-control form-control-sm me-1" style="width: 80px;" value="{{ request('stock_min') }}">
                    <span class="me-1">〜</span>
                    <input type="number" id="stockMax" name="stock_max" class="form-control form-control-sm me-3" style="width: 80px;" value="{{ request('stock_max') }}">
                </div>
    
                <!-- 検索ボタン -->
                <div class="col-auto">
                    <button class="btn btn-outline-secondary btn-sm" type="submit">検索</button>
                </div>
            </div>
        </form>
    </div>
    

    <!-- 検索結果表示のセクション -->
    <div class="products mt-5">
        <table class="table table-striped" id="resultsTable">
            <thead>
                <tr>
                    <!-- ID -->
                    <th>
                        <a href="#" class="sort-link" data-sort="id">ID</a>
                    </th>
            
                    <!-- 商品画像 (ソートなし) -->
                    <th>商品画像</th>
            
                    <!-- 商品名 -->
                    <th>
                        <a href="#" class="sort-link" data-sort="product_name">商品名</a>
                    </th>
            
                    <!-- 価格 -->
                    <th>
                        <a href="#" class="sort-link" data-sort="price">価格</a>
                    </th>
            
                    <!-- 在庫数 -->
                    <th>
                        <a href="#" class="sort-link" data-sort="stock">在庫数</a>
                    </th>
            
                    <!-- メーカー名 -->
                    <th>
                        <a href="#" class="sort-link" data-sort="company_name">メーカー名</a>
                    </th>
            
                    <!-- その他 (ソートなし) -->
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
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline delete-form" data-id="{{ $product->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm mx-1 delete-btn">削除</button>
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
