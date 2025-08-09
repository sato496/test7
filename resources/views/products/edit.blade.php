@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card mt-4" style="width: 720px; margin-left: 50px; background-color: #fff;">
  <div class="card-body" style="background-color: #fff;">


                    <div class="card-header"><h2>商品情報編集画面</h2></div>

                    <div class="card-body">
                      <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
   <!-- @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif -->

  {{-- ID（表示専用） --}}
  <div class="mb-3">
    <label class="form-label">ID</label>
    <input type="text" class="form-control" value="{{ $product->id }}" readonly>
  </div>

  {{-- 商品名 --}}
  <div class="mb-3">
    <label for="name" class="form-label">商品名</label>
    {{-- 修正後 --}}
<input id="product_name" name="product_name" type="text"
  class="form-control @error('product_name') is-invalid @enderror"
  value="{{ old('product_name', $product->product_name) }}">

@error('product_name')
  <div class="text-danger small mt-1">{{ $message }}</div>
@enderror

  </div>

 <div class="mb-3">
  <label for="company_id" class="form-label">メーカー名</label>
 <select class="form-select" id="company_id" name="company_id">
  @foreach($companies as $company)
    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
  @endforeach
</select>
@error('company_id')
  <div class="text-danger small mt-1">{{ $message }}</div>
@enderror
  </select>
</div>

<div class="mb-3">
</div>

  {{-- 価格 --}}
  <div class="mb-3">
    <label for="price" class="form-label">価格</label>
    <input id="price" name="price" type="number" class="form-control" value="{{ old('price', $product->price) }}">
    @error('price')
  <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
  </div>

  {{-- 在庫数 --}}
  <div class="mb-3">
    <label for="stock" class="form-label">在庫数</label>
    <input id="stock" name="stock" type="number" class="form-control" value="{{ old('stock', $product->stock) }}">
    @error('stock')
  <div class="text-danger small mt-1">{{ $message }}</div>
@enderror
  </div>

  {{-- コメント --}}
  <div class="mb-3">
    <label for="comment" class="form-label">コメント</label>
    <textarea id="comment" name="comment" class="form-control" rows="4">{{ old('comment', $product->comment) }}</textarea>
  </div>

  {{-- 商品画像 --}}
  <div class="mb-3">
  <label for="image" class="form-label">商品画像</label>
  <input type="file" id="img_path" name="img_path" class="d-none" accept="image/*">

  
  {{-- カスタム表示用ラベル --}}
  <label for="img_path" class="btn btn-outline-secondary">ファイルを選択</label>
  <div id="file-name" class="text-muted small mt-2"></div>
  <img id="preview" alt="プレビュー" style="max-width: 200px; display: none;">
</div>


  {{-- ボタン中央揃え --}}
 <div class="text-left mt-4">
  <button type="submit" class="btn btn-warning btn-lg me-3">更新</button>
  <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-lg">戻る</a>

</div>


</form>
{{-- JavaScript（フォームの外） --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('img_path');
  const fileNameDiv = document.getElementById('file-name');
  const previewImg = document.getElementById('preview');

  input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      fileNameDiv.textContent = '選択中: ' + file.name;
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      fileNameDiv.textContent = '';
      previewImg.style.display = 'none';
    }
  });
});
</script>


@endsection

