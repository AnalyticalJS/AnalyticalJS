<div class="panel height100">

    <h2 class="panelHeader">Countries</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($sessionInfo->unique("countryName")->sortByDesc("countCountries")->slice(0, 100) as $country)

                <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                    <div class="col-10">

                        {{$country->countryName}}

                    </div>

                    <div class="col-2 text-right">

                        {{$country->countCountries}}

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>