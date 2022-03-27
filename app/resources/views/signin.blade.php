<link rel="stylesheet" href="css/login.css">
@extends('layouts.page_default')

@section('background')
    
    @parent
    @if (Session::has('failed_login'))
    <div class="alert alert-danger" role="alert">
        A sua palavra-passe ou email estão icorretos ou a sua conta nao existe
      </div>
    <?php
    session()->forget('failed_login');
    ?>
    @endif
    @include('includes.loginForm') 
    
@endsection