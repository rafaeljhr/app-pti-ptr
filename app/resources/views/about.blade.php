<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/bootstrap.min2.css">



@extends('layouts.page_default')

@section('background')
    @parent

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5">
                <h4 class="section-title">Equipa</h4>
                <h1>Conheça a equipa responsável pela plataforma!</h1>
            </div>
            <div class="row g-0 team-items"  data-mdb-animation-start="onScroll">
                <div class="col-lg col-md-6">
                    <div class="team-item position-relative">
                        <div class="position-relative">
                            <img class="img-fluid" src="images/rafa.jpg" alt="">
                            <div class="team-social text-center">

                            </div>
                        </div>
                        <div class="bg-light text-center p-4">
                            <h3 class="mt-2">Rafael <br> Ribeiro</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-6">
                    <div class="team-item position-relative">
                        <div class="position-relative">
                            <img class="img-fluid" src="images/miguel.jpg" alt="">
                            <div class="team-social text-center">

                            </div>
                        </div>
                        <div class="bg-light text-center p-4">
                            <h3 class="mt-2">Miguel <br> Duarte</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-6" >
                    <div class="team-item position-relative">
                        <div class="position-relative">
                            <img class="img-fluid" src="images/xisco.jpg" alt="">
                            <div class="team-social text-center">

                            </div>
                        </div>
                        <div class="bg-light text-center p-4">
                            <h3 class="mt-2">Francisco Pimenta</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-6">
                    <div class="team-item position-relative">
                        <div class="position-relative">
                            <img class="img-fluid" src="images/toni.png" alt="">
                            <div class="team-social text-center">

                            </div>
                        </div>
                        <div class="bg-light text-center p-4">
                            <h3 class="mt-2">António Pereira</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-6">
                    <div class="team-item position-relative">
                        <div class="position-relative">
                            <img class="img-fluid" src="images/pedro.jpg" alt="">
                            <div class="team-social text-center">

                            </div>
                        </div>
                        <div class="bg-light text-center p-4">
                            <h3 class="mt-2">Pedro <br> Quintão</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-justify mx-auto mt-5" id="div-about">
        
            <h3>A equipa é composta por 5 alunos do 3º ano do curso de Tecnologias de Informação da Faculdade de Ciências da Universidade de Lisboa. <br>
                No âmbito das disciplinas Projeto de Tecnologias de Informação e Projeto de Tecnologias de Redes foi proposta a criação duma plataforma inicialmente 
                estruturada na disciplina de Planeamento e Gestão de Projeto. </h3>

        </div>

        <div class="mx-auto ml-3 mb-4">
        <h4 class="text-center mx-auto section-title mb-5">Onde nos encontramos</h4>
        <div class="d-flex justify-content-center mx-auto">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3111.312781936158!2d-9.15756908431068!3d38.75652946283964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1932fc1d6c5e9b%3A0xe04b42461bdb164c!2sFaculdade%20de%20Ci%C3%AAncias%20da%20Universidade%20de%20Lisboa!5e0!3m2!1spt-PT!2sbe!4v1652910537787!5m2!1spt-PT!2sbe" width="1260" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>

        <h4 class="text-center mx-auto section-title mt-5">A nossa missão</h4>
        <div class="row text-justify mx-auto" id="div-about">
        
            <h3>O objectivo da EcoSmart Store é ser transparente com os nossos clientes
            e com o ambiente.
            Quando compra na EcoSmart Store saberá o histórico de poluição do produto 
            que encomenda, desde a produção à entrega. Desta forma fará de forma
            consciente as compras verdadeiramente eco-friendly!
            <br><i>"Be smart, be EcoSmart"</i> </h3>

        </div>

        <h4 class="text-center mx-auto section-title mt-2">Fale connosco</h4>
        <div class="d-flex justify-content-center mx-auto mt-5">
            <a href="mailto:storecosmart@gmail.com"><button type="button" class="btn about-btn mailto btn-dark section-title mt-3 mb-4">Enviar email</button></a>
        </div>
        
        <div class="d-flex justify-content-center mx-auto mt-5">
            <a href="{{ route('contact-url') }}"><button type="button" class="btn about-btn about-left-btn btn-dark">Equipa EcoSmart Store</button></a>
            <a href="{{ route('contact-url') }}" ><button type="button" class="btn about-btn btn-dark">Loja de produtos</button></a>
            <a href="{{ route('api-documentacao') }}"><button type="button" class="btn about-btn btn-dark">API EcoSmart Store</button></a>
            <a href="https://api.eco-smart-store.rafaeljhr.pt/login"><button type="button" class="btn about-btn btn-dark">Obter token API EcoSmart Store</button></a>
            
        </div>
     
        
        
    </div>

    <script src="js/main.js"></script>

    
@endsection