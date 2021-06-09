<!-- View stored in Views/pages/login.blade.php -->

@extends('general_layout')

@section('head')
  <title>Home Page</title>
  <link rel="stylesheet" href="Misc/CSS/pages/home.css">
@endsection

@section('header')
  <div class="header-button shadow">
    <a href="/logout">Logout</a>
  </div>
@endsection

@section('page-title')
  <h2>Home</h2>
  <div class="header-balance">
    <h3>Saldo Atual: 
      @if ($balance < 1000)
        <span id="balance-bad">R$ {{$balance}}</span>
      @else
        <span id="balance-good">R$ {{$balance}}</span>
      @endif
    </h3>
  </div>
@endsection

@section('content')
  <div class="menu">
    <section>
      <h1 class="greetings">Bem vindo(a) à <span id="welcome-color1">WJ</span><span id="welcome-color2">Crypto</span>!</h1>
      <hr class="menu-hr">
      <h2>O que você deseja fazer?</h2>
    </section>

    <div id="options">
      <div id="m1" class="menu-link shadow">
        <a href="/deposit">Depositar</a>
      </div>
      <div id="m2" class="menu-link shadow">
        <a href="/withdraw">Sacar</a>
      </div>
      <div id="m3" class="menu-link shadow">
        <a href="/transfer">Transferir</a>
      </div>
      <div id="m4" class="menu-link shadow">
        <a href="/balance">Ver Extrato</a>
      </div>
    </div>
  </div>
@endsection
