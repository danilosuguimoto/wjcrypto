<!-- View stored in Views/pages/login.blade.php -->

@extends('general_layout')

@section('head')
  <title>Login</title>
  <link rel="stylesheet" href="Misc/CSS/pages/login.css">
@endsection

@section('header')
  <p class="header-button shadow">
    <a href="/createAccount">Criar Conta</a>
  </p>
@endsection

@section('page-title')
  <h2>Login</h2>
@endsection

@if (isset($message))
  @section('alert')
  <div class="alert shadow">
    <div>{{ $message }}</div>
  </div>
  @endsection
@endif

@section('content')
  <div class="login-form box-gradient-bg">
    <form class="forms" action="loginPost" method="post">
      <section>
        <h3 class="form-title">Informações de usuário</h3>  
      </section>

      <hr class="form-hr">

      <label class="labels shadow" for="acc_number">Número da conta: </label>
      <input class="inputs shadow" type="text" name="acc_number" id="acc_number" required>

      <label class="labels shadow" for="password">Senha: </label>
      <input class="inputs shadow" type="password" name="password" id="password" required>

      <input id="login" class="submit-button shadow" type="submit" value="Entrar">
      <div id="doesnt-have-an-account" class="shadow">
        <hr class="form-hr">
        Não tem uma conta? <a href="/createAccount">Crie uma aqui</a>
      </div>
    </form>
  </div>
@endsection
