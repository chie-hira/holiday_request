@extends('errors.layouts.base')

@section('title', '403 Error')

@section('message', 'セッションがきれました')

@section('detail', 'toTOPからトップメニューに戻ってください。')

@section('link')
    <a href="{{ route('menu') }}">to TOP</a>
@endsection
