<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('1.png')}}" width="150" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item {{request()->is('/') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('home')}}">Beranda</a>
                </li>
                <li class="nav-item {{request()->is('products*') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('product')}}">Koleksi</a>
                </li>
                @auth
                    <li class="nav-item {{request()->is('renteds') ? 'active' : ''}}">
                        <a class="nav-link" href="{{route('rented')}}">PenyewaanKu</a>
                    </li>
                @endauth
                <li class="nav-item {{request()->is('abouts') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('about')}}">Tentang Kami</a>
                </li>
                <li class="nav-item {{request()->is('contacts') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('contact')}}">Hubungi Kami</a>
                </li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                @auth
                    <li><a class="nav-link" href="{{route('whislist')}}"><img width="20" src="{{asset('asset/heart.png')}}"></a></li>
                    <li><a class="nav-link" href="{{route('account')}}"><img width="20" src="{{asset('asset/user.png')}}"></a></li>
                    <li><a class="nav-link" href="{{route('logout')}}"><img width="20" src="{{asset('asset/logout.png')}}"></a></li>
                @endauth
                @guest
                    <li>
                        <a class="btn btn-secondary btn-sm w-100" href="{{route('login')}}">Login</a>
                    </li>
                    <li>
                        <a class="btn btn-secondary btn-sm w-100" href="{{route('register')}}">Daftar</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
        
</nav>