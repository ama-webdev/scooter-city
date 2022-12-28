@extends('layouts.user-layout')
@section('style')
    <style>
        nav.navbar {
            background: #40C1AB !important;
        }

        .title {
            font-size: 4rem;
            font-weight: 400;
        }

        header {
            min-height: calc(100vh - 56px);
            background: url('assets/img/banner.jpg');
            background-size: cover;
            background-position: center
        }

        .rent-btn {
            text-decoration: none;
            padding: .75rem 2.5rem;
            color: #333;
            background: white;
            border-radius: .2rem;
            text-transform: uppercase;
            font-weight: 500;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 3rem;
        }

        .htr {
            background: #f2f2f2;
        }

        .rent {
            display: flex;
            margin-bottom: 1rem;
        }

        .rent h4 {
            text-transform: uppercase;
            font-weight: 700;
        }

        .rent i {
            width: 100px;
        }

        footer {
            height: 100px;
            text-align: center;
            font-weight: bold;
            line-height: 100px;
        }

        @media(max-width:768px) {
            .title {
                font-size: 3rem;
                padding-top: 5rem;
            }
        }
    </style>
@endsection
@section('content')
    <header>
        <div class="container">
            <h1 class="text-white text-center text-uppercase fw-bold title">Scooter City</h1>
            <a href="{{ route('user.bikes') }}" class="rent-btn">Rent Now</a>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row pb-5">
                <div class="col-md-9">
                    <h3 class="my-5">About Scooter City</h3>
                    <p>
                        My name is Kyaw Zayyar, and I’ve been living in Myanmar for over 23 years. I recently decided to
                        start
                        Myanmar Bike Rentals, to share both my love of this amazing country, as well as my love of traveling
                        by motorcycle.
                    </p>
                    <p>
                        There is such a massive difference in the experiences you can have between travelling by car/bus,
                        and travelling by motorcycle. When in a car or bus, you are closed off from the countryside or
                        people around you. Your destination is your main focus. When on a motorcycle, you are no longer a
                        passive spectator to the views passing by your window. You are an active participant in whatever
                        environment you are passing through. You are not just seeing, you are experiencing….the sights,
                        sounds, smells…… Although your destination remains just as important, your journey, the act of
                        getting, there has taken on a whole life of its own.
                    </p>
                    <p>
                        I rent out bikes to travellers who want to have the freedom to drive themselves around Maubin, and
                        the surrounding areas, or for the more adventurous minded, you can take one of the bikes for a
                        longer tour around the country. That said, there are some areas of the country which are off limits
                        to tourists, so please try to give us a general idea of where you are intending to go and we will be
                        able to advise you on what’s possible. Currently, Inle Lake and Bagan are off limits to tourists on
                        motorcycles, unless with a large organized tour.
                    </p>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('assets/img/yamaha-intro.jpg') }}" alt=""
                        style="width: 100%;margin-top:7rem;">
                </div>
            </div>
        </div>
    </main>
    <main class="htr">
        <div class="container">
            <div class="row pb-5">
                <div class="col-12">
                    <h3 class="my-5">How To Rent ?</h3>
                    <div class="rents">
                        <div class="rent">
                            <div>
                                <i class="fa-solid fa-magnifying-glass fa-3x"></i>
                            </div>
                            <div>
                                <h4>1. Choose Bike</h4>
                                <p>
                                    Click <a class="text-decoration-none" href="{{ route('user.bikes') }}">"Bikes"</a> link
                                    and add to cart bike that you
                                    want.
                                </p>
                            </div>
                        </div>
                        <div class="rent">
                            <div>
                                <i class="fa-solid fa-passport fa-3x"></i>
                            </div>
                            <div>
                                <h4>2. Show Up</h4>
                                <p>
                                    Show up with your passport and driver’s license. I really don’t like handing my passport
                                    to anyone, so I won’t require you to do so either, but I do need to see a valid passport
                                    and driver’s license, which I will make a copy of.
                                </p>
                            </div>
                        </div>
                        <div class="rent">
                            <div>
                                <i class="fa-solid fa-sack-dollar fa-3x"></i>
                            </div>
                            <div>
                                <h4>3. Deposit</h4>
                                <p>
                                    Pay a deposit of $50 each for the smaller bikes/ manual scooters, $100 for the medium
                                    bikes and automatic scooters, and $200 for the big bikes (acceptable/preferable in local
                                    currency).
                                </p>
                            </div>
                        </div>
                        <div class="rent">
                            <i class="fa-solid fa-motorcycle fa-3x"></i>
                            <div>
                                <h4>4. Return</h4>
                                <p>
                                    At the end of your rental, return the bike(s) in the same condition as when you took
                                    them out.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        Designed by Kyaw Zayyar. &copy;2022 All right reserved.
    </footer>
@endsection
