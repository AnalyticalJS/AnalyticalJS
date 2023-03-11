<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} 📊</title>

        <meta name="description" content="Open source, transparent, simple and free for all website analytics. ⭐⭐⭐⭐⭐">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ mix('js/analytical.js') }}"  @if(env("APP_ENV") == "local") data-debug-analytical-js="true" @endif defer></script>

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

    </head>
    <body>

        <div class="bar-holder">

                <div class="bar fill1"></div>

                <div class="bar fill2"></div>

                <div class="bar fill3"></div>

                <div class="bar fill4"></div>

                <div class="bar fill1"></div>

                <div class="bar fill5"></div>

                <div class="bar fill6"></div>

                <div class="bar fill1"></div>

                <div class="bar fill2"></div>

                <div class="bar fill3"></div>

        </div>
       
        <div class="hero-head">

            <div class="hero-content">

                <h1 class="logo"><a href="/">Analytical.js</a></h1>

                <p>Open source, transparent, simple and free for all <span class="underlined">website analytics.</span></p>

                <div class="spacer20"></div>

                @include("layouts.includes.domainSearch")

                <div class="spacer20"></div>

                <a href="https://github.com/AnalyticalJS/AnalyticalJS" class="btn btn-gradient-purple">View on GitHub</a>

            </div>

        </div>

        <script>
            document.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    goToSite();
                }
            });
            
            function goToSite () {
                var prod = "{{env("APP_URL")}}";
                if(document.getElementById("website").value == ""){
                    window.location.href = "/site/"+prod.replace('https://','').replace('http://','').split('/')[0].toLowerCase();
                } else {
                    window.location.href = "/site/"+document.getElementById("website").value.replace('https://','').replace('http://','').split('/')[0].toLowerCase();
                }
            }
        </script>
        
    </body>
</html>
