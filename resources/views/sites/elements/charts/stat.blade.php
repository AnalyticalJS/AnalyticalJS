<div class="panel height100">

    <h2 class="panelHeader">Stats</h2>

    <div class="row">

        <div class="col-md-4">        

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="largeNumber gradientText">{{GlobalFunc::count_format2($sessions->count())}}</div>

                <small>Sessions active in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-4">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="largeNumber gradientText">{{GlobalFunc::count_format2($sessions->sum("pages"))}}</div>

                <small>Pages viewed in the last 24 hours</small>

            </div>

        </div>

        <div class="col-md-4">   

            <div class="panelInner mt-3 mb-3 pb-3 pt-3">

                <div class="largeNumber gradientText">{{GlobalFunc::count_format2($sessionInfo->unique("countryName")->count())}}</div>

                <small>Countries sessions originated from in the last 24 hours</small>

            </div>

        </div>

    </div>

</div>