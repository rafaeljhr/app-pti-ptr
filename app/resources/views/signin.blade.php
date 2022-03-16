<link rel="stylesheet" href="css/login.css">
@extends('layouts.page_default')

@section('background')
    
    @parent
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @include('includes.loginForm') 
    
@endsection