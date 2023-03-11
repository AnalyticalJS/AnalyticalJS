<div class="panel height100">

    <h2 class="panelHeader">Online <span class="record"></span></h2>
                
    <div class="panelInner mt-3 mb-3  pb-3 pt-3">

        <div class="largeNumber gradientText" id="sessions">{{GlobalFunc::count_format2($realtime->count())}}</div>

        <small>Sessions active in the last 30 minutes</small>

    </div>

    <div class="panelInner mt-3 pb-3 pt-3">

        <div class="largeNumber gradientText" id="pages">{{GlobalFunc::count_format2($realtime->sum("pages"))}}</div>

        <small>Pages viewed in the last 30 minutes</small>

    </div>

    <div class="row">

        <div class="col-md-12 text-right">

            <small class="whiteText">Updated <span id="updatedTime">0</span>s ago</small>        

        </div>

    </div>

</div>