@extends('header')
@section('title', 'A propos')

@section('content')
    <main>
        <section class="slider">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="banner-content">
                            <h1>Agence de Sécurité <span>et de gardiennage</span></h1>
                            <ol>
                                <li><a href="#">Learn More</a></li>
                                <li><a href="#">Get In Touch</a></li>
                            </ol>
                        </div>
                    <img class="d-block w-100" src="{{asset('asset/images/banner/slider-01.jpg')}}">
                    </div>
                    <div class="carousel-item">
                        <div class="banner-content">
                            <h1>Nous sommes une équipe <span>d'expert pour vous servir !</span></h1>
                            <ol>
                                <li><a href="#">Learn More</a></li>
                                <li><a href="#">Get In Touch</a></li>
                            </ol>
                        </div>
                    <img class="d-block w-100" src="{{asset('asset/images/banner/slider-02.jpg')}}">
                    </div>
                    <div class="carousel-item">
                        <div class="banner-content">
                            <h1>Nous assurons votre sécurité <span>et celle de vos sites</span></h1>
                            <ol>
                                <li><a href="#">Learn More</a></li>
                                <li><a href="#">Get In Touch</a></li>
                            </ol>
                        </div>
                    <img class="d-block w-100" src="{{asset('asset/images/banner/slider-03.jpg')}}">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-01">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <span>Nos services</span>
                            <h2>Des solutions uniques et adaptées à vos besoins</h2>
                            <p>Notre agence de sécurité se distingue par un engagement inébranlable envers la protection de vos biens et de vos proches.
                                Forts de nombreuses années d'expérience dans le secteur, 
                                nos professionnels hautement qualifiés sont formés pour anticiper et neutraliser les menaces potentielles. 
                                Grâce à des solutions sur mesure adaptées à vos besoins spécifiques, nous assurons une présence rassurante et efficace, 
                                que ce soit pour des événements privés, la sécurité résidentielle ou la protection des entreprises.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="wrapper">
                            <div class="icons">
                                <i class="flaticon-data-driven"></i>
                            </div>
                            <div class="content w-100">
                                <h4>Data Analytics</h4>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et velit, 
                                ullam distinctio hic possimus assumenda pariatur, ab non maxime officiis 
                                fugit! Numquam debitis odio odit quisquam maiores quidem magnam dicta.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="wrapper">
                            <div class="icons">
                                <i class="flaticon-money"></i>
                            </div>
                            <div class="content w-100">
                                <h4>Revenue Growth</h4>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et velit, 
                                ullam distinctio hic possimus assumenda pariatur, ab non maxime officiis 
                                fugit! Numquam debitis odio odit quisquam maiores quidem magnam dicta.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="wrapper">
                            <div class="icons">
                                <i class="flaticon-computer"></i>
                            </div>
                            <div class="content w-100">
                                <h4>Market Expansion</h4>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et velit, 
                                ullam distinctio hic possimus assumenda pariatur, ab non maxime officiis 
                                fugit! Numquam debitis odio odit quisquam maiores quidem magnam dicta.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-02">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image">
                            <img src="{{asset('asset/images/abt-img/1000-1000.jpg')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="heading">
                            <span>How i work</span>
                            <h2>find a new competitive edge</h2>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                            Laudantium officia doloremque praesentium ullam odio eaque ab 
                            consectetur voluptas vel nostrum doloribus</p>
                        </div>

                        <div class="wrapper">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="icon">
                                        <i class="flaticon-archer"></i>
                                        <h4>15</h4>
                                        <h5>years of experience</h5>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="icon">
                                        <i class="flaticon-customer-satisfaction"></i>
                                        <h4>255</h4>
                                        <h5>truster clients</h5>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="icon">
                                        <i class="flaticon-video-call"></i>
                                        <h4>20</h4>
                                        <h5>visited Conferences</h5>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="icon">
                                        <i class="flaticon-medal"></i>
                                        <h4>40</h4>
                                        <h5>master certifications</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-03">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <span>Services</span>
                            <h2>We position our clients at the forefront of their field 
                            by advancing an agenda.</h2>
                            <p>Easily apply to multiple jobs with one click! Quick Apply shows you 
                            recommended jobs based off your most recent search and allows you to 
                            apply to 25+ jobs in a matter of seconds!</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-flowchart"></i>
                                <h4>Sécurité Humaine</h4>
                                <p> We develop the relationships that underpin the next phase in your 
                                organisation’s growth. We do this</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-coding"></i>
                                <h4>Program management</h4>
                                <p>The development of your next business plan will be executed by 
                                a brilliant team who will indicate your grand success.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-chess-pieces"></i>
                                <h4>Strategy</h4>
                                <p>The development of your next business plan will be executed by 
                                a brilliant team who will indicate your grand success.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-research"></i>
                                <h4>chart management</h4>
                                <p>The development of your next business plan will be executed by 
                                a brilliant team who will indicate your grand success.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-optimization"></i>
                                <h4>SEO Optimization</h4>
                                <p>The development of your next business plan will be executed by 
                                a brilliant team who will indicate your grand success.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="content">
                                <i class="flaticon-market-research"></i>
                                <h4>Market Research</h4>
                                <p>The development of your next business plan will be executed by 
                                a brilliant team who will indicate your grand success.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-04">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <h2>Flexible Plans For <br> Small To Fast-Growing Company.</h2>
                            <p>Switch to annual plan and get 25% offer.</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="head-content">
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <h4>Basic Blan</h4>
                                    <h5>$20.00 <span>/ mo</span></h5>
                                </div>
                            </div>
                            <div class="inner-content">
                                <div class="list-content">
                                    <h5>Most Recommended</h5>
                                </div>
                                <h6>Power of choice is untrammelled and do what we like best.</h6>
                                <ol>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>4-5 Weeks from to finish</li>
                                    <li><i class="fal fa-arrow-circle-right"></i>Data sprint</li>
                                    <li><i class="fal fa-arrow-circle-right"></i>Results revision</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>20 Days of support</li>
                                </ol>
                                <a href="#">Get Started a free trail</a>
                                <p>no credit card required</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="head-content">
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <h4>for Large Business</h4>
                                    <h5>$30.00 <span>/ mo</span></h5>
                                </div>
                            </div>
                            <div class="inner-content">
                                <div class="list-content">
                                    <h5 class="active-plan">Most Recommended</h5>
                                </div>
                                <h6>Power of choice is untrammelled and do what we like best.</h6>
                                <ol>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>4-5 Weeks from to finish</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>Data sprint</li>
                                    <li><i class="fal fa-arrow-circle-right"></i>Results revision</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>20 Days of support</li>
                                </ol>
                                <a class="active-a" href="#">Get Started a free trail</a>
                                <p>no credit card required</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="wrapper">
                            <div class="head-content">
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <h4>Advanced Pack</h4>
                                    <h5>$50.00 <span>/ mo</span></h5>
                                </div>
                            </div>
                            <div class="inner-content">
                                <div class="list-content">
                                    <h5>Most Recommended</h5>
                                </div>
                                <h6>Power of choice is untrammelled and do what we like best.</h6>
                                <ol>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>4-5 Weeks from to finish</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>Data sprint</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>Results revision</li>
                                    <li class="se-color"><i class="fal fa-check-circle"></i>20 Days of support</li>
                                </ol>
                                <a href="#">Get Started a free trail</a>
                                <p>no credit card required</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="textimonial-client">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <h2><span>Success</span> stories</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="wrapper">
                            <div id="custCarousel-02" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="content">
                                            <h3>Anliee Albert</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae aspernatur 
                                            libero hic? Ad aut veritatis eaque totam, architecto inventore nulla 
                                            asperiores eum consequatur cum? Amet ab excepturi pariatur. Quas, adipisci.</p>
                                            <a><img src="{{asset('asset/images/team/1.jpg')}}"></a>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="content">
                                            <h3>Anliee Albert</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae aspernatur 
                                            libero hic? Ad aut veritatis eaque totam, architecto inventore nulla 
                                            asperiores eum consequatur cum? Amet ab excepturi pariatur. Quas, adipisci.</p>
                                            <a><img src="{{asset('asset/images/team/2.jpg')}}"></a>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="content">
                                            <h3>Anliee Albert</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae aspernatur 
                                            libero hic? Ad aut veritatis eaque totam, architecto inventore nulla 
                                            asperiores eum consequatur cum? Amet ab excepturi pariatur. Quas, adipisci.</p>
                                            <a><img src="{{asset('asset/images/team/2.jpg')}}"></a>
                                        </div>
                                    </div>
                                </div>
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-05">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <h2>Notre Équipe</h2>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="team-wrapper">
                            <div class="team-img">
                                <img src="{{asset('asset/images/team/1.jpg')}}">
                            </div>
                            <div class="team-content">
                                <h3>James</h3>
                                <p>Designer</p>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="team-wrapper">
                            <div class="team-img">
                                <img src="{{asset('asset/images/team/3.jpg')}}">
                            </div>
                            <div class="team-content">
                                <h3>Albert</h3>
                                <p>Art Designer</p>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="team-wrapper">
                            <div class="team-img">
                                <img src="{{asset('asset/images/team/2.jpg')}}">
                            </div>
                            <div class="team-content">
                                <h3>Johns</h3>
                                <p>SEO</p>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="team-wrapper">
                            <div class="team-img">
                                <img src="{{asset('asset/images/team/4.jpg')}}">
                            </div>
                            <div class="team-content">
                                <h3>Smith</h3>
                                <p>Developer</p>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-06">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <h2>Our News</h2>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <article class="blog-sub">
                            <div class="blog-content">
                                <img src="{{asset('asset/images/blog/1.jpg')}}">
                            </div>
                            <div class="blog-content-section">
                                <div class="blo-content-title">
                                    <h4>The National Minimum Wage Is An Important Part</h4>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Neque at numquam, asperiores aut
                                        praesentium
                                        facilis ratione! Voluptatibus neque dignissimos ipsa atque veniam sint omnis in blanditiis, nemo
                                        fugit
                                        animi assumenda.</p>
                                </div>
                                <div class="blog-admin">
                                    <ol>
                                        <li><i class="fal fa-user-tie"></i> By Admin</li>
                                        <li><i class="fal fa-calendar-alt"></i> july 28, 2020</li>
                                    </ol>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <article class="blog-sub">
                            <div class="blog-content">
                                <img src="{{asset('asset/images/blog/2.jpg')}}">
                            </div>
                            <div class="blog-content-section">
                                <div class="blo-content-title">
                                    <h4>The National Minimum Wage Is An Important Part</h4>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Neque at numquam, asperiores aut
                                        praesentium
                                        facilis ratione! Voluptatibus neque dignissimos ipsa atque veniam sint omnis in blanditiis, nemo
                                        fugit
                                        animi assumenda.</p>
                                </div>
                                <div class="blog-admin">
                                    <ol>
                                        <li><i class="fal fa-user-tie"></i> By Admin</li>
                                        <li><i class="fal fa-calendar-alt"></i> july 28, 2020</li>
                                    </ol>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <article class="blog-sub">
                            <div class="blog-content">
                                <img src="{{asset('asset/images/blog/3.jpg')}}">
                            </div>
                            <div class="blog-content-section">
                                <div class="blo-content-title">
                                    <h4>The National Minimum Wage Is An Important Part</h4>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Neque at numquam, asperiores aut
                                        praesentium
                                        facilis ratione! Voluptatibus neque dignissimos ipsa atque veniam sint omnis in blanditiis, nemo
                                        fugit
                                        animi assumenda.</p>
                                </div>
                                <div class="blog-admin">
                                    <ol>
                                        <li><i class="fal fa-user-tie"></i> By Admin</li>
                                        <li><i class="fal fa-calendar-alt"></i> july 28, 2020</li>
                                    </ol>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
    
