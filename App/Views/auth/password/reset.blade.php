@extends('partials.layout')
@section('title', 'Reset Password')

@section('content')
    <form action="{{ route('password.reset') }}" method="POST">
        {{ csrf() }}
        <input type="hidden" name="_password_reset_token" value="{{ $_password_reset_token }}">
        <input type="password" placeholder="New Password" name="user[password]">
        <button type="Submit">Submit</button>
    </form>
@stop