@extends('master')
@section('title','Login')
@section('page-title','Login')
@section('content')
    <h1 class="page-title">Login</h1>

    @if(session('status'))
        <div class="alert-danger">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-container" action="{{ route('login.process') }}" method="POST" style="max-width:600px;margin:0 auto;">
        @csrf
        <table class="form-table">
            <tr>
                <td><label for="email">Email</label></td>
                <td><input id="email" type="text" name="email" class="form-input" required autofocus value="{{ old('email') }}"></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input id="password" type="password" name="password" class="form-input" required></td>
            </tr>
            <tr>
                <td></td>
                <td class="form-table-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="/" class="btn btn-secondary">Kembali</a>
                </td>
            </tr>
        </table>
    </form>
@endsection
