@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1 class="fw-bold mb-4">商品新規登録</h1>


  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf


    <div class="row">
      {{-- 左側：入力欄 --}}
      <div class="col-md-6">

        <div class="mb-3">
          <label for="product_name" class="form-label fw-bold">商品名</label>
          <input id="product_name" type="text" name="product_name"
             class="form-control @error('product_name') is-invalid @enderror"
             value="{{ old('product_name') }}">

            @error('product_name')
        <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="company_id" class="form-label fw-bold">メーカー</label>
          <select class="form-select" id="company_id" name="company_id">
          <option value="">メーカーを選択</option>
              @foreach($companies as $company)
          <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
             {{ $company->company_name }}
          </option>
             @endforeach
          </select>
             @error('company_id')
           <div class="text-danger small mt-1">{{ $message }}</div>
             @enderror
        </div>

        <div class="mb-3">
          <label for="price" class="form-label fw-bold">価格</label>
          <input id="price" type="text" name="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price') }}">

            @error('price')
        <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="stock" class="form-label fw-bold">在庫数</label>
          <input id="stock" type="text" name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock') }}">

              @error('stock')
       <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
          
        </div>

      <div class="mb-3">
  <label for="comment" class="form-label fw-bold">コメント</label>
  <textarea id="comment" name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
</div>

</div>
<div class="mb-3 d-flex align-items-start flex-column">
  <label for="img_path" class="form-label fw-bold mb-2">商品画像</label>

  {{-- ファイル選択ボタン --}}
  <label for="img_path" class="btn btn-outline-secondary mb-2">ファイルを選択</label>
  <input type="file" id="img_path" name="img_path" class="d-none">

  @error('img_path')
  <div class="text-danger small mt-1">{{ $message }}</div>
  @enderror

  {{-- ファイル名表示 --}}
  <div id="file-name" class="text-muted small"></div>

  {{-- プレビュー表示 --}}
  <img id="preview" src="#" alt="プレビュー" class="mt-2" style="max-width: 200px; display: none;">
</div>


        {{-- プレビュー表示など追加する余地がここにあります！ --}}
      </div>

<div class="mt-4 ms-3 d-flex">
  <button type="submit" class="btn btn-warning me-2">新規登録</button>
  <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
</div>


  </form>
  <script>
  document.getElementById('img_path').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileNameDiv = document.getElementById('file-name');
    const previewImg = document.getElementById('preview');

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
</script>

</div>
@endsection
