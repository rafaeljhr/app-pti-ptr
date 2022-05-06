
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
                            <th>Username</th>
                            <th>Password</th>
                            <th>Cargo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                        
                            <td> {{$user->id}} </td>
                            <td> {{$user->username}} </td>
                            <td> {{$user->password}} </td>
                            <td> {{$user->cargo}} </td>
                            <td>  </td>
                        </tr>
                    @endforeach
                    @if (session()->get('ADMIN_cargo') == "Manager")
                        <tr>
                            <form method="post"  action="{{ route('addAdmin') }}">
                            {{ csrf_field() }}
                                <td> <input type="text" class="form-control" name="admin_username" placeholder="Username"> </td>
                                <td> <input type="password" class="form-control" name="admin_password" placeholder="Password"> </td>
                                <td> <select class="form-select" name="admin_cargo[]">
                                        <option selected>Admin</option>
                                        <option value="1">Manager</option>
                                    </select> </td>
                                <td> <button type="submit" class="btn btn-primary">
                                        +
                                    </button> </td>
                            </form>
                        </tr>
                    @endif
                    </tbody>
            </table>
        </div>
        </div>
</div>