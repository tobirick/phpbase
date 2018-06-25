@extends('partials.layout')
@section('title', 'Register')

@section('content')
    <form action="{{ route('register') }}" method="POST">
        {{ csrf() }}
        <input type="email" placeholder="E-Mail" name="user[email]">
        <input type="password" placeholder="Password" name="user[password]">
        <button type="Submit">Submit</button>
    </form>
@stop