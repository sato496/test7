@extends('layouts.app')
<style>
  .card, .card-body {
    border: none !important;
    box-shadow: none !important;
  }
</style>

@section('content')
<div class="container">
  <div class="card mt-4" style="width: 720px; margin-left: 50px;">
    <div class="card-body">
    <h1 class="fw-bold mb-4">商品情報詳細</h1>


    <dl class="row mt-3" >
        <dt class="col-sm-3 fs-5">商品情報ID</dt>
        <dd class="col-sm-9 fs-5">{{ $product->id }}</dd>

        <dt class="col-sm-3 fs-5">商品画像</dt>
        <dd class="col-sm-9 fs-5"><img src="{{ asset($product->img_path) }}" width="100"></dd>

        <dt class="col-sm-3 fs-5">メーカー</dt>
        <dd class="col-sm-9 fs-5">{{ $product->company->company_name ?? '未登録' }}</dd>

        <dt class="col-sm-3 fs-5">価格</dt>
        <dd class="col-sm-9 fs-5">{{ $product->price }}</dd>

        <dt class="col-sm-3 fs-5">在庫数</dt>
        <dd class="col-sm-9 fs-5">{{ $product->stock }}</dd>

        <dt class="col-sm-3 fs-5">コメント</dt>
        <dd class="col-sm-9 fs-5">{{ $product->comment }}</dd>

    </dl>
    
    <div class="d-flex justify-content-start mt-4">
  　　<a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-lg me-2">編集</a>
  　　<a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">戻る</a>
    
  
　　</div>



</div>
@endsection

