<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Creative IT Prestige Card</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <!-- css link start -->
        {{-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" /> --}}
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/css/venobox.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/slick.css')}}">
        {{-- <link rel="stylesheet" href="{{asset('assets/css/all.css ')}}"/> --}}
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}"/>
        <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
        <!-- css link end -->
        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> --}}
    </head>
    <body>
        <!--=====================
         nav bar part start
        ======================-->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- img start -->
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{asset('assets/images/top-logo.png')}}" alt="logo" />
                </a>
                <!-- img end -->
                <!-- button -->
                <div class="button">
                    <a href="#selection-part"><i class="fas fa-search"></i>&nbsp;Search</a>
                </div>
            </div>
            <!-- nav item start -->
        </nav>
        <!--=====================
            nav bar part end
        ======================-->

        <main>
            @yield("content")
        </main>

        <!--=====================
            review part start 
        ======================-->
        <section id="review-part">
            <!-- container start -->
            <div class="container">
                <!-- header -->
                <div class="header">
                    <h4>Users' Feedback</h4>
                    <p>
                        We are honored & surprised to have such responses.
                    </p>
                </div>
                <!-- sliders start -->
                <div class="row sliders">
                    <div class="col-lg-5 col-sm-12">
                        <div class="left">
                            <div class="mini"><img class="lozad" data-src="{{asset('assets/images/mini1.png')}}" alt=""></div>
                            <div class="mini mini2"><img class="lozad" data-src="{{asset('assets/images/mini2.png')}}" alt=""></div>
                            <div class="mini mini3"><img class="lozad" data-src="{{asset('assets/images/mini3.png')}}" alt=""></div>
                            <div class="mini mini4"><img class="lozad" data-src="{{asset('assets/images/mini4.png')}}" alt=""></div>
                            <div class="img-slider">
                                <div class="img">
                                    <img class="mx-auto lozad" data-src="{{asset('assets/images/slider-img.png')}}" alt="">
                                </div>
                                <div class="img">
                                    <img class="mx-auto lozad" data-src="{{asset('assets/images/slider-img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                    <!-- **** -->
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="text-slider">
                            <div class="text">
                                <div class="icons">
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                </div>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.</p>
                                <h6>@Awlad Hossain</h6>
                                <p style="margin-top: 10px;">UI Designer</p>
                            </div>
                            <div class="text">
                                <div class="icons">
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                </div>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.</p>
                                <h6>@Awlad Hossain</h6>
                                <p style="margin-top: 10px;">UI Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sliders end -->
            </div>
            <!-- container end -->
        </section>
        <!--=====================
            review part end 
        ======================-->

        <!--=====================
            question part start
        ======================-->
        <section id="question-part">
            <!-- container start -->
            <div class="container">
                <!-- header -->
                <div class="header">
                    <h4>Frequently Asked Questions</h4>
                    <p>
                        Here are some effective FAQ resources that can guide you to understand our services better. Our FAQ gets updated based on new data insights thinking your comfort in mind.
                    </p>
                </div>
                <!-- accordion start -->
                <div class="row mt-5">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h5>How can I get CIT Prestige Card?</h5>
                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>To get the card, you must come to the head office of Creative IT Institute. At the admission office you will be asked to fill out a form. You will receive the card as soon as you complete the form.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h5>What are the necessary documents required for the card?</h5>
                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>2 copy passport size photograph</p>
                                        <p>Photocopy of NID</p>
                                        <p>Student information (Batch No, Subject, Passing year)</p>
                                        <p>Employee information (Department, Position, Date of Joining, Status)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <h5>How long will it take for me to receive my new Card?</h5>
                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>You will receive the card as soon as you complete the form but the card will be active after 7 days.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <h5>Is there any additional payment for the card?</h5>
                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>No, you don't have to pay any amount for the card.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <h5>How can I activate my card?</h5>
                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>The card will automatically activate after 7 days of receiving. After activating, you will get one sms as confirmation of the card.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    <h5>What should I do If I lose my card?</h5>
                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>If you lose the card you should inform CIT about the matter as soon as possible. We will deactivate the card and give you another one with a charge of 500 taka.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
                <!-- accordion end -->
            </div>
            <!-- container end -->
        </section>
        <!--=====================
            question part end 
        ======================-->


        <!--=====================
            inbox part start 
        ======================-->
        <section id="inbox-part">
            <!--container start  -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text">
                            <h4>Get Our Updates In Your Inbox</h4>
                            <p>Don’t want to miss a post? Sign Up to get all the latest tips and trends from Property Next Delivered right to you.</p>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5">
                        <form class="" method="post" action="{{ url('/subscribe') }}">
                            @csrf
                            <input name="email" type="text" placeholder="Enter your email" required>
                            <input type="hidden" id="subscriberIP" name="subscriberIP" value="" />
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
            <!--container end  -->
        </section>
        <!--=====================
            inbox part end 
        ======================-->


        <!--=====================
            footer part start 
        ======================-->
        <section id="footer-part">
            <!-- container start -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="left">
                            <div class="logo">
                                <img class="lozad" data-src="{{asset('assets/images/Frame.png')}}" alt="">
                            </div>
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                            <div class="icons mt-4">
                                <a href="#" style="color: #1877F2;"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" style="color: #1DA1F2;"><i class="fab fa-twitter"></i></a>
                                <a href="#" style="color: #CD201F;"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="links">
                            <h5>Location</h5>
                            <ul>
                                <li><a href="#">Dhaka</a></li>
                                <li><a href="#">Chittagong</a></li>
                                <li><a href="#">Shylet</a></li>
                                <li><a href="#">Barisal</a></li>
                                <li><a href="#">Khulna</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2 big">
                        <div class="links">
                            <h5 style="margin-left: -22px">Pages</h5>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Career</a></li>
                                <li><a href="#">Term & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2 big">
                        <div class="links">
                            <h5 style="margin-left: -22px">Service</h5>
                            <ul>
                                <li><a href="#">Brands</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mid">
                            <div class="links">
                                <h5 style="margin-left: -22px">Pages</h5>
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Career</a></li>
                                    <li><a href="#">Term & Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mid">
                            <div class="links">
                                <h5 style="margin-left: -22px">Service</h5>
                                <ul>
                                    <li><a href="#">Brands</a></li>
                                    <li><a href="#">FAQs</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container end -->
        </section>
        <!--=====================
            footer part end 
        ======================-->
        <!-- js link start -->
        <script src="{{asset('assets/js/jquery-1.12.4.min.js')}}"></script>
        {{-- <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script> --}}
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('assets/js/mixitup.min.js')}}"></script>
        <script src="{{asset('assets/js/slick.min.js')}}"></script>
        <script src="{{asset('assets/js/venobox.min.js')}}"></script>
        {{-- <script src="{{asset('assets/js/all.js')}}"></script> --}}
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script src="{{asset('assets/js/website_loader.min.js')}}"></script>
        <script type="text/javascript">const observer = lozad();observer.observe();</script>
        <!-- js link end -->
    </body>
</html>
