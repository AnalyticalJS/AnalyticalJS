<div class="panel height100">

    <h2 class="panelHeader">Online</h2>
                
    <div class="panelInner mt-3 mb-3  pb-3 pt-3">

        <div class="largeNumber gradientText">{{GlobalFunc::count_format2($realtime->count())}}</div>

        <small>Users active in the last 30 minutes</small>

    </div>

    <div class="panelInner mt-3 mb-3 pb-3 pt-3">

        <div class="largeNumber gradientText">{{GlobalFunc::count_format2($realtime->sum("pages"))}}</div>

        <small>Pages viewed in the last 30 minutes</small>

    </div>

</div>