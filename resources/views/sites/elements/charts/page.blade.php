<div class="panel height100">

    <h2 class="panelHeader">Pages</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            <div class="row">

                <div class="col-6">

                    <strong>Page URL</strong>

                </div>

                <div class="col-6 text-right">

                    <strong>Total @if($pagesData) {{collect($pagesData)->sum("count")}} @else 0 @endif</strong>

                </div>

            </div>

            <hr/>

            @foreach($pagesData as $pages)

                @if($pages['count'] > 0 && str_contains($pages['url'], $website->domain))

                    <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                        <div class="col-9">

                            {{$pages['url']}}

                        </div>

                        <div class="col-3 text-right">

                            {{$pages['count']}}

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