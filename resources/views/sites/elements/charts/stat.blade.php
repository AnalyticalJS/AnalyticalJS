<div class="panel height100">

    <h2 class="panelHeader">Stats <span class="record"></span></h2>

    <div class="row">

        <div class="col-md-3">        

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="sessionsCount">{{GlobalFunc::count_format2($sessions->count())}}</div>

                <small>Sessions active in the last 24 hours</small>

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

                <div class="mediumNumber gradientText" id="countriesCount">{{GlobalFunc::count_format2($sessionInfo->unique("countryName")->count())}}</div>

                <small>Countries in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">        

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="citiesCount">{{GlobalFunc::count_format2($sessionInfo->unique("cityName")->count())}}</div>

                <small>Cities in the last 24 hours</small>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="browserCount">{{GlobalFunc::count_format2($sessionInfo->unique("browser")->count())}}</div>

                <small>Browsers used in the last 24 hours</small>

            </div>

        </div>
        
        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="devicesCount">{{GlobalFunc::count_format2($sessionInfo->unique("device_type")->count())}}</div>

                <small>Devices used in the last 24 hours</small>

            </div>

        </div>
        
        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="osCount">{{GlobalFunc::count_format2($sessionInfo->unique("device_title")->count())}}</div>

                <small>OS used in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-3">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="mediumNumber gradientText" id="referralsCount">{{GlobalFunc::count_format2($referralData->sum("count"))}}</div>

                <small>Referrals in the last 24 hours</small>

            </div>

        </div>

    </div>

</div>