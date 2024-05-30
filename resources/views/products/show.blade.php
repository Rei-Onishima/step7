@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>商品情報詳細画面</h2></div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="product_id" class="col-sm-4">商品情報ID</label>
                            <p class="col-sm-8">{{ $product->id }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="product_name" class="col-sm-4">商品名</label>
                            <p class="col-sm-8">{{ $product->product_name }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="company_id" class="col-sm-4">メーカー</label>
                            <p class="col-sm-8">{{ $product->company->company_name }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-sm-4">金額</label>
                            <p class="col-sm-8">{{ $product->price }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="stock" class="col-sm-4">在庫数</label>
                            <p class="col-sm-8">{{ $product->stock }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="comment" class="col-sm-4">コメント</label>
                            <p class="col-sm-8">{{ $product->comment }}</p>
                        </div>

                        <div class="row mb-3">
                            <label for="img_path" class="col-sm-4">商品画像</label>
                            <p class="col-sm-8"><img src="{{ asset($product->img_path) }}" alt="商品画像" class="img-fluid"></p>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">編集</a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
