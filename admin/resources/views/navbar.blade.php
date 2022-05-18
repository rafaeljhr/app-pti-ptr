<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<script src="{{asset('./js/navbar.js')}}"></script>
@php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
@endphp

<div class="navigation">
  <ul>
    @if (strpos($url,'/home') !== false)
      <li class="list active">
    @else
      <li class="list">
    @endif
    
      <a href="{{route('home')}}">
        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
        <span class="title">Home</span>
      </a>
    </li>

    @if (strpos($url,'/consumidor') !== false)
      <li class="list active">
    @else
      <li class="list">
    
    @endif
      <a href="{{route('consumidores.index')}}">
        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
        <span class="title">Consumidor</span>
      </a>
    </li>

    @if (strpos($url,'/fornecedor') !== false)
      <li class="list active">
    @else
      <li class="list">
    
    @endif
      <a href="#">
        <span class="icon"><ion-icon name="pricetag-outline"></ion-icon></span>
        <span class="title">Fornecedor</span>
      </a>
    </li>

    @if (strpos($url,'/transportadora') !== false)
      <li class="list active">
    @else
      <li class="list">
    
    @endif
      <a href="#">
        <span class="icon"><ion-icon name="car-outline"></ion-icon></span>
        <span class="title">Transportadora</span>
      </a>
    </li>

    @if (strpos($url,'/administrador') !== false)
      <li class="list active">
    @else
      <li class="list">
    
    @endif
      <a href="#">
        <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
        <span class="title">Administrador</span>
      </a>
    </li>
    
    <li class="list">
      <a href="{{ url('signout') }}">
        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
        <span class="title">Sair</span>
      </a>
    </li>
</ul>
</div>



    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
