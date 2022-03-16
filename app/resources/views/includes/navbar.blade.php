<nav class="navbar navbar-expand-lg navbar-light cor-nav">
    
    <img src="images/logo5.png" class="main-logo">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/ ') }}">HOME</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/about') }}">ABOUT</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/contact') }}">CONTACT</a>
            </li>
        </ul>
    </div>

    <div class="collapse navbar-collapse flex-row-reverse login">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">SIGN IN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">REGISTER</a>
            </li>
        </ul>
    </div>

</nav>