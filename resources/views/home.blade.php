@extends('layouts.app')

@section('title', 'Beranda - Laboratorium Fisika Dasar')

@section('content')
    @include('components.hero')
    @include('components.about')
    @include('components.article')
    @include('components.laboratorium')
@endsection
