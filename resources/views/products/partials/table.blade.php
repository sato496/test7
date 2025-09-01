<div id="products-area">
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
    @forelse ($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td><img src="{{ url($product->img_path) }}" alt="商品画像" width="100"></td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company->company_name ?? '' }}</td>
        <td>
          <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
          <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline delete-form" data-id="{{ $product->id }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center text-muted">該当する商品は見つかりませんでした。</td>
      </tr>
    @endforelse
  </tbody>
</table>

<div class="pagination">
  {{ $products->appends(request()->query())->links() }}
  </div>
</div>
