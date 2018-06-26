@extends('partials.layout')
@section('title', 'Forgot Password')

@section('content')
    <form action="{{ route('password.forgot') }}" method="POST">
        {{ csrf() }}
        <input type="email" placeholder="E-Mail" name="user[email]">
        <button type="Submit">Submit</button>
    </form>
@stop