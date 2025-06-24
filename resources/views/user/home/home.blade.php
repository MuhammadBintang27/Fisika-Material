{{-- resources/views/home.blade.php --}}
@extends('user.layouts.app')
@section('title', 'Beranda - Laboratorium Fisika Dasar')
@section('content')
    @include('user.components.hero')
    @include('user.components.about')
    <!-- Yellow Divider -->
    <div class="w-full h-px bg-gradient-to-r from-transparent via-yellow-200 to-transparent"></div>
    <div class="w-32 h-1 mx-auto bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
    @include('user.components.articles')
    @include('user.components.galeriLaboratorium')
@endsection
