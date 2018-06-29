@extends('partials.layout')
@section('title', 'Reset Password')

@section('content')
    <form action="{{ route('password.reset') }}" method="POST">
        {{ csrf() }}
        <input type="hidden" name="_password_reset_token" value="{{ $_password_reset_token }}">
        <div class="form-row">
            <input class="form-input" type="password" placeholder="New Password" name="user[password]">
        </div>
        <div class="form-row">
            <button class="button button--primary" type="Submit">{{$Lang->getTranslation('Send')}}</button>
        </div>
    </form>
@stop