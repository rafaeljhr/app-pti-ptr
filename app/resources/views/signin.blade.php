<link rel="stylesheet" href="css/login.css">
@extends('layouts.page_default')

@section('background')
    
    @parent
    @if (Session::has('failed_login'))
    <div class="alert alert-danger">
        <ul>
            <li>Deu um erro</li>
        </ul>
    </div>
    @endif
    @include('includes.loginForm') 
    
@endsection