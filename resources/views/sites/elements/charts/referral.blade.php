<div class="panel height100">

    <h2 class="panelHeader">Referrals</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($referralData as $referral)

                <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                    <div class="col-8">

                        {{$referral->url}}

                    </div>

                    <div class="col-4 text-right">

                        {{$referral->count}}

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>