@extends('partials.layout')
@section('title', 'Forgot Password')

@section('content')
    <form action="{{ route('password.forgot') }}" method="POST">
        {{ csrf() }}
        <div class="form-row">
            <input class="form-input" type="email" placeholder="E-Mail" name="user[email]">
        </div>
        <div class="form-row">
            <button class="button button--primary" type="Submit">{{$Lang->getTranslation('Send')}}</button>
        </div>
    </form>
@stop