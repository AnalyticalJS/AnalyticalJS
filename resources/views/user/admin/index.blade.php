@include('layouts.header')
@include('layouts.includes.bar')
<div class="hero-head">

    <div class="hero-content">
    
        <h1 class="logo">{{ $title }}</h1>
    
        <div class="spacer20"></div>

            <div class="container panel">

                <div class="row">
                    
                    <div class="col-md-12">

                        <div class="spacer20"></div>

                            <div class="col-md-10 users">

                                <h2 class="" >Username:</h2>

                                @if(count($users) > 0)
                                    @foreach ($users as $user)
                                        <span class="Username"><a href="/user/{{$user->id}}">{{$user->name}}</a></span><br>
                                        {{-- <span class="">{{$user->name}}</span> --}}
                                    @endforeach
                                @else 
                                    <span>No Users Found</span>
                                @endif

                            </div>

                        <div class="spacer20"></div>  

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">

                        <div class="CustomBtn">
                            <a href="/dashboard" class="btn btn-gradient-purple">Back</a>
                        </div>

                    </div>

                    <div class="col-md-3">


                        <div>
                            <a href="{{ route('user.create')}}" class="btn btn-gradient-purple">Create User</a>
                        </div>

                    </div>
                
                </div>

            </div>

        </div>

    </div>

</div>
@include('layouts.footer')