@extends('layouts.master')
@section('content')
    <!--=====================
    banner part start
    ======================-->
    <section id="banner-part" style="padding-bottom: 0px;">
        <!-- container start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="text">
                        <!-- big text -->
                        <h1>
                            Enjoy Up to 33% Discount With <span>CIT</span>
                            <span class="d-block">Prestige Card</span>
                        </h1>
                        <!-- mini text -->
                        <p class="text-justify">
                            Take advantage of the incredible Prestige Card powered by Creative IT Institute. Prestige Card holders can avail exclusive discounts from 100+ prominent brands. So unlock the exciting surprises !!
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="img" style="margin-top: -50px;">
                        <img src="{{asset('assets/images/banner-img.webp')}}" alt="banner-img" style="width: 50%;">
                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <!-- selection start -->
                    <form class="" method="post" action="{{ url('/search') }}">
                        @csrf
                        <div class="select-part">
                            <select name="category" id="category">
                                <option value="0">Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <select name="brand" id="brand">
                                <option value="0">Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <select name="location" id="location">
                                <option value="0">Location</option>
                                @foreach ($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                                @endforeach
                            </select>
                            <!-- **** -->
                            <button type="submit" id="searchBtn">
                                <span class="button__text">Search</span>
                            </button>
                        </div>
                    </form>
                    <!-- selection end -->
                </div> --}}
            </div>
        </div>
        <!-- container end -->
    </section>
    <!--=====================
        banner part end 
    ======================-->

    <!--=====================
        brand part start
    ======================-->
    <section id="brand-part">
        <!-- container start -->
        <div class="container">
            <!-- header -->
            <div class="header">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ol>
                </div>
                <h4>Your Search Results</h4>
            </div>
            <!-- buttons start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="buttons d-flex justify-content-center">
                        <button class="button" data-filter=".{{str_replace(' ', '-', $category->name)}}" style="background: #ff0d00;color: #fff;border: 1px solid #ff0d00;">{{$category->name}}</button>
                    </div>
                </div>
            </div>
            <!-- buttons end -->
            <div class="items justify-content-around">
                @if (count($offers))
                    @foreach ($offers as $offer)
                        {{-- <div>{{$offer}}</div> --}}
                        <div class="mix-item mix {{str_replace(' ', '-', $offer->category->name)}}">
                            <div class="img"><img class="lozad" data-src="{{$offer->logo}}" alt="{{$offer->brand->name}}" /></div>
                            <div class="text">
                                <h5>{{$offer->discount}}% off</h5>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal{{$offer->id}}">View Details</a>
                            </div>
                        </div>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal{{$offer->id}}">
                            <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h5 class="text-center mb-3 font-weight-bold">{{$offer->category->name}}</h5>
                                    <div class="img text-center">
                                        <img class="lozad" data-src="{{$offer->logo}}" alt="{{$offer->brand->name}}" height="150px"/>
                                    </div>
                                    <h2 class="text-center text-danger py-3"><strong>Discount</strong>&nbsp;{{$offer->discount}}%</h2>
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
                @else
                    <h2>No data found</h2>
                @endif
                @if (empty($offer))
                @endif
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
                        <p>CIT Prestige Card is an advantage card specially for our respected alumni, students, employees and members of CIT family. You will get all in one place starting from ride sharing, restaurants, lifestyle brands to resorts, airlines,
                            hospitals and such. And with the passage of time many more interesting offers will be added to this platform.
                        </p>
                        <div class="bottom mt-5">
                            <div class="row bottom-item">
                                <div class="col-lg-2 col-sm-3 col-md-3">
                                    <div class="img light">
                                        <img class="lozad" data-src="{{asset('assets/images/light.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-9 col-md-9">
                                    <div class="detail">
                                        <h5>Unlimited Uses</h5>
                                        <p>CIT brings a plan with everything that matters. Experience unlimited freedom with the best possible products and services available. Exclusively for you!.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom-item mt-4">
                                <div class="col-lg-2 col-sm-3 col-md-3">
                                    <div class="img support light">
                                        <img class="lozad" data-src="{{asset('assets/images/support.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-9 col-md-9">
                                    <div class="detail">
                                        <h5>Instant Support</h5>
                                        <p>Show your card & avail instant support from anywhere, anytime. We have a commitment to serve you best.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-12 col-md-12">
                    <div class="img item">
                        <img class="lozad" data-src="{{asset('assets/images/about-img.png')}}" alt="">
                        <a class="my-video-links" data-autoplay="true" data-vbtype="video" href="https://youtu.be/pfVODjDBFxU"><i
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