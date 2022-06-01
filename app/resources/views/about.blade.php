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
            <div class="row g-0 team-items">
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
                            <img class="img-fluid" src="images/rafa.jpg" alt="">
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
        
            <h3>A equipa é composta por 5 alunos do 3º ano do curso de Tecnologias DA Informação da Faculdade de Ciências da Universidade de Lisboa. <br>
                No âmbito das disciplinas Projeto de Tecnologias de Informação e Projeto de Tecnologias de Redes foi proposta a concretização duma plataforma inicialmente 
                estruturada na disciplina de Planeamento e Gestão de Projeto. </h3>

            <img class="mx-auto mt-4" id="img-logo" src="images/logo5.png" alt="">
        </div>
    </div>

    <script src="js/main.js"></script>

    
@endsection