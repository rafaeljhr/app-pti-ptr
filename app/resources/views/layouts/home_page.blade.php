<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="utf'8">
        <title>EcoSmart Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="./images/imagem_tab.png">

        <link rel="stylesheet" href="css/page_default.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/home.css">

        {{-- Bootstrap needed imports --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        {{-- Vue.js needed import --}}
        <script src="https://unpkg.com/vue@3"></script>
    </head>


    <body>
       
        @include('includes.navbar')
       
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <svg class="bd-placeholder-img" id="back1" width="100%" height="100%" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"></svg>

        <div class="container ">
          <div class="carousel-caption mb-5">
            <h1 class="text-dark">UMA NOVA LOJA PARA SI</h1>
            <p class="text-dark">A ECOSMART DÁ-LHE A POSSIBILIDADE DE COMPRAR PRODUTOS A PENSAR NO IMPACTO AMBIENTAL!</p>
            <p><a class="btn btn-lg btn-primary mb-5" href="{{ route('products') }}">LOJA</a></p>
          </div>
        </div>
      </div>
     
      <div class="carousel-item">
        <svg class="bd-placeholder-img" id="back2" width="100%" height="100%" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"></svg>

        <div class="container">
          <div class="carousel-caption text-dark mb-5">
            <h1>ESCOLHA OS LOOKS QUE MAIS GOSTA</h1>
            <p>E NA HORA DE COMPRAR, NÃO SE ESQUEÇA DO AMBIENTE!</p>
            <p><a class="btn btn-lg btn-primary mb-5" href="{{ route('products') }}">LOJA</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" id="back3" width="100%" height="100%" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"></svg>

        <div class="container">
          <div class="carousel-caption text-dark mb-5">
            <h1> ENORME VARIEDADE DE PRODUTOS </h1>
            <p>A ECOSMART TEM TUDO O QUE VOCÊ PRECISA!</p>
            <p><a class="btn btn-lg btn-primary mb-5" href="{{ route('products') }}">LOJA</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  @show

            
       
    </body>
</html>