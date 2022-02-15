@extends('layouts.master')
@section('content')
    <!--=====================
    banner part start
    ======================-->
    <section id="banner-part">
        <!-- container start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="text">
                        <!-- big text -->
                        @if (session('success_message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                {{session('success_message')}}
                            </div>
                        @endif
                        {{-- Successful Message Alert with close and fade effect from controller --}}
                        @if (session('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                {{session('error_message')}}
                            </div>
                        @endif
                        <h1>
                            Enjoy Exclusive Discount With<span class="d-block">CIT Prestige Card</span>
                        </h1>
                        <!-- mini text -->
                        <p class="text-justify">
                            Take advantage of the incredible Prestige Card powered by Creative IT Institute. "Prestige Card holders can avail exclusive discounts from prominent brands connected with creative IT institute"
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="img">
                        <img src="{{asset('assets/images/banner-img.webp')}}" alt="banner-img">
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- selection start -->
                    <form class="" method="post" action="{{ url('/search') }}">
                        @csrf
                        <div class="select-part">
                            <select name="category" id="searchByCategory" required>
                                <option value="">Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <select name="brand" id="searchBrands">
                                <option value="">Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <select name="location" id="location">
                                <option value="">Location</option>
                                @foreach ($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <button type="submit" id="searchBtn">
                                <i class="fas fa-search"></i>&nbsp;Search
                            </button>
                        </div>
                    </form>
                    <!-- selection end -->
                </div>
            </div>
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        banner part end 
    ======================-->

    <!--=====================
        selection part start
    ======================-->
    <section id="selection-part">
        <!-- container start -->
        <div class="container">
            <!-- success part start -->
            <div class="success-part">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="item">
                            <p>Our Success</p>
                            <h3>
                                West cost Brand
                                <span class="d-block">makers-Global Edge</span>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-2 big">
                        <div class="item">
                            <h2>10K+</h2>
                            <h6>Happy Customers</h6>
                            <div class="img">
                                <img class="lozad" data-src="{{asset('assets/images/group-img.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2 big">
                        <div class="item">
                            <h2>305+</h2>
                            <h6>Brand</h6>
                            <div class="icon">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2 big">
                        <div class="item">
                            <h2>30+</h2>
                            <h6>Categories</h6>
                            <a href="#">See Categories</a>
                        </div>
                    </div>
                </div>
                <div class="row mid">
                    <div class="col-md-4">
                        <div class="item">
                            <h2>10K+</h2>
                            <h6>Happy Customers</h6>
                            <div class="img">
                                <img class="lozad" data-src="{{asset('assets/images/group-img.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item">
                            <h2>305+</h2>
                            <h6>Brand</h6>
                            <div class="icon">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item">
                            <h2>30+</h2>
                            <h6>Categories</h6>
                            <a href="#">See Categories</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- success part end -->
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        selection part end 
    ======================-->

    <!--=====================
        discount part start 
    ======================-->
    <section id="discount-part">
        <!-- container start -->
        <div class="container">
            <!-- header -->
            <div class="header">
                <h4>Discount Avail Process</h4>
            </div>
            <!-- discount item start -->
            <div class="discount-item">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="inner-item">
                            <div class="text">
                                <h4>Select Your Brand</h4>
                                <p>
                                    We have implemented Exclusive offers with prominent brands only for youFirstly you have to choose your favorite required brand.
                                </p>
                            </div>
                            <div class="img">
                                <img class="lozad" data-src="{{asset('assets/images/dis1.png')}}" alt="dis1">
                            </div>
                            <h5>Step 01</h5>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="inner-item">
                            <h5 style="color: #00B59A;">Step 02</h5>
                            <div class="img">
                                <img class="lozad" data-src="{{asset('assets/images/dis2.png')}}" alt="" />
                            </div>
                            <div class="text">
                                <h4>Use Your Prestige Card</h4>
                                <p>
                                    Show your card at the outlet they will verify & you will get an instant discount. In terms of online facilities, you will get the instant service by using the CITian’s Exclusive promo code.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="inner-item inner-mid">
                            <div class="text">
                                <h4>Enjoy your Rewards</h4>
                                <p>
                                    From shopping and entertainment to travel we have brought new offers in different sectors. So, use your prestige card today & make the most of your experience.
                                </p>
                            </div>
                            <div class="img">
                                <img class="lozad" data-src="{{asset('assets/images/dis3.png')}}" alt="" />
                            </div>
                            <h5 style="color: #FF3654;">Step 03</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- discount item end -->
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        discount part end 
    ======================-->

    <!--=====================
        brand part start
    ======================-->
    <section id="brand-part">
        <!-- container start -->
        <div class="container">
            <!-- header -->
            <div class="header">
                <h4>Your Desired Brands</h4>
                <p>
                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.
                </p>
            </div>
            <!-- buttons start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="buttons d-flex justify-content-between">
                        <button class="button" data-filter="all">All</button>
                        @foreach ($categories as $category)
                            <button class="button" data-filter=".{{str_replace(' ', '-', $category->name)}}">{{$category->name}}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- buttons end -->
            <div class="items">
                @foreach ($offers as $offer)
                    {{-- <div>{{$offer}}</div> --}}
                    <div class="mix-item mix {{str_replace(' ', '-', $offer->category->name)}}">
                        <div class="img"><img class="lozad" data-src="{{$offer->logo}}" alt="{{$offer->brand->name}}" /></div>
                        <div class="text">
                            @if ($offer->discount!="")
                                <h5>{{$offer->discount}}% off</h5>
                            @endif
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal{{$offer->id}}">View Details</a>
                        </div>
                    </div>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal{{$offer->id}}">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h5 class="text-center mb-3 font-weight-bold">{{$offer->category->name}}</h5>
                                <div class="img text-center">
                                    <img class="lozad" data-src="{{$offer->logo}}" alt="{{$offer->brand->name}}" height="150px"/>
                                </div>
                                @if ($offer->discount!="")
                                    <h2 class="text-center text-danger py-3"><strong>Discount</strong>&nbsp;{{$offer->discount}}%</h2>
                                @endif
                                <h4 class="mb-3"><span style="border-bottom: 2px solid black">Availing Process:</span></h4>
                                {!! $offer->description !!}
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        brand part end
    ======================-->


    <!--=====================
        about part start
    ======================-->
    <section id="about-part">
        <!-- container start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-12 col-md-12">
                    <div class="text item">
                        <!-- header -->
                        <div class="header">
                            <h4 class="text-start">About Prestige Card</h4>
                        </div>
                        <p>
                            CIT Prestige Card is an advantage card specially for our respected alumni, students, employees and members of CIT family. You will get all in one place starting from ride sharing, restaurants, lifestyle brands to resorts, airlines, hospitals and such. And with the passage of time many more interesting offers will be added to this platform.
                        </p>
                        <div class="bottom mt-5">
                            <div class="row bottom-item">
                                <div class="col-lg-2 col-sm-3 col-md-3">
                                    <div class="img light">
                                        <img src="{{asset('assets/images/light.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-9 col-md-9">
                                    <div class="detail">
                                        <h5>Unlimited Uses</h5>
                                        <p>
                                            CIT brings a plan with everything that matters. Experience unlimited freedom with the best possible products and services available. Exclusively for you!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom-item mt-4">
                                <div class="col-lg-2 col-sm-3 col-md-3">
                                    <div class="img support light">
                                        <img src="{{asset('assets/images/support.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-9 col-md-9">
                                    <div class="detail">
                                        <h5>Instant Support</h5>
                                        <p>
                                            Show your card & avail instant support from anywhere, anytime. We have a commitment to serve you best.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-12 col-md-12">
                    <div class="img item">
                        <img class="lozad" data-src="{{asset('assets/images/about-img.png')}}" alt="">
                        <a class="my-video-links" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/watch?v=ei-WEg87z_g"><i
                class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        about part end 
    ======================-->
@endsection