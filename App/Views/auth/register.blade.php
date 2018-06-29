@extends('partials.layout')
@section('title', 'Register')

@section('content')
    <form action="{{ route('register') }}" method="POST">
        {{ csrf() }}
        <div class="form-row">
            <input class="form-control" type="email" placeholder="E-Mail" name="user[email]">
        </div>
        <div class="form-row">
            <input class="form-control" type="password" placeholder="Password" name="user[password]">
        </div>
        <div class="form-row">
            <button class="button button--primary" type="Submit">{{$Lang->getTranslation('Send')}}</button>
        </div>
    </form>
@stop