<div class="panel height100">

    <h2 class="panelHeader">Stats <span class="record"></span></h2>

    <div class="row">

        <div class="col-md-3">        

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="sessionsCount">{{GlobalFunc::count_format2($sessions->count())}}</div>

                <small>Sessions in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="pagesCount">{{GlobalFunc::count_format2($sessions->sum("pages"))}}</div>

                <small>Pages viewed in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="countriesCount">@if($sessionInfo) {{GlobalFunc::count_format2(collect($sessionInfo)->unique("countryName")->count())}} @else 0 @endif</div>

                <small>Countries in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">        

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="citiesCount">{{GlobalFunc::count_format2(collect($sessionInfo)->unique("cityName")->count())}}</div>

                <small>Cities in the last 24 hours</small>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="browserCount">{{GlobalFunc::count_format2(collect($sessionInfo)->unique("browser")->count())}}</div>

                <small>Browsers used in the last 24 hours</small>

            </div>

        </div>
        
        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="devicesCount">{{GlobalFunc::count_format2(collect($sessionInfo)->unique("device_type")->count())}}</div>

                <small>Devices used in the last 24 hours</small>

            </div>

        </div>
        
        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="osCount">{{GlobalFunc::count_format2(collect($sessionInfo)->unique("os_title")->count())}}</div>

                <small>OS used in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="referralsCount">@if($referralData) {{GlobalFunc::count_format2($referralData->sum("count"))}} @else 0 @endif</div>

                <small>Referrals in the last 24 hours</small>

            </div>

        </div>

    </div>

</div>