@extends('layouts.page_default')

@section('background')
    
    <link rel="stylesheet" href="css/contactos.css">
    <link rel="stylesheet" href="css/page_default.css">
    <link href="bootstrap.min.css" rel="stylesheet">

    <section>

    <div class="div-contact">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Accordion Item #1
                </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Accordion Item #2
                </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Accordion Item #3
                </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
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