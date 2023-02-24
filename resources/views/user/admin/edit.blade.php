@include('layouts.header')
{{-- <div class="mainBody">
    <h1>{{$title}}</h1>
    <div class="">
        <a href="{{ route('posts.index') }}" class="blue-btn custom-btn-default">Go Back</a>
    </div>
    <div class="container">
        {{ Form::open(['action' => 'App\Http\Controllers\UserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            @csrf
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'AnalyticalJS'] )}}
            </div>
            <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'summary-ckeditor', 'class' => 'form-control', 'placeholder' => 'body Text'] )}}
            </div>
            
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class' =>'blue-btn custom-btn-default'])}}
        {{ Form::close() }} 
    </div>
</div> --}}
{{$username}}
{{$email}}
@include('layouts.footer')