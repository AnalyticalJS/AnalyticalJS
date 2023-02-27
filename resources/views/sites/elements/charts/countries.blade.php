<div class="panel height100">

    <h2 class="panelHeader">Countries</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($sessionInfo->unique("countryName")->sortByDesc("countCountries")->slice(0, 100) as $country)

                @if($country->countCountries > 0)

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$country->countryName}}

                        </div>

                        <div class="col-3 text-right">

                            {{$country->countCountries}}

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    </div>

    <div class="row">

        <div class="col-md-12 text-right">

            <small class="whiteText">Top 100</small>        

        </div>

    </div>

</div>