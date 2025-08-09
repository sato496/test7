@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-6"> {{-- 横幅を小さめに --}}
        <h2 class="mb-4 text-center">ユーザーログイン画面</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">アドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="d-flex justify-content-around col-md-8 mx-auto mt-4">
              <a href="{{ route('register') }}" class="btn btn-warning px-4">新規登録</a>
              <button type="submit" class="btn btn-primary px-4">ログイン</button>
            </div>


        </form>
    </div>
</div>
@endsection
