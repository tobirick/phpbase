@extends('partials.layout')
@section('title', 'Login')

@section('content')
{{ $Lang->getTranslation('is required') }}
    <form action="{{ route('login') }}" method="POST">
        {{ csrf() }}
        <div class="form-row">
            <input class="form-input" type="email" placeholder="E-Mail" name="user[email]">
        </div>
        <div class="form-row">
            <input class="form-input" type="password" placeholder="Password" name="user[password]">
        </div>
        <div class="form-row">
            <button class="button button--primary" type="Submit">{{$Lang->getTranslation('Send')}}</button>
        </div>
    </form>
    <a href="{{ route('password.forgot') }}">{{$Lang->getTranslation('Forgot your password?')}}</a>
@stop