@extends('errors.layouts.base')

@section('title', '419 Error')

@section('message', 'エラーが発生しました')

@section('detail', 'toTOPからトップメニューに戻ってください。')

@section('link')
    <a href="{{ route('menu') }}">to TOP</a>
@endsection
