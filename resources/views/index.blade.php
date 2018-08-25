<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Keekionga Farm II</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body id="index_bg" style="background-image: url('images/index-bg/bg-01.jpg'); background-repeat: no-repeat; background-size: 100vw 100vh;">
        <div class="flex-center position-ref full-height">
            <div class="content page-title">
                <div class="title m-b-md">
                    Keekionga Farm II
                </div>

                <div class="links">
                    {{-- <p>
                        Check back at the end of August to see our fully functioning website!
                    </p> --}}
                    <a href="{{ url('contact') }}">Contact Us</a>
                    <a href="{{ url('philosophy') }}">What We're About</a>
                    <a href="{{ url('news') }}">What We've Been Up To</a>
                    <a href="{{ url('offers') }}">What We Offer</a>
                    <a href="{{ url('location') }}">Where To Find Us</a>
                </div>
            </div>
        </div>
    </body>
</html>
