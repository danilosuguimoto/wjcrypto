<!-- View stored in Views/pages/login.blade.php -->

@extends('general_layout')

@section('head')
  <title>Home Page</title>
  <link rel="stylesheet" href="Misc/CSS/pages/home.css">
@endsection

@section('header')
  <div class="welcome-message shadow">
    <span id='test1'>Bem vindo(a), {{ $username }}!</span>
  </div>
@endsection

@section('content')
  
@endsection
