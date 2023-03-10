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

                            <h2 class="gradientText">Overall Statistics</h2>
                            <p>Statistics for pages, sessions and countries over the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12 mt-12 mb-3">
                
                        @include('sites.elements.charts.stat')

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

                    <div class="col-lg-4 col-md-6 mt-3 mb-3">

                        @include('sites.elements.charts.browser')

                    </div>

                    <div class="col-lg-4 col-md-6 mt-3 mb-3">

                        @include('sites.elements.charts.os')

                    </div>

                    <div class="col-lg-4 col-md-6 mt-3 mb-3">

                        @include('sites.elements.charts.device')

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="codeSnippet">

                            <h2 class="gradientText">Bots and Crawler Statistics</h2>
                            <p>Statistics about the bots that crawled this website in the past <span class="underlined">24 hours</span>.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-6 mt-3 mb-3 justify-content-center">

                        @include('sites.elements.charts.bots')

                    </div>

                    <div class="col-lg-8 col-md-6 mt-3 mb-3 justify-content-center">

                        @include('sites.elements.charts.crawler')

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


                    <div class="col-lg-8 mt-3 mb-3">

                        @include('sites.elements.charts.referral')

                    </div>

                    <div class="col-lg-4 mt-3 mb-3">

                        @include('sites.elements.charts.referralType')

                    </div>

                </div>
                
                <div class="row">

                    <div class="col-lg-12 mt-3 mb-3">

                        @include('sites.elements.charts.page')

                    </div>

                </div>

                <div class="spacer20"></div>

            </div>

        </div>

    </body>

    <script>
            var chart;
            var data = @json($daily);
            var sessionData = @json($sessionInfo);
            var referralTypeData = sortBy(getUniqueListBy(@json($referralTypeData),'type'), "typeCount").slice(0,10);
            var botData = sortBy(getUniqueListBy(@json($botData),'bot'), "count").slice(0,10);
            var browserData = sortBy(getUniqueListBy(sessionData,'browser'), "countBrowser").slice(0,10);
            var operatingData = sortBy(getUniqueListBy(sessionData,'os_title'), "countOs").slice(0,10);
            var deviceData = sortBy(getUniqueListBy(sessionData,'device_type'), "countDevice").slice(0,10);

            function getUniqueListBy(arr, key) {
                return [...new Map(arr.map(item => [item[key], item])).values()]
            }
            function sortBy(array, by){
                var byDate = array.slice(0);
                return byDate.sort(function(a,b) {
                    return a[by] - b[by];
                }).reverse();
            }

    </script>

    <script src="{{ mix('js/chart.js') }}"></script>

    <script>
            realtime = setInterval(function() { 
                fetch("/api/realtime/{{ $website->id }}").then((response) => response.json()).then((data) => updateRealtime(data));
            }, 5000);
            function updateRealtime(udata){
                udata[1].reverse();
                document.getElementById("sessions").innerHTML = udata[0][0];
                document.getElementById("pages").innerHTML = udata[0][1];
                document.getElementById("sessionsCount").innerHTML = udata[0][2];
                document.getElementById("pagesCount").innerHTML = udata[0][3];
                document.getElementById("countriesCount").innerHTML = udata[0][4];
                document.getElementById("citiesCount").innerHTML = udata[0][5];
                document.getElementById("browserCount").innerHTML = udata[0][6];
                document.getElementById("devicesCount").innerHTML = udata[0][7];
                document.getElementById("osCount").innerHTML = udata[0][8];
                document.getElementById("referralsCount").innerHTML = udata[0][9];
                chart.data.labels = loopDaily(udata, "hour");
                chart.data.datasets.forEach(function(dataset, index) {
                    if(index == 0){
                        dataset.data = loopDaily(udata, "pages");
                    } else {
                        dataset.data = loopDaily(udata, "sessions");
                    }
                });
                chart.update();
            }
            function loopDaily(d,t){
                var result = [];
                for (let i = 0; i < 24; i++) {
                    result[i] = d[1][i][t];
                }
                return result;
            }
    </script>
</html>

