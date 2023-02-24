@include("layouts.header")

<div class="bar-holder">

    <div class="bar fill1"></div>

    <div class="bar fill2"></div>

    <div class="bar fill3"></div>

    <div class="bar fill4"></div>

    <div class="bar fill1"></div>

    <div class="bar fill5"></div>

    <div class="bar fill6"></div>

    <div class="bar fill1"></div>

    <div class="bar fill2"></div>

    <div class="bar fill3"></div>

</div>

<div class="hero-head">

    <div class="hero-content">
    
        <h1 class="logo">Dashboard</h1>
    
        <div class="spacer20"></div>
    
        <div class="container panel">
            <div class="row">
                <div class="col-md-12">
    
                    <div class="spacer20"></div>
    
                    <div class="col-md-1">
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                    
                                @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @else
                                <ul class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/">
                                            Home
                                        </a>
                                        <a class="dropdown-item" href="/details">
                                            Account
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.index') }}">
                                            Users
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </ul>
                            @endguest
                        </ul>
                    </div>
    
                    <div class="spacer20"></div>
    
                </div>
            </div>
        </div>

@include("layouts.footer")
