@extends('layouts.app')

@section('content')

@php
  function sortLink($label, $column) {
      $isActive = request('sort_by') === $column;
      $nextOrder = $isActive && request('sort_order') === 'asc' ? 'desc' : 'asc';
      $icon = $isActive ? (request('sort_order') === 'asc' ? '▲' : '▼') : '';
      $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $nextOrder]);
      $url = route('products.index', $query);
      return "<a href=\"{$url}\">{$label} {$icon}</a>";
  }
@endphp

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
  <label for="price_min">価格 下限</label>
  <input type="number" name="price_min" id="price_min" class="form-control" value="{{ request('price_min') }}">
</div>

<div>
  <label for="price_max">価格 上限</label>
  <input type="number" name="price_max" id="price_max" class="form-control" value="{{ request('price_max') }}">
</div>

<div>
  <label for="stock_min">在庫 下限</label>
  <input type="number" name="stock_min" id="stock_min" class="form-control" value="{{ request('stock_min') }}">
</div>

<div>
  <label for="stock_max">在庫 上限</label>
  <input type="number" name="stock_max" id="stock_max" class="form-control" value="{{ request('stock_max') }}">
</div>


    <div>
        <button type="submit" class="btn btn-primary">検索</button>
    </div>


        </div>
    </form>
</div>



    <div class="products container mt-5">

        
        <table class="table table-striped">
   <thead>
  <tr>
    <th>{!! sortLink('ID', 'id') !!}</th>
    <th>商品画像</th>
    <th>{!! sortLink('商品名', 'product_name') !!}</th>
    <th>{!! sortLink('価格', 'price') !!}</th>
    <th>{!! sortLink('在庫数', 'stock') !!}</th>
    <th>{!! sortLink('メーカー名', 'company_name') !!}</th>
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
  <td class="stock-cell">{{ $product->stock }}</td>
  <td>{{ $product->company->company_name ?? '' }}</td>
  <td>
    <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>

    <form method="POST"
          action="{{ route('products.destroy', $product) }}"
          class="d-inline delete-form"
          data-id="{{ $product->id }}">
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
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // 通常送信を止める

      if (!confirm('本当に削除しますか？')) return;

      const productId = this.dataset.id;

      fetch(`/products/${productId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(res => {
        if (!res.ok) throw new Error('削除失敗');
        this.closest('tr').remove();
      })
      .catch(err => {
        alert('削除に失敗しました');
        console.error(err);
      });
    });
  });
});
document.querySelectorAll('.purchase-button').forEach(button => {
  button.addEventListener('click', function () {
    const productId = this.dataset.id;

    fetch('/api/purchase', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        product_id: productId,
        quantity: 1
      })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message || '購入完了');

      // 在庫表示の更新
      const row = this.closest('tr');
      const stockCell = row.querySelector('.stock-cell');
      const currentStock = parseInt(stockCell.textContent);
      stockCell.textContent = currentStock - 1;
    })
    .catch(err => {
      alert('購入に失敗しました');
      console.error(err);
    });
  });
});




</script>


@endsection

