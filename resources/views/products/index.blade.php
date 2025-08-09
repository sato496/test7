@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    


<div class="search mt-5">
    
   <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-3 align-items-end flex-wrap mt-3">

    <div>
    <input type="text" name="search" id="search" class="form-control" placeholder="検索ワード" value="{{ request('search') }}">
    </div>

    <div>
      <select name="company_id" id="company_id" class="form-select">
      <option value="">メーカーを選択</option>
        @foreach($companies as $company)
      <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
        {{ $company->company_name }}
      </option>
         @endforeach
      </select>
    </div>


    <div>
        <button type="submit" class="btn btn-primary">検索</button>
    </div>

</form>


        </div>
    </form>
</div>



    <div class="products container mt-5">

        
        <table class="table table-striped">
    <thead>
     <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th>
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">新規登録</a>
        </th>
     </tr>
    </thead>


<tbody>
@foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company->company_name ?? '' }}</td>

        <td>
           <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
           <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
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

{{ $products->appends(request()->query())->links() }}
    
</div>
@endsection

