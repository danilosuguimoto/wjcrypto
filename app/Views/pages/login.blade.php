<!-- View stored in Views/pages/login.blade.php -->

@extends('general_layout')

@section('head')
  <title>Home Page</title>
  <link rel="stylesheet" href="Misc/CSS/pages/login.css">
@endsection

@section('header')
  <p id="create-account">
    <a href="#">Criar Conta</a>
  </p>
@endsection

@section('content')
  <div class="forms login-form">
    <form action="login" method="post">
      <label class="login-labels shadow" for="acc_number">Número da conta: </label>
      <input class="login-inputs shadow" type="text" name="acc_number" id="acc_number">
      <label class="login-labels shadow" for="password">Senha: </label>
      <input class="login-inputs shadow" type="password" name="password" id="password">
      <input id="login" class="shadow" type="submit" value="Entrar">
    </form>
  </div>
@endsection
