@extends('errors.layouts.base')

@section('title', '404 Not Found')

@section('message', 'お探しのページは見つかりませんでした。')

@section('detail', '申請書が見つからない場合、申請書が削除されています。')

@section('link')
    <a href="{{ route('menu') }}">to TOP</a>
@endsection
{{-- <x-app-layout>
<h1>お探しのページは見つかりませんでした</h1>
</x-app-layout> --}}

{{-- //TODO:500などエラー用のbladeを用意する --}}
{{-- //TODO:本番環境ではAPP_DEBUG=falseにする --}}
