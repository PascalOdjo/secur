<!doctype html>
    <html lang="eng">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>@yield('title')</title>
            <link rel="stylesheet" href="{{asset('asset/css/bootstrap.min.css')}}">
            <link rel="stylesheet" href="{{asset('asset/css/plugins/owl.carousel.min.css')}}">
            <link rel="stylesheet" href="{{asset('asset/font/flaticon.css')}}">
            <link rel="stylesheet" href="{{asset('asset/css/all.min.css')}}">
            <link rel="stylesheet" href="{{asset('asset/css/fontawsom-all.min.css')}}">
            <link rel="stylesheet" href="{{asset('asset/css/style.css')}}">
        </head>

        <body>
            <header>
                <div class="top-bar bg-danger">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="contact-info">
                                    <ul class="d-flex justify-content-between">
                                        <li><i class="fas fa-phone"></i> +228 96 10 94 66 </li>
                                        <li><i class="fas fa-envelope"></i> odjpaw@gmail.com</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="social-media">
                                    <ul class="d-flex justify-content-between">
                                        <li>Lundi - Vendredi, 08h00 - 17h30</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-nav">
                    <div class="container">
                        <div class="nav-items">
                            <div class="menu-toggle">
                                <div class="menu-burger"></div>
                            </div>
                            <div class="logo">
                                <img src="{{asset('asset/images/logo/secur.png')}}">
                            </div>
                            
                            <div class="menu-items">
                                <div class="menu">
                                    <ul>
                                        <li><a href="{{route('home')}}">Acceuil</a></li>
                                        <li><a href="{{route('about-us')}}">A propos</a></li>
                                        <li><a href="{{route('services')}}">Services</a></li>
                                        @if (session('client_inscrit'))
                                            <li><a href="{{route('requete')}}">Requête</a></li>
                                        @endif
                                        <li><a href="{{route('contact-us')}}">Nous Contacter</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')

            @include('footer')
            
        </body>

        <script src="{{asset('asset/js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('asset/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('asset/js/plugins/owl.carousel.min.js')}}"></script>
        <script src="{{asset('asset/js/script.js')}}"></script>
    </html>