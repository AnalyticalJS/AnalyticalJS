<div class="panel height100">

    <h2 class="panelHeader">Cities</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($cityData as $city)

                <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                    <div class="col-6">

                        {{$city->cityName}}

                    </div>

                    <div class="col-6 text-right">

                        {{$city->countCity}}

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>