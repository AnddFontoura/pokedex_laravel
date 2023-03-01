<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex - André Fontoura</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/0cc6f43f73.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="card bg-danger mt-3">
            <div class="card-header text-white text-center">
                Pokedex - 2023
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                        @if($pokemon)
                            <div class="img bg-white">
                                <img class="img" src="{{ $pokemon->image }}"></img>
                            </div>

                            <p class='text-white mt-3'> {{ $pokemon->name }} </p>

                            @foreach($types as $type) 
                                <span class="btn btn-success"> {{ $type->typeData->name }} </span>
                            @endforeach
                        @endif
                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 pokedex-menu">
                        <ul class="list-group">
                        @foreach($pokemons as $pokemon)
                            <li class="list-group-item"> 
                                <a href="{{ route('pokedex', ['pokemon_id' => $pokemon->api_id]) }}">
                                    #{{ $pokemon->api_id }} - {{ $pokemon->name }}
                                </a> 
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-footer">

            </div>
        </div>
    </div>
</body>

</html>