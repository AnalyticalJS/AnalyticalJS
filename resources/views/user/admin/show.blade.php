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

                        {{$username}}<br>

                        {{$email}}<br> 

                        {{-- <a href="{{ route('user.admin.edit', $username) }}" class="btn btn-gradient-purple">Edit</a> --}}
                
                        {{-- {!!Form::open(['action' => ['App\Http\Controllers\UserController@update', $post->id], 'methdd' => 'POST', 'class' => 'deleteBtn'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('delete', ['class' => 'btn btn-gradient-purple'])}}
                        {!!Form::close()!!} --}}

                        <div class="spacer20"></div>  

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@include('layouts.footer')