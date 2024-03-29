<!DOCTYPE html>
<html lang="pt">

    <head>
        <meta charset="utf'8">
        <title>EcoSmart Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="./images/imagem_tab.png">

        <link rel="stylesheet" href="css/page_default.css">

        {{-- Bootstrap needed imports --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://unpkg.com/@popperjs/core@2">

        {{-- Vue.js needed import --}}
        <script src="https://unpkg.com/vue@3"></script>
        
    </head>


    <body>
        <div id="page-container" class="app">
            <div id="content-wrap">

                @include('includes.navbar')
                
                @section('background')
                @show

            </div>
        </div>
    </body>
</html>