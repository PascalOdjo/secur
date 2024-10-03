<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Title -->
    <title>Ensure - Insurance Service Bootstrap 5 Template</title>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- CSS Template -->
    <link href="{{asset('public/static/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Skippy -->
    <a id="skippy" class="sr-only sr-only-focusable u-skippy" href="#content">
        <div class="container">
            <span class="u-skiplink-text">Skip to main content</span>
        </div>
    </a>
    <!-- End Skippy -->
    <!-- Preload -->
    <div id="loading" class="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- End Preload -->
    <!-- Search START -->
    <div class="px-search-full collapse bg-dark p-3 z-index-999 position-fixed w-100" id="search-open">
        <div class="container position-relative">
            <div class="row vh-100 justify-content-center">
                <div class="col-lg-8 pt-12">
                    <h2 class="h1">
                        <span class="d-block text-white">Search</span>
                    </h2>
                    <form class="position-relative w-100">
                        <div class="mb-3 input-group">
                            <!-- Search input -->
                            <input class="form-control border-0 shadow-none" type="text" name="search" placeholder="What are you looking for?">
                            <!-- Search button -->
                            <button type="button" class="btn btn-primary shadow-none">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Search button close START -->
                <a class="search-close" data-bs-toggle="collapse" href="javascript:void(0)" data-bs-target="#search-open" aria-expanded="true">
                    <i class="fas fa-times p-0"></i>
                </a>
                <!-- Search button close END -->
            </div>
        </div>
    </div>
    <!-- Search END -->
    <!-- Header -->
    <header class="header-main header-dark header-option-1 shadow-lg">
        <!-- Top Header -->
        <div class="header-top small bg-white border-bottom">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Left -->
                    <div class="nav dark-link d-none d-lg-flex">
                        <a class="me-4" href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="me-4" href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="me-4" href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="me-4" href="#">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <!-- Right -->
                    <div class="d-flex align-items-center justify-content-center w-100 w-lg-auto dark-link">
                        <!-- Language -->
                        <div class="dropdown ms-0 ms-lg-3">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdown_language" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img class="fa-fw me-2" src="static/img/flags/uk.svg" alt=""> English </a>
                            <div class="dropdown-menu mt-2 shadow small dark-link" aria-labelledby="dropdown_language" style="margin: 0px;">
                                <a class="dropdown-item" href="#"><img class="fa-fw me-2" src="{{asset('public/static/img/flags/sp.svg')}}" alt=""> Español</a>
                                <a class="dropdown-item" href="#"><img class="fa-fw me-2" src="{{asset('public/static/img/flags/fr.svg')}}" alt=""> Français</a>
                                <a class="dropdown-item" href="#"><img class="fa-fw me-2" src="{{asset('public/static/img/flags/gr.svg')}}" alt=""> Deutsch</a>
                            </div>
                        </div>
                        <!-- Top link -->
                        <ul class="nav ms-auto ms-lg-3">
                            <li class="nav-item">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Middle -->
        <div class="header-middle navbar navbar-expand-lg navbar-light bg-white py-4 py-lg-5">
            <div class="container">
                <div class="d-flex w-100">
                    <div class="col-6 col-md-3">
                        <!-- Logo -->
                        <a class="navbar-brand" href="index.html">
                            <img src="{{asset('public/static/img/logo.svg')}}" title="" alt="">
                        </a>
                        <!-- Logo -->
                    </div>
                    <div class="col-6 col-md-9">
                        <!-- End Menu -->
                        <div class="nav flex-nowrap align-items-center justify-content-end">
                            <!-- Mobile Toggle -->
                            <button class="navbar-toggler ms-auto me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <!-- End Mobile Toggle -->
                            <!-- Nav Search-->
                            <div class="nav-item d-lg-none">
                                <a class="nav-link pe-0 collapsed display-7 py-0 me-3" data-bs-toggle="collapse" href="javascript:void(0)" data-bs-target="#search-open" aria-expanded="false">
                                    <i class="bi bi-search display-8"> </i>
                                </a>
                            </div>
                            <!-- Nav Button -->
                            <div class="nav text-dark d-none d-lg-flex">
                                <div class="d-flex ms-4">
                                    <div class="only-icon only-icon lh-1 text-primary">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="col ps-2 small lh-sm">
                                        <span>Mon - Fri 08:00 - 20:00<br />Closed on Weekends</span>
                                    </div>
                                </div>
                                <div class="d-flex ms-4">
                                    <div class="only-icon only-icon lh-1 text-primary">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="col ps-2 small lh-sm">
                                        <span>1-800-222-000<br />info@domain.com</span>
                                    </div>
                                </div>
                                <div class="d-flex ms-4">
                                    <div class="only-icon only-icon lh-1 text-primary">
                                        <i class="bi bi-map"></i>
                                    </div>
                                    <div class="col ps-2 small lh-sm">
                                        <span>301 The Greenhouse,<br />Custard Factory, LD, E2 8DY</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark py-0 bg-primary z-index-1">
            <div class="container">
                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Home</a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="#" class="nav-link">Pages</a>
                            <label class="px-dropdown-toggle mob-menu"></label>
                            <ul class="dropdown-menu left list-unstyled">
                                <li><a class="dropdown-item" href="about.html">About Us</a></li>
                                <li><a class="dropdown-item" href="services.html">Services</a></li>
                                <li><a class="dropdown-item" href="team.html">Our Team</a></li>
                                <li><a class="dropdown-item" href="pricing.html">Pricing</a></li>
                                <li><a class="dropdown-item" href="contact.html">Contact Us</a></li>
                            </ul>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="#" class="nav-link">Services</a>
                            <label class="px-dropdown-toggle mob-menu"></label>
                            <ul class="dropdown-menu left list-unstyled">
                                <li><a class="dropdown-item" href="services.html">Services</a></li>
                                <li><a class="dropdown-item" href="services-details.html">Services Details</a></li>
                            </ul>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="#" class="nav-link">Blog</a>
                            <label class="px-dropdown-toggle mob-menu"></label>
                            <div class="dropdown-menu left shadow-lg">
                                <a class="dropdown-item" href="blog.html">Blog</a>
                                <a class="dropdown-item" href="blog-single.html">Blog Single</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="contact.html" class="nav-link">
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Menu -->
                <div class="nav flex-nowrap align-items-center d-none d-lg-flex">
                    <!-- Nav Search-->
                    <div class="nav-item">
                        <a class="nav-link pe-0 collapsed display-7 py-0 me-3 text-white" data-bs-toggle="collapse" href="javascript:void(0)" data-bs-target="#search-open" aria-expanded="false">
                            <i class="bi bi-search display-8"> </i>
                        </a>
                    </div>
                    <!-- Nav Button -->
                    <div class="nav-item d-none d-xl-block">
                        <a href="#" class="btn btn-sm btn-light mb-0 mx-2 text-nowrap">Get Quote!</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header End -->
    <!-- Main -->
    <main>
        <!-- Home Banner -->
        <section class="parallax effect-section" style="background-image: url(public/static/img/home-banner.jpg);">
            <div class="mask bg-black opacity-5"></div>
            <div class="container position-relative">
                <div class="row min-vh-65 justify-content-center align-items-center py-6 py-md-12 g-4">
                    <div class="col-lg-6 col-xl-5">
                        <h6 class="text-white">Long-term financial strategies </h6>
                        <h1 class="display-4 pt-3 text-white">Ensure Solvency Through Effective Planning </h1>
                        <div class="pt-2">
                            <a class="btn btn-primary me-1 mb-1" href="#">Explore More</a>
                            <a class="btn btn-light me-1 mb-1" href="#">Contact Now</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-5 col-xxl-4 ms-auto">
                        <div class="card">
                            <div class="card-body p-4 p-lg-5">
                                <div class="text-center">
                                    <h5 class="h3">Plan for life big moments</h5>
                                    <p>Long-term financial strategies </p>
                                </div>
                                <form class="rd-mailform" action="" method="post" data-form-output="form-output-global" data-form-type="contact">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control" id="contact-name" name="name" placeholder="Rachel Roth" required>
                                        <label for="contact-name">Votre nom</label>
                                    </div>
                                    <div class="form-floating mb-4">
                                        <input type="email" class="form-control" id="contact-email" name="email" placeholder="name@example.com" required>
                                        <label for="contact-email">Adresse email</label>
                                    </div>
                                    <div class="form-floating mb-4">
                                        <input type="tel" class="form-control" id="contact-phone" name="phone" placeholder="+01 888 888 6666" required>
                                        <label for="contact-phone">Téléphone</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Obtenez un devis maintenant</button>
                                    <div class="snackbars" id="form-output-global"></div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Home Banner -->
        <!-- Section -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center section-heading">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h3 class="display-6 mb-4 font-w-300">Let's find you the <span class="font-w-700">Best Insurance</span>.</h3>
                        <span class="divider h-3px bg-primary w-60px mx-auto mb-4"></span>
                        <div class="lead">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                    </div>
                </div>
                <div class="row justify-content-center g-4">
                    <div class="col-lg-4">
                        <div class="flip-box shadow rounded">
                            <div class="flip-box-img">
                                <img src="{{asset('public/static/img/about-1.jpg')}}" title="" alt="">
                            </div>
                            <div class="flip-box-content d-flex align-items-center justify-content-center bg-primary">
                                <div class="p-4 text-center text-white">
                                    <div class="icon icon-xl icon-light text-primary mb-4 rounded-circle">
                                        <i class="bi bi-emoji-heart-eyes"></i>
                                    </div>
                                    <span class="w-100 d-block fs-6">User friendly</span>
                                    <h5 class="mb-2">Quick, easy and hassle free</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="flip-box shadow rounded">
                            <div class="flip-box-img">
                                <img src="{{asset('static/img/about-2.jpg')}}" title="" alt="">
                            </div>
                            <div class="flip-box-content d-flex align-items-center justify-content-center bg-primary">
                                <div class="p-4 text-center text-white">
                                    <div class="icon icon-xl icon-light text-primary mb-4 rounded-circle">
                                        <i class="bi bi-droplet-fill"></i>
                                    </div>
                                    <span class="w-100 d-block fs-6">User friendly</span>
                                    <h5 class="mb-2">50+ insurance with lowest rates</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="flip-box shadow rounded">
                            <div class="flip-box-img">
                                <img src="{{asset('static/img/about-3.jpg')}}" title="" alt="">
                            </div>
                            <div class="flip-box-content d-flex align-items-center justify-content-center bg-primary">
                                <div class="p-4 text-center text-white">
                                    <div class="icon icon-xl icon-light text-primary mb-4 rounded-circle">
                                        <i class="bi bi-clipboard-check"></i>
                                    </div>
                                    <span class="w-100 d-block fs-6">User friendly</span>
                                    <h5 class="mb-2">Save up to 40% in our all policy.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section bg-gray-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-xl-5 pe-xl-12 my-3">
                        <h2 class="mb-3 font-w-300">What makes <span class="font-w-700">Policy</span> the best place to buy <span class="font-w-700">insurance</span> in United States?</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <div class="pt-2">
                            <a class="btn btn-primary" href="#">
                                <span class="btn--text">Get started now</span>
                                <span class="bi bi-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-7 my-3">
                        <div class="row g-3">
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-clipboard-check"></i>
                                        </div>
                                        <h5 class="m-0">1.1 Crore + Policy</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-bookmark-check-fill"></i>
                                        </div>
                                        <h5 class="m-0">50+ insurers</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-bicycle"></i>
                                        </div>
                                        <h5 class="m-0">Lowest Price</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-app-indicator"></i>
                                        </div>
                                        <h5 class="m-0">Easy Claims</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-asterisk"></i>
                                        </div>
                                        <h5 class="m-0">1.1 Crore + Policy</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card theme-hover-bg hover-top text-center">
                                    <div class="card-body">
                                        <div class="icon icon-primary border border-2 border-white icon-lg rounded-circle mb-4">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <h5 class="m-0">50+ insurers</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6 my-3 ps-xl-12">
                        <h6 class="text-primary">Where Can We Help You</h6>
                        <h3 class="h1">We're Best Insurance Agent in United States.</h3>
                        <p class="lead">Dome is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</p>
                        <ul class="list-type-01 pt-2">
                            <li>Beautiful and easy to understand UI, professional animations</li>
                            <li>Theme advantages are pixel perfect design &amp; clear code delivered</li>
                            <li>Present your services with flexible, convenient and multipurpose</li>
                            <li>Find more creative ideas for your projects</li>
                            <li>Unlimited power and customization possibilities</li>
                        </ul>
                        <div class="pt-5">
                            <a class="btn btn-primary" href="#">
                                <span class="btn--text">Get started now</span>
                                <span class="bi bi-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 my-3">
                        <img src="{{asset('static/img/about-4.jpg')}}" title="" alt="">
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section bg-gray-100">
            <div class="container">
                <div class="row justify-content-center section-heading">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h3 class="display-6 mb-4 font-w-300">We Provide Best <span class="font-w-700">Insurance Policy</span>.</h3>
                        <span class="divider h-3px bg-primary w-60px mx-auto mb-4"></span>
                        <div class="lead">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-map"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Travel Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Auto Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-person"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Life Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-heart-half"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Health Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-house"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Home Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative hover-top theme-hover-bg">
                            <div class="card-body text-center px-xl-6 py-6">
                                <div class="icon icon-primary icon-xl rounded-circle mb-4 border-white border-2 border">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <h5><a class="stretched-link text-reset" href="#">Business Insurance</a></h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section effect-section parallax" style="background-image: url(public/static/img/bg-banner-1.jpg);">
            <div class="mask bg-black opacity-5"></div>
            <div class="container position-relative">
                <div class="row justify-content-center section-heading">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h3 class="display-6 mb-4 text-white font-w-300">How this <span class="font-w-700">Works?</span></h3>
                        <span class="divider h-3px bg-primary w-60px mx-auto mb-4"></span>
                        <div class="lead text-white">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-3 my-3">
                        <div class="text-center">
                            <div class="icon icon-primary icon-xl rounded-circle mb-4">
                                <span class="fs-2 font-w-600 lh-1">01.</span>
                            </div>
                            <h5 class="text-white m-0">Contact Us</h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 my-3">
                        <div class="text-center">
                            <div class="icon icon-primary icon-xl rounded-circle mb-4">
                                <span class="fs-2 font-w-600 lh-1">02.</span>
                            </div>
                            <h5 class="text-white m-0">Choose Insurance</h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 my-3">
                        <div class="text-center">
                            <div class="icon icon-primary icon-xl rounded-circle mb-4">
                                <span class="fs-2 font-w-600 lh-1">03.</span>
                            </div>
                            <h5 class="text-white m-0">Select Your Agent</h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 my-3">
                        <div class="text-center">
                            <div class="icon icon-primary icon-xl rounded-circle mb-4">
                                <span class="fs-2 font-w-600 lh-1">04.</span>
                            </div>
                            <h5 class="text-white m-0">Contact Agent</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section bg-gray-100">
            <div class="container">
                <div class="row justify-content-center section-heading">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h3 class="display-6 mb-4 font-w-300">Meet <span class="font-w-700">Our Team</span></h3>
                        <span class="divider h-3px bg-primary w-60px mx-auto mb-4"></span>
                        <div class="lead">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-6 col-md-3 my-3">
                        <div class="card hover-top">
                            <img src="{{asset('public/static/img/team-1.jpg')}}" title="" alt="" class="card-img-top">
                            <div class="card-body p-3 text-center">
                                <div class="nav justify-content-center mt-n5 mb-3">
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                                <h6 class="mb-1">Sophia Arthur</h6>
                                <span class="small">HR Manager</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 my-3">
                        <div class="card hover-top">
                            <img src="{{asset('public/static/img/team-2.jpg')}}" title="" alt="" class="card-img-top">
                            <div class="card-body p-3 text-center">
                                <div class="nav justify-content-center mt-n5 mb-3">
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                                <h6 class="mb-1">Sophia Arthur</h6>
                                <span class="small">HR Manager</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 my-3">
                        <div class="card hover-top">
                            <img src="{{asset('public/static/img/team-3.jpg')}}" title="" alt="" class="card-img-top">
                            <div class="card-body p-3 text-center">
                                <div class="nav justify-content-center mt-n5 mb-3">
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                                <h6 class="mb-1">Sophia Arthur</h6>
                                <span class="small">HR Manager</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 my-3">
                        <div class="card hover-top">
                            <img src="{{asset('public/static/img/team-4.jpg')}}" title="" alt="" class="card-img-top">
                            <div class="card-body p-3 text-center">
                                <div class="nav justify-content-center mt-n5 mb-3">
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a class="icon icon-sm icon-primary rounded-circle me-2" href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                                <h6 class="mb-1">Sophia Arthur</h6>
                                <span class="small">HR Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 my-3 pe-lg-6">
                        <span class="bg-warning-light text-warning px-3 py-1 rounded">Rated 4.9 of 5</span>
                        <h3 class="display-6 my-4 font-w-300">What Our <span class="font-w-700">Client Says About Us</span>?</h3>
                        <div class="lead mb-4">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                        <a class="btn btn-primary" href="#">
                            <span class="btn--text">Get Start today</span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-8 my-3">
                        <div class="owl-carousel" data-items="2" data-nav-arrow="false" data-nav-dots="true" data-md-items="2" data-sm-items="2" data-xs-items="1" data-xx-items="1" data-space="0" data-autoplay="true">
                            <div class="card m-3 mb-4">
                                <div class="card-body text-center py-8 px-6">
                                    <div class="avatar avatar-xl overflow-hidden rounded-circle mb-5">
                                        <img src="{{asset('public/static/img/team-1.jpg')}}" title="" alt="">
                                    </div>
                                    <p class="lead">I wanted to hire the best and after looking at several other companies, I knew Jacob was the perfect guy for the job. He is a true professional.</p>
                                    <div class="pt-2">
                                        <h6 class="mb-2 h6">Nancy Bayers</h6>
                                        <p class="m-0 small text-primary">CEO, pxdraft Studio</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-3 mb-4">
                                <div class="card-body text-center py-8 px-6">
                                    <div class="avatar avatar-xl overflow-hidden rounded-circle mb-5">
                                        <img src="{{asset('public/static/img/team-2.jpg')}}" title="" alt="">
                                    </div>
                                    <p class="lead">I wanted to hire the best and after looking at several other companies, I knew Jacob was the perfect guy for the job. He is a true professional.</p>
                                    <div class="pt-2">
                                        <h6 class="mb-2 h6">Nancy Bayers</h6>
                                        <p class="m-0 small text-primary">CEO, pxdraft Studio</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-3 mb-4">
                                <div class="card-body text-center py-8 px-6">
                                    <div class="avatar avatar-xl overflow-hidden rounded-circle mb-5">
                                        <img src="{{asset('publicstatic/img/team-3.jpg')}}" title="" alt="">
                                    </div>
                                    <p class="lead">I wanted to hire the best and after looking at several other companies, I knew Jacob was the perfect guy for the job. He is a true professional.</p>
                                    <div class="pt-2">
                                        <h6 class="mb-2 h6">Nancy Bayers</h6>
                                        <p class="m-0 small text-primary">CEO, pxdraft Studio</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="parallax counter" style="background-image: url(static/img/bg-banner-2.jpg);">
            <div class="container">
                <div class="row min-vh-50 align-items-end pt-8">
                    <div class="col-lg-3 col-6 mt-6">
                        <div class="bg-primary p-4">
                            <div class="media text-white">
                                <div class="only-icon only-icon-lg d-none d-sm-block pe-3">
                                    <i class="icon-desktop"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="count h2 mb-2" data-to="640" data-speed="640">640</h6>
                                    <h5 class="m-0 font-w-500">Live<br /> Projects</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-6">
                        <div class="bg-dark p-4">
                            <div class="media text-white">
                                <div class="only-icon only-icon-lg d-none d-sm-block pe-3">
                                    <i class="icon-camera"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="count h2 mb-2" data-to="890" data-speed="890">890</h6>
                                    <h5 class="m-0 font-w-500">Photo<br /> Capture</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-6">
                        <div class="bg-primary p-4">
                            <div class="media text-white">
                                <div class="only-icon only-icon-lg d-none d-sm-block pe-3">
                                    <i class="icon-laptop"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="count h2 mb-2" data-to="290" data-speed="290">290</h6>
                                    <h5 class="m-0 font-w-500">Projects<br /> Completed</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-6">
                        <div class="bg-dark p-4">
                            <div class="media text-white">
                                <div class="only-icon only-icon-lg d-none d-sm-block pe-3">
                                    <i class="icon-chat"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="count h2 mb-2" data-to="860" data-speed="860">860</h6>
                                    <h5 class="m-0 font-w-500">Happy<br /> Clients</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center section-heading">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h3 class="display-6 mb-4 font-w-300">Read from <span class="font-w-700">the Blog</span>.</h3>
                        <span class="divider h-3px bg-primary w-60px mx-auto mb-4"></span>
                        <div class="lead">Ensure is a HTML5 template based on Sass and Bootstrap 5 with modern and creative multipurpose design you can use it as a startups.</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="card hover-top">
                            <a href="#">
                                <img src="{{asset('public/static/img/blog-1.jpg')}}" class="card-img-top" title="" alt="">
                            </a>
                            <div class="card-body">
                                <p class="mb-2 text-primary font-w-700 small">02 Mar 2019</p>
                                <h5>
                                    <a href="#" class="text-reset stretched-link">
                                        Make your Marketing website
                                    </a>
                                </h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card hover-top">
                            <a href="#">
                                <img src="{{asset('public/static/img/blog-2.jpg')}}" class="card-img-top" title="" alt="">
                            </a>
                            <div class="card-body">
                                <p class="mb-2 text-primary font-w-700 small">02 Mar 2019</p>
                                <h5>
                                    <a href="#" class="text-reset stretched-link">
                                        Make your Marketing website
                                    </a>
                                </h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card hover-top">
                            <a href="#">
                                <img src="{{asset('public/static/img/blog-3.jpg')}}" class="card-img-top" title="" alt="">
                            </a>
                            <div class="card-body">
                                <p class="mb-2 text-primary font-w-700 small">02 Mar 2019</p>
                                <h5>
                                    <a href="#" class="text-reset stretched-link">
                                        Make your Marketing website
                                    </a>
                                </h5>
                                <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Section -->
        <section class="py-5 border-top effect-section parallax" style="background-image: url(static/img/bg-banner-2.jpg);">
            <div class="mask opacity-9 bg-primary"></div>
            <div class="container position-relative text-white">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-center text-lg-start my-3">
                        <h4 class="h2 mb-2">Get An Insurance & Save up to 10%</h4>
                        <p class="m-0 small w-lg-80">Ensure is a HTML5 template based on Sass and Bootstrap 5.</p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end my-3">
                        <a class="btn-light btn shadow" href="#">
                            <i class="bi bi-check-all"></i>
                            <span class="btn--text">
                                Create your website
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
    </main>
    <!-- End Main -->
    <!-- Footer -->
    <footer class="bg-dark-gradient footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 my-4">
                        <div class="mb-5">
                            <img src="{{asset('public/static/img/logo-light.svg')}}" title="" alt="">
                        </div>
                        <ul class="list-unstyled white-link">
                            <li class="pb-3">
                                <a href="#" class="media">
                                    <div class="icon icon-primary icon-sm rounded-circle">
                                        <i class="fs-6 lh-1 bi bi-map"></i>
                                    </div>
                                    <span class="media-body ps-3">
                                        301 The Greenhouse, <br>Custard Factory, LD, E2 8DY
                                    </span>
                                </a>
                            </li>
                            <li class="pb-3">
                                <a href="#" class="media align-items-center">
                                    <div class="icon icon-primary icon-sm rounded-circle">
                                        <i class="fs-6 lh-1 bi bi-envelope"></i>
                                    </div>
                                    <span class="media-body ps-3">
                                        info@domain.com
                                    </span>
                                </a>
                            </li>
                            <li class="pb-3">
                                <a href="#" class="media align-items-center">
                                    <div class="icon icon-primary icon-sm rounded-circle">
                                        <i class="fs-6 lh-1 bi bi-phone"></i>
                                    </div>
                                    <span class="media-body ps-3">
                                        1-800-222-000
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-2 my-4">
                        <h5 class="text-white h6 mb-4">Our Services</h5>
                        <ul class="list-unstyled white-link footer-links">
                            <li>
                                <a href="#">Life Insurance</a>
                            </li>
                            <li>
                                <a href="#">Car Insurance</a>
                            </li>
                            <li>
                                <a href="#">Travel Insurance</a>
                            </li>
                            <li>
                                <a href="#">House Insurance</a>
                            </li>
                            <li>
                                <a href="#">Vehicle Insurance</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-2 my-4">
                        <h5 class="text-white h6 mb-4">Additional Links</h5>
                        <ul class="list-unstyled white-link footer-links">
                            <li>
                                <a href="#">Our Company</a>
                            </li>
                            <li>
                                <a href="#">Our Team</a>
                            </li>
                            <li>
                                <a href="#">Our Partners</a>
                            </li>
                            <li>
                                <a href="#">Careers</a>
                            </li>
                            <li>
                                <a href="#">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-2 my-4">
                        <h5 class="text-white h6 mb-4">Company</h5>
                        <ul class="list-unstyled white-link footer-links">
                            <li>
                                <a href="#">Apps Store</a>
                            </li>
                            <li>
                                <a href="#">Google Store</a>
                            </li>
                            <li>
                                <a href="#">Latest News</a>
                            </li>
                            <li>
                                <a href="#">Our Blog</a>
                            </li>
                            <li>
                                <a href="#">Help center</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-3 my-4">
                        <h5 class="text-white h6 mb-5">Stay up to date</h5>
                        <form>
                            <div class="d-flex flex-column flex-md-row mb-2">
                                <input type="email" class="form-control me-md-2 mb-2 mb-md-0" placeholder="Enter your username">
                                <button class="btn btn-primary flex-shrink-0" type="submit">Send</button>
                            </div>
                            <p class="text-white-50 m-0">New UI kits or big discounts. Never spam.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom border-style top light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div class="nav justify-content-center justify-content-md-start white-link">
                            <a class="fs-6 me-4" href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="fs-6 me-4" href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="fs-6 me-4" href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a class="fs-6 me-4" href="#">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 my-3 text-center text-md-end text-white-50">
                        <p class="m-0">© 2021 copyright <a href="pxdraft.com" class="text-reset">pxdraft</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <!-- jquery -->
    <script src="{{asset('static/vendor/jquery/jquery-3.5.1.min')}}"></script>
    <!-- appear -->
    <script src="{{asset('public/static/vendor/appear/jquery.appear.js')}}"></script>
    <!--bootstrap-->
    <script src="{{asset('public/static/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- countTo -->
    <script src="{{asset('public/static/vendor/counter/jquery.countTo.js')}}"></script>
    <!-- owl-carousel -->
    <script src="{{asset('public/static/vendor/owl-carousel/js/owl.carousel.min.js')}}"></script>
    <!-- magnific -->
    <script src="{{asset('public/static/vendor/magnific/jquery.magnific-popup.min')}}"></script>
    <!-- jarallax -->
    <script src="{{asset('public/static/vendor/jarallax/jarallax.min.js')}}"></script>
    <!-- working form -->
    <script src="{{asset('public/static/vendor/mail/js/validate.min.js')}}"></script>
    <script src="{{asset('public/static/vendor/mail/js/contact.min.js')}}"></script>
    <!-- Theme Js -->
    <script src="{{asset('public/static/js/custom.js')}}"></script>
</body>
<!-- end body -->

</html>