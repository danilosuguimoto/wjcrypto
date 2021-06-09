<!-- View stored in Views/pages/create_acc.blade.php -->

@extends('general_layout')

@section('head')
  <title>Criar Conta</title>
  <link rel="stylesheet" href="Misc/CSS/pages/createacc.css">
  <script src="Misc/JS/formHandler.js"></script>
@endsection

@section('page-title')
  <h2>Criar Conta</h2>
@endsection

@if (isset($message))
  @section('alert')
  <div class="alert shadow">
    <div>
      {{ $message }}
      @if ($message == 'Usuário criado com sucesso!')
        <p>
          Número da conta: 
        </p>
        <span id="created_acc_number">
          {{ $acc_number }}
        </span>
        <div>OBS: Guarde este número para realizar o <a href="/" id="login-link">login</a> em sua conta!</div>
      @endif
    </div>
  </div>
  @endsection
@endif

@section('content')
  <div class="createacc-form box-gradient-bg">
    <form class="forms" action="createPost" method="post">
      <div id="createacc-inputs-container">
        <div id="personal-info">
          <section>
            <h3 class="form-title">1. Adicione informações pessoais</h3>  
          </section>
    
          <hr class="form-hr">
    
          <label class="labels shadow" for="name">Nome / Razão Social: </label>
          <input class="inputs shadow" type="text" name="name" id="name" required>
    
          <label class="labels shadow" for="phone">Número de telefone: </label>
          <input class="inputs shadow" type="text" name="phone" id="phone" required>
    
          <label class="labels shadow" for="document_number">CPF / CNPJ: </label>
          <input class="inputs shadow" type="text" name="document_number" id="document_number" required>
    
          <label class="labels shadow" for="dob">Data de nascimento: </label>
          <input class="inputs shadow" type="date" name="dob" id="dob" required>
        </div>
        <div id="create-address">
          <section>
            <h3 class="form-title">2. Adicione seu endereço</h3>  
          </section>
    
          <hr class="form-hr">
  
          <label class="labels shadow" for="country">País: </label>
          <select class="inputs shadow" name="country" id="country" required>
            <option value="Brasil">Brasil</option>
            <option value="Outro">Outro</option>
          </select>

          <label class="labels shadow" for="region">Estado: </label>
          <select class="inputs shadow" name="region" id="region" required>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
          </select>

          <label class="labels shadow" for="postcode">CEP: </label>
          <input class="inputs shadow" type="text" name="postcode" id="postcode" required>

          <label class="labels shadow" for="city">Cidade: </label>
          <input class="inputs shadow" type="text" name="city" id="city" required>

          <label class="labels shadow" for="street">Rua: </label>
          <input class="inputs shadow" type="text" name="street" id="street" required>
        </div>
        <div id="create-password">
          <section>
            <h3 class="form-title">3. Crie uma senha forte</h3>  
          </section>
    
          <hr class="form-hr">
  
          <label class="labels shadow" for="password">Senha: </label>
          <input class="inputs shadow" type="password" name="password" id="password" required>
  
          <label class="labels shadow" for="confirm-password">Confirme sua senha: </label>
          <input class="inputs shadow" type="password" name="confirm-password" id="confirm-password" required>
        </div>
      </div>
      <input id="createacc" class="submit-button shadow" type="submit" value="Criar conta" onsubmit="handlePassword()">
      <div id="already-has-an-account" class="shadow">
        <hr class="form-hr">
        Já tem uma conta? <a href="/">Faça o login por aqui</a>
      </div>
    </form>
  </div>
@endsection
