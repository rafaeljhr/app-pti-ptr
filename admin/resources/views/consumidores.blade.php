
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="d-grid gap-2">
  <div class="p-1 ">@include('navbar')</div>
  <div class="p-1 ">

        <div class="container table-responsive align-baseline vh-100 ">
            <table id="" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>NIF</th>
                            <th>Morada</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                        
                            <td> {{$user->id}} </td>
                            <td> {{$user->email}} </td>
                            <td> {{$user->nome}} </td>
                            <td> {{$user->telefone}} </td>
                            <td> {{$user->nif}} </td>
                            <td> {{$user->morada}} </td>
                            <td>  </td>
                        </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
        </div>
</div>