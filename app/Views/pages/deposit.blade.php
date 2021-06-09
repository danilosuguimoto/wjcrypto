<!-- View stored in Views/pages/deposit.blade.php -->

@extends('general_layout')

@section('head')
  <title>Depósito</title>
  <link rel="stylesheet" href="Misc/CSS/pages/transactions.css">
@endsection

@section('header')
  <div class="header-button shadow">
    <a href="/logout">Logout</a>
  </div>
@endsection

@section('page-title')
  <h2>Depósito</h2>
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

@if (isset($message))
  @section('alert')
    <div class="alert shadow">
      {{ $message }}
    </div>
  @endsection
@endif

@section('content')
  <div class="transaction-form">
    <form class="forms" action="depositPost" method="post">
      <label class="labels" for="deposit_amount">Insira um valor (Reais): </label>
      <input class="inputs shadow" type="text" name="deposit_amount" id="deposit_amount" placeholder="R$" required>
      <input id="deposit" class="submit-button transaction-submit shadow" type="submit" value="Depositar">
    </form>
  </div>
@endsection
