<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Web Analytics for {!! $website->domain !!} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
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
       
        <div class="hero-head">

            <div class="container text-center">

                <div class="logo"><a href="/">Analytical.js</a></div>

                <h1 class="glassText domain">
                    Site analytics for domain: <span class="underlined blueText">{{ $website->domain }}</span>
                </h1>

                <div class="spacer20"></div>

                <div class="row">

                    <div class="col-md-12 mt-3 mb-3">

                        <div class="codeSnippet">

                            <h2 class="gradientText">Hourly Statistics</h2>
                            <p>Hourly statistics for pages and sessions over the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row flex-column-reverse flex-lg-row">

                    <div class="col-lg-8 mt-3 mb-3">
                
                        @include('sites.elements.charts.daily')

                    </div>

                    <div class="col-lg-4 mt-3 mb-3">
                
                        @include('sites.elements.charts.realtime')

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mt-3 mb-3">

                        <div class="codeSnippet">

                            <h2 class="gradientText">Location Statistics</h2>
                            <p>Location statistics of users who accessed this website in the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12 mt-3 mb-3">

                        @include('sites.elements.charts.world')

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6 mt-3 mb-3">

                        @include('sites.elements.charts.countries')

                    </div>

                    <div class="col-lg-6 mt-3 mb-3">

                        @include('sites.elements.charts.city')

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mt-3 mb-3">

                        <div class="codeSnippet">

                            <h2 class="gradientText">Device Statistics</h2>
                            <p>Statistics about the devices used to access this website in the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-4 mt-3 mb-3">

                        @include('sites.elements.charts.browser')

                    </div>

                    <div class="col-lg-4 mt-3 mb-3">

                        @include('sites.elements.charts.os')

                    </div>

                    <div class="col-lg-4 mt-3 mb-3">

                        @include('sites.elements.charts.device')

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mt-3 mb-3">

                        <div class="codeSnippet">

                            <h2 class="gradientText">Referral and Page Statistics</h2>
                            <p>Statistics about the referral data and pages accessed on this website in the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6 mt-3 mb-3">

                        @include('sites.elements.charts.referral')

                    </div>

                    <div class="col-lg-6 mt-3 mb-3">

                        @include('sites.elements.charts.page')

                    </div>

                </div>

                <div class="spacer20"></div>

            </div>

        </div>

    </body>

    <script src="{{ mix('js/chart.js') }}" defer></script>

</html>
