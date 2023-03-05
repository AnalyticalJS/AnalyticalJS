<div class="panel height100">

    <h2 class="panelHeader">Referrals</h2>
                
    <div class="panelInner">

        <div class="row feedData">

                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Search URL</strong>

                    </div>

                    <div class="col-6 text-right mt-3">

                        <strong>Total @if($referralData) {{$referralData->where("type", "Search")->sum("count")}} @else 0 @endif</strong>

                    </div>

                </div>

                <hr/>

            @if($referralData)

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

            @endif

                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Social URL</strong>

                    </div>

                    <div class="col-6 text-right mt-3">

                        <strong>Total @if($referralData) {{$referralData->where("type", "Social")->sum("count")}} @else 0 @endif</strong>

                    </div>

                </div>

                <hr/>

            @if($referralData)

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

            @endif
                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Video URL</strong>

                    </div>

                    <div class="col-6 text-right mt-3">

                        <strong>Total @if($referralData) {{$referralData->where("type", "Video")->sum("count")}} @else 0 @endif</strong>

                    </div>

                </div>

                <hr/>

            @if($referralData)

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

            @endif
                
                <div class="row mt-3">

                    <div class="col-6 mt-3">

                        <strong>Referral URL</strong>

                    </div>

                    <div class="col-6 text-right mt-3">

                        <strong>Total @if($referralData) {{$referralData->where("type", "Referral")->sum("count")}} @else 0 @endif</strong>

                    </div>

                </div>

                <hr/>

            @if($referralData)

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

            @endif

        </div>

    </div>

</div>