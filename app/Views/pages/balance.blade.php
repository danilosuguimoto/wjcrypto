<!-- View stored in Views/pages/deposit.blade.php -->

@extends('general_layout')

@section('head')
  <title>Extrato</title>
  <link rel="stylesheet" href="Misc/CSS/pages/transactions.css">
@endsection

@section('header')
  <div class="header-button shadow">
    <a href="/logout">Logout</a>
  </div>
@endsection

@section('page-title')
  <h2>Extrato</h2>
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
  @if (isset($transactions))
    <div class="transactions-table">
      <table>
        <tr>
          <th>ID</th>
          <th>Número da conta</th>
          <th>Quantidade</th>
          <th>Tipo de transação</th>
          <th>Data</th>
          <th>De</th>
          <th>Para</th>
        </tr>
        @foreach ($transactions as $transaction)
          @switch($transaction->type)
            @case('deposit')
              <tr class="deposit">
                <td>{{$transaction->transaction_id}}</td>
                <td>{{$transaction->acc_number}}</td>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->type}}</td>
                <td>{{$transaction->created_at}}</td>
                <td>{{$transaction->from_acc}}</td>
                <td>{{$transaction->to_acc}}</td>
              </tr>
              @break
            @case('transfer_deposit')
              <tr class="deposit">
                <td>{{$transaction->transaction_id}}</td>
                <td>{{$transaction->acc_number}}</td>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->type}}</td>
                <td>{{$transaction->created_at}}</td>
                <td>{{$transaction->from_acc}}</td>
                <td>{{$transaction->to_acc}}</td>
              </tr>
              @break
            @case('withdraw')
              <tr class="withdraw">
                <td>{{$transaction->transaction_id}}</td>
                <td>{{$transaction->acc_number}}</td>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->type}}</td>
                <td>{{$transaction->created_at}}</td>
                <td>{{$transaction->from_acc}}</td>
                <td>{{$transaction->to_acc}}</td>
              </tr>
              @break
            @case('transfer_withdraw')
              <tr class="withdraw">
                <td>{{$transaction->transaction_id}}</td>
                <td>{{$transaction->acc_number}}</td>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->type}}</td>
                <td>{{$transaction->created_at}}</td>
                <td>{{$transaction->from_acc}}</td>
                <td>{{$transaction->to_acc}}</td>
              </tr>
              @break    
          @endswitch
        @endforeach
      </table>
    </div>
  @endif
@endsection
