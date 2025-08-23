{{-- resources/views/home.blade.php --}}
@extends('user.layouts.app')
@section('title', 'Beranda - Laboratorium Fisika Dasar')
@section('content')
    @include('user.components.hero')
    @include('user.components.about')
    <!-- Yellow Divider -->
        @include('user.components.articles')
    @include('user.components.galeriLaboratorium')
@endsection
