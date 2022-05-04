<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Web API</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style type="text/css">
            .box{
                width: 600px;
                margin: 0 auto;
                border: 1px solid #ccc
            }
        
        </style>

    </head>
    <body>
        <br />
        <div class="container box">

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss=" alert">x</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <form method = "post" action="{{ url('checklogin') }}">

                {{ csrf_field() }}

                <label for="tipo_conta" class="form-label">Tipo de conta a autenticar</label>
                <select class="form-select mb-3" name ="tipo_conta">
                    <option selected value="consumidor">Consumidor</option>
                    <option value="fornecedor">Fornecedor</option>
                    <option value="transportadora">Transportadora</option>
                </select>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <br />
                <div class="form-group">
                    <input type="submit" name="login" class="btn btn-primary" value="Login" />
                </div>
            </form>
        </div>  
    </body>
</html>
