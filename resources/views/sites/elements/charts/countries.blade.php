<div class="panel height100">

    <h2 class="panelHeader">Countries</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($countryData as $country)

                <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                    <div class="col-6">

                        {{$country->countryName}}

                    </div>

                    <div class="col-6 text-right">

                        {{$country->countCountries}}

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>