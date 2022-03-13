<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    
    <img src="images/logo.png" class="main-logo">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="{{ route('home-url') }}">HOME</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('about-url') }}">ABOUT</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('contact-url') }}">CONTACT</a>
            </li>
        </ul>
    </div>

    <div class="collapse navbar-collapse flex-row-reverse login">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">SIGN IN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register-url') }}">REGISTER</a>
            </li>
        </ul>
    </div>

</nav>