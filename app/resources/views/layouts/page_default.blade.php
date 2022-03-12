<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="utf'8">
        <title>Site PTI-PTR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/page_default.css">

        {{-- Bootstrap needed imports --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>


    <body>
        @include('includes.navbar')

        @section('background')

            <div class="divBackground">
                @show
            </div>
            

        @include('includes.footer')
    </body>

</html>