<div class="panel height100">

    <h2 class="panelHeader">Pages</h2>
                
    <div class="panelInner">

        <div class="row feedData">

            @foreach($pagesData as $pages)

                <div class="row @if($loop->iteration  % 2 == 0) even @else odd @endif">

                    <div class="col-8">

                        {{$pages->url}}

                    </div>

                    <div class="col-4 text-right">

                        {{$pages->count}}

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>