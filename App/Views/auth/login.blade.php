@extends('partials.layout')
@section('title', 'Login')

@section('content')
{{ $Lang->getTranslation('is required') }}
    <form action="{{ route('login') }}" method="POST">
        {{ csrf() }}
        <input type="email" placeholder="E-Mail" name="user[email]">
        <input type="password" placeholder="Password" name="user[password]">
        <button type="Submit">Submit</button>
    </form>
    <a href="{{ route('password.forgot') }}">Forgot your password?</a>
@stop