<div class="panel height100">

    <h2 class="panelHeader">Referrals</h2>
                
    <div class="panelInner">

        <div class="row feedData">

                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Search URL</strong>

                    </div>

                    <div class="col-6 text-right">

                        <strong>Total {{$referralData->where("type", "Search")->sum("count")}}</strong>

                    </div>

                </div>

                <hr/>

            @foreach($referralData->where("type", "Search") as $referral)

                @if($referral['count'] > 0)

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$referral['url']}}

                        </div>

                        <div class="col-3 text-right">

                            {{$referral['count']}}

                        </div>

                    </div>
                
                @endif

            @endforeach

                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Social URL</strong>

                    </div>

                    <div class="col-6 text-right">

                        <strong>Total {{$referralData->where("type", "Social")->sum("count")}}</strong>

                    </div>

                </div>

                <hr/>

            @foreach($referralData->where("type", "Social") as $referral)

                @if($referral['count'] > 0)

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$referral['url']}}

                        </div>

                        <div class="col-3 text-right">

                            {{$referral['count']}}

                        </div>

                    </div>
                
                @endif

            @endforeach
                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Video URL</strong>

                    </div>

                    <div class="col-6 text-right">

                        <strong>Total {{$referralData->where("type", "Video")->sum("count")}}</strong>

                    </div>

                </div>

                <hr/>

            @foreach($referralData->where("type", "Video") as $referral)

                @if($referral['count'] > 0)

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$referral['url']}}

                        </div>

                        <div class="col-3 text-right">

                            {{$referral['count']}}

                        </div>

                    </div>
                
                @endif

            @endforeach
                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Referral URL</strong>

                    </div>

                    <div class="col-6 text-right">

                        <strong>Total {{$referralData->where("type", "Referral")->sum("count")}}</strong>

                    </div>

                </div>

                <hr/>

            @foreach($referralData->where("type", "Referral") as $referral)

                @if($referral['count'] > 0)

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$referral['url']}}

                        </div>

                        <div class="col-3 text-right">

                            {{$referral['count']}}

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