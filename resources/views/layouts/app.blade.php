
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Aug 2024 11:03:47 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, admin theme, bootstrap 4, responsive, sass support, ui kits, crm, ecommerce">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Olian - Bootstrap Minimal & Clean Admin Template</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- Start css -->
    <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet"> <!-- Lien vers le fichier CSS externe -->

    <!-- Switchery css -->
    <link href="{{asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
    <!-- Apex css -->
    <link href="{{asset('assets/plugins/apexcharts/apexcharts.css')}}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{asset('assets/plugins/slick/slick.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/slick/slick-theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/flag-icon.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    {{-- bootstrap --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    {{-- Dark Mode CSS --}}
    <style>
        body.dark-mode {
    background-color: #121212; /* Couleur de fond sombre */
    color: #ffffff; /* Couleur du texte clair */
    }

    body.dark-mode .navbar {
    background-color: #1f1f1f; /* Couleur de la barre de navigation sombre */   
    }   

    /* Ajoutez d'autres styles pour les éléments que vous souhaitez modifier en mode sombre */
    </style>
    <!-- End css -->
</head>
<body class="vertical-layout">    
    <!-- Start Infobar Setting Sidebar -->
    
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <div class="leftbar">
            <!-- Start Sidebar -->
            @include('layouts.aside')
            <!-- End Sidebar -->
        </div>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="index.html" class="mobile-logo"><img src="{{asset('assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-more-fill menu-hamburger-horizontal"></i>
                                                <i class="ri-more-2-fill menu-hamburger-vertical"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                                <i class="ri-close-line menu-hamburger-close"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Topbar -->
            @include('layouts.header')
            <!-- End Topbar -->
            <!-- Start Breadcrumbbar -->                    
            {{-- crm include --}}
            @yield('content')
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
            @include('layouts.footer')
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
    <script src="{{asset('assets/js/detect.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('assets/js/vertical-menu.js')}}"></script>
    <!-- Switchery js -->
    <script src="{{asset('assets/plugins/switchery/switchery.min.js')}}"></script>
    <!-- Apex js -->
    <script src="{{asset('assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexcharts/irregular-data-series.js')}}"></script>    
    <!-- Slick js -->
    <script src="{{asset('assets/plugins/slick/slick.min.js')}}"></script>
    <!-- Custom Dashboard js -->   
    <script src="{{asset('assets/js/custom/custom-dashboard.js')}}"></script>
    <!-- Core js -->
    <script src="{{asset('assets/js/core.js')}}"></script>
    <!-- End js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script> 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggle-dark-mode');
            const body = document.body;
    
            // Vérifiez si le mode sombre est déjà activé
            if (localStorage.getItem('dark-mode') === 'enabled') {
                body.classList.add('dark-mode');
            }
    
            toggleButton.addEventListener('click', function () {
                body.classList.toggle('dark-mode');
    
                // Enregistrez l'état du mode sombre dans le stockage local
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('dark-mode', 'enabled');
                } else {
                    localStorage.setItem('dark-mode', 'disabled');
                }
            });
        });
    </script>
</body>

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Aug 2024 11:04:20 GMT -->
</html>