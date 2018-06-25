@extends('partials.layout')
@section('title', 'Indexsite')

@section('content')
    @if($Auth->check())
    Logged in
    @endif
    <p>Indexsite</p>
    <p>Share1: {{ $share1 }}</p>
    <p>Share2: {{ $share2 }}</p>
    <p>ID: {{ $id }} </p>
    <p>TestVar: {{ $testVar }}</p>
@stop