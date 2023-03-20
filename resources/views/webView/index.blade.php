<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>30D</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/fav.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
<div class="parentDiv">
    <div class="row m-0 p-0">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-0 m-0">
            <div class="message">
                <div class="backGround" style="background-image: url('{{ asset('img/test.png')}}');">
                    <div class="tile">
                        <h2>Zakat</h2>
                        <h5>Mijn derde pilaar</h5>
                    </div>

                </div>
                @if(!empty($data))
                    @if($data->status  == 'paid')
                        <div class="bodyMessage">
                            <h3>BETALING GELUKT!</h3>
                            <p>Alhamdoulillah, moge Allah het van jou en van ons accepteren!</p>
                            <p class="blodP">Betaling Afgerond: Bedankt voor je donatie</p>
                        </div>
                        <div class="image mt-5 mb-5 text-center">
                            <img src="{{asset('/img/check-mark .svg')}}" alt="svg">
                        </div>
                        <div class="buttonText text-center mb-5">
                            <button class="btn">TERUG NAAR DASHBOARD</button>
                        </div>
                    @else
                        <div class="bodyMessage">
                            <h3>BETALING NIET GELUKT!</h3>
                            <p>Er ging iets mis met de betaling. </p>
                            <p class="blodP">Probeer het opnieuw of neem contact met ons op.</p>
                        </div>
                        <div class="image mt-5 mb-5 text-center">
                            <img src="{{asset('/img/x-mark.svg')}}" alt="svg">
                        </div>
                        <div class="buttonText text-center mb-5">
                            <button class="btn">TERUG NAAR DASHBOARD</button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
