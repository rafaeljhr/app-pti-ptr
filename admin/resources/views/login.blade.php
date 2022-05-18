<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">

            <form method="post"  action="{{ route('checklogin') }}">
                {{ csrf_field() }}
                <div class="card-body p-5 text-center">

                    <h3 class="mb-5">Sign in</h3>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="typeEmailX-2">Username</label>
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter Username"/>
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="typeEmailX-2">Password</label>
                      <input type="password" name="password" class="form-control form-control-lg"  placeholder="Enter Password"/>
                    </div>

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                </div> 
            </form>

        </div>
      </div>
    </div>
  </div>
</section>