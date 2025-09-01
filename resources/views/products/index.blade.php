@extends('layouts.app')

@section('content')


<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    


<div class="search mt-5">
    
   <form id="search-form" action="{{ route('products.search') }}" method="GET" class="d-flex gap-3 align-items-end flex-wrap mt-3">

    
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



    <div id="products-area">
         @include('products.partials.table')
        
    </div>

</div>

@endsection

@section('scripts')
<script>

$(function() {
  // 削除処理
  $(document).on('submit', '.delete-form', function(e) {
    e.preventDefault();
    if (!confirm('本当に削除しますか？')) return;

    const productId = $(this).data('id');

    fetch(`/products/${productId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => {
      if (!res.ok) throw new Error('削除失敗');
      $(this).closest('tr').remove();
    })
    .catch(err => {
      alert('削除に失敗しました');
      console.error(err);
    });
  });

  // 検索処理
  $(document).on('submit', '#search-form', function(e) {
    e.preventDefault();

    $.ajax({
      url: $(this).attr('action'),
      method: 'GET',
      data: $(this).serialize(),
      success: function(data) {
        console.log(data);
        $('#products-area').html(data.html); 
      },
      error: function (xhr, status, err) {
        console.log('通信エラーです');
        console.log(err);
      }
    });
  });

});

</script>
@endsection





