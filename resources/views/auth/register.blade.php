@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4 text-center">ユーザー新規登録画面</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="d-flex justify-content-around mt-4">
                <button type="submit" class="btn btn-warning px-4">新規登録</button>
                <a href="{{ route('login') }}" class="btn btn-primary px-4">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection
