@extends('layouts.page_default')

@section('background')
    
    <link rel="stylesheet" href="css/contactos.css">
    <link rel="stylesheet" href="css/page_default.css">

    <section>

    <div class="page-name">
        <h4 class="text-center mx-auto section-title name mb-5">Contactos</h4>
    </div>

    <div class="div-mail">
        <h4 class="section-title text-center">Fale connosco</h4>
        <a href="mailto:storecosmart@gmail.com"><button type="button" class="btn about-btn mailto btn-dark section-title mt-3 mb-4">Enviar email</button></a>
    </div>

    <div class="mx-auto ml-3 mb-4">
        
        <div class="div-mapa">
            <h4 class="text-center mx-auto section-title mb-5">Onde nos encontramos</h4>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3111.312781936158!2d-9.15756908431068!3d38.75652946283964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1932fc1d6c5e9b%3A0xe04b42461bdb164c!2sFaculdade%20de%20Ci%C3%AAncias%20da%20Universidade%20de%20Lisboa!5e0!3m2!1spt-PT!2sbe!4v1652910537787!5m2!1spt-PT!2sbe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>
    <div class="texto">
    <h4 class="section-title text-center">Perguntas mais frequentes</h4>
    </div>
    <div class="div-contact">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Cancelar uma encomenda ou pré-encomenda
                </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Se comprou um produto na EcoSmart Store, pode pedir uma devolução. Nessa altura, irá descobrir se o seu produto é elegível para devolução.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Devolver ou trocar itens
                </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Se comprou algo na EcoSmart Store, pode cancelar a encomenda na totalidade ou apenas um item antes de o processo de faturação ou envio ser iniciado. </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Estado de uma devolução e reembolso
                </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Quando solicita um reembolso de algo que comprou na EcoSmart Store, é possível monitorizar o estado online do pedido:
                                            <br><br>
                                            1. Inscreva-se na sua conta EcoSmart e veja o seu Histórico de encomendas.
                                            <br><br>
                                            2. Localize o produto. Incluirá o estado da devolução e do reembolso.
                                            <br><br>  
                                            3. Se vir que emitimos o reembolso, mas o dinheiro não foi creditado no seu fornecedor de pagamentos, aguarde alguns dias. Dependendo do banco, o reembolso pode demorar alguns dias a ser processado.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                    Envio, custos e prazos de entrega
                </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Em todas as encomendas efetuadas na EcoSmart Store é indicado para quando está previsto o envio, quais os custos e qual a estimativa de entrega. 
                                            Estes dados dependende de vários fatores como a disponibilidade do produto ou a distância que os armazéns se encontra do local de entrega, por exemplo.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                    Ver histórico de encomendas
                </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Para ver encomendas e compras anteriores, utilize os filtros Mostrar e Encomendado em.
                                            <br><br>
                                            Se tiver alguma pergunta sobre as suas encomendas, selecione Enviar Email depois das perguntas.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                    Monitorizar a sua encomenda
                </button>
                </h2>
                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Se o estado da sua encomenda for Enviado, verifique se existe uma ligação Monitorização do Envio abaixo do estado. Os pedidos pendentes podem requerer informações atualizadas ou a alteração do método de pagamento.
                                            <br><br>
                                            É possível não seja atribuído um estado de imediato às compras recentes. Verifique novamente mais tarde para ver o progresso da sua encomenda.</div>
                </div>
            </div>

        </div>
    </div>











        <!-- <div class="container contact">
            <div class="row">
            <div class="col-md-3 contact-col">
                <div class="contact-info">
                <img src="https://image.ibb.co/kUASdV/contact-image.png" class="d-flex justify-content-center" alt="image"/>
                <h2>Contacte-nos</h2>
                <h4>Estamos aqui para ajudar no que precisar!</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="fname">Primeiro Nome:</label>
                    <div class="col-sm-10">          
                    <input type="text" class="form-control" id="fname" placeholder="Primeiro Nome" name="fname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="lname">Apelido:</label>
                    <div class="col-sm-10">          
                    <input type="text" class="form-control" id="lname" placeholder="Apelido" name="lname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="comment">Comentário:</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" rows="5" id="comment"></textarea>
                    </div>
                </div>
                <div class="form-group">        
                    <br>
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Enviar</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div> -->


    </section>

    
@endsection