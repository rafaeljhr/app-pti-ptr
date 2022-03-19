<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="utf'8">
        <title>Site PTI-PTR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/page_default.css">
        <link rel="stylesheet" href="css/aboutUs.css">
        

        {{-- Bootstrap needed imports --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        {{-- Vue.js needed import --}}
        <script src="https://unpkg.com/vue@3"></script>
    </head>


    <body>
       
        @include('includes.navbar')
        
        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active back_img" id="back_img1"  >
                    
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Loja</h1>
                            <p>Veja os produtos do momento!</p>
                            <p><a class="btn btn-lg" href=#>Ver loja</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item back_img" id="back_img2">
        
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Registe-se na EcoSmart</h1>
                            <p>Apenas utilizadores registados podem encomendar! Seja um deles!</p>
                            <p><a class="btn btn-lg" href=#>Registar-me</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item back_img" id="back_img3">
                    
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>A nossa história</h1>
                            <p>Vem conhecer um pouco mais sobre esta plataforma!</p>
                            <p><a class="btn btn-lg" href=#>História</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>



        <div class="section-content">
            <div class="container">
                <h2>Bem-vindo!</h2>
                <p class="lead">Nestes tempos tempos de maior dificuldade a nível nacional, nunca foi tão importante 
                a empatia e entreajuda humana. A nossa aplicação tem como objetivo facilitar o processo de voluntariado e 
                agilizar a comunicação entre voluntários e instituições.
                </p>
    
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="card-group">
                            <div class="card">
                                <img src="images/backgrounds/2.png" class="card-img-top" alt="Father and daughter volunteering">
                                <div class="card-body">
                                    <h5 class="card-title">Chat</h5>
                                    <p class="card-text">Fala diretamente com os voluntários!</p>
                                    <br>
                                    <a href="candidatos_a_acao.php"><button class="btn btn-inst">Falar com Voluntários</button></a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/backgrounds/2.png" class="card-img-top" alt="Volunteers unloading a truck">
                                <div class="card-body">
                                    <h5 class="card-title">A Minha Instituição</h5>
                                    <p class="card-text">Edita o teu perfil da tua instituição!</p>
                                    <br>
                                    <a href="alterarI.php"><button class="btn btn-inst">Editar Perfil</button></a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/backgrounds/2.png" class="card-img-top" alt="Volunteers looking inside bags">
                                <div class="card-body">
                                    <h5 class="card-title">Ações</h5>
                                    <p class="card-text">Cria todas as ações que a tua instituição tem para oferecer aos nossos voluntários!</p>
                                
                                    <a href=#><button class="btn btn-inst">Criar ações</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @show

        @include('includes.footer')
            
       
    </body>
</html>