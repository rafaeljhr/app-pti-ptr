<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

</head>
<body>

    @include('navbar')

    <div class="container content">
        <h1>Fornecedores</h1>
        <a class="btn btn-success" href="javascript:void(0)" id="botaoCriar">Criar Fornecedor</a>
        <table class="table table-bordered data-table tabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Telemóvel</th>
                    <th>Contribuinte</th>
                    <th>País</th>
                    <th>Código Postal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        
        </table>

    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="fornecedorForm" name="fornecedorForm" class="form-horizontal">
                        <input type="hidden" name="fornecedor_id" id="fornecedor_id" />
                        
                        <div class="form-group">
                            Email: <br>
                            <input type="text" class="form-control" id="email" name="email" value="" required />
                        </div>
                        <div class="form-group">
                            Nome: <br>
                            <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="" required />
                        </div>
                        <div class="form-group">
                            Apelido: <br>
                            <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome"  value="" required />
                        </div>
                        <div class="form-group">
                            Password: <br>
                            <input type="password" class="form-control" id="password" name="password"  value="" required />
                        </div>
                        <div class="form-group">
                            Telemóvel: <br>
                            <input type="text" class="form-control" id="telemovel" name="telemovel"  value="" required />
                        </div>
                        <div class="form-group">
                            NIF: <br>
                            <input type="text" class="form-control" id="nif" name="nif"  value="" required />
                        </div>
                        <div class="form-group">
                            Morada: <br>
                            <input type="text" class="form-control" id="morada" name="morada"  value="" required />
                        </div>
                        <div class="form-group">
                            Codigo Postal: <br>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="" required />
                        </div>
                        <div class="form-group">
                            País: <br>
                            <input type="text" class="form-control" id="pais" name="pais"  value="" required />
                        </div>
                        <div class="form-group">
                            Cidade: <br>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="" required />
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create" ></button>
                    </form>
                </div>
            </div>
        </dvi>
    </div>

    <script type="text/javascript">
        $(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
        
            var table = $(".data-table").DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{route('fornecedores.index')}}",
                columns:[
                    {data: 'id', name:'ID'},
                    {data: 'email', name:'Email'},
                    {data: 'primeiro_nome', name:'Nome'},
                    {data: 'ultimo_nome', name:'Apelido'},
                    {data: 'numero_telemovel', name:'Telemóvel'},
                    {data: 'numero_contribuinte', name:'Contribuinte'},
                    {data: 'pais', name:'País'},
                    {data: 'codigo_postal', name:'Código Postal'},
                    {data: 'action', name:'Action', orderable: false, searchable: false},
                ]
            });

            $("#botaoCriar").click(function(){
                $("#saveBtn").html("Criar");
                $("#fornecedor_id").val("");
                $("#modalHeading").html("Criar Fornecedor");
                $("#fornecedorForm").trigger("reset");
                $('#ajaxModel').modal("show");
            });

            $("#saveBtn").click(function(e){
                e.preventDefault();

                $.ajax({
                    data:$("#fornecedorForm").serialize(),
                    url:"{{route('fornecedores.store')}}",
                    type:"POST",
                    dataType:"json",
                    success:function(data){
                        $("#fornecedorForm").trigger("reset");
                        $('#ajaxModel').modal("hide");
                        table.draw();
                    },
                    error:function(data){
                        console.log("Error", data);
                    }
                });
            });

            $('body').on('click', '.deleteFornecedor', function(){
                var fornecedor_id = $(this).data("id");
                if (confirm("Tem a certeza que deseja apagar este fornecedor?")){
                    $.ajax({
                        type:"DELETE",
                        url:"{{route('fornecedores.index')}}" + '/' + fornecedor_id,
                        success: function(data){
                            table.draw();
                        },
                        error:function(data){
                            console.log("Error", data);
                        }
                    });
                }
            });

            $('body').on('click', '.editFornecedor', function(){
                var fornecedor_id = $(this).data("id");
                $("#saveBtn").html("Guardar");
                $.get("{{route('fornecedores.index')}}" + "/" + fornecedor_id + "/edit", function(data){
                    $("#modalHeading").html("Editar Fornecedor");
                    $("#ajaxModel").modal('show');
                    $("#fornecedor_id").val(data.id);
                    $("#email").val(data.email);
                    $("#primeiro_nome").val(data.primeiro_nome);
                    $("#ultimo_nome").val(data.ultimo_nome);
                    $("#nif").val(data.numero_contribuinte);
                    $("#telemovel").val(data.numero_telemovel);
                    $("#password").val(data.password);
                    $("#morada").val(data.morada);
                    $("#codigo_postal").val(data.codigo_postal);
                    $("#pais").val(data.pais);
                    $("#cidade").val(data.cidade);
 
                });

            });
        });

    </script>
</body>