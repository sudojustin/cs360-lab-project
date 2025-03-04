<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add to cart</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- buttons for the top of the page, having errors with getting these links to work
    <a href="cart.blade.php" class="button-class">Cart</a>
    <a href="products.blade.php" class="button-class">Product List</a>
    <a href="profile.blade.php" class="button-class">Profile</a>
    -->
    <!-- CSS for the proposed products
    <style>
    body{
        margin-top:20px;
        background:#eee;
    }

    .prod-info-main {
        border: 1px solid #CEEFFF;
        margin-bottom: 20px;
        margin-top: 10px;
        background: #fff;
        padding: 6px;
        -webkit-box-shadow: 0 1px 4px 0 rgba(21,180,255,0.5);
        box-shadow: 0 1px 1px 0 rgba(21,180,255,0.5);
    }

    .prod-info-main .product-image {
        background-color: #EBF8FE;
        display: block;
        min-height: 238px;
        overflow: hidden;
        position: relative;
        border: 1px solid #CEEFFF;
        padding-top: 40px;
    }

    .prod-info-main .product-deatil {
        border-bottom: 1px solid #dfe5e9;
        padding-bottom: 17px;
        padding-left: 16px;
        padding-top: 16px;
        position: relative;
        background: #fff
    }

    .product-content .product-deatil h5 a {
        color: #2f383d;
        font-size: 15px;
        line-height: 19px;
        text-decoration: none;
        padding-left: 0;
        margin-left: 0
    }

    .prod-info-main .product-deatil h5 a span {
        color: #9aa7af;
        display: block;
        font-size: 13px
    }

    .prod-info-main .product-deatil span.tag1 {
        border-radius: 50%;
        color: #fff;
        font-size: 15px;
        height: 50px;
        padding: 13px 0;
        position: absolute;
        right: 10px;
        text-align: center;
        top: 10px;
        width: 50px
    }

    .prod-info-main .product-deatil span.sale {
        background-color: #21c2f8
    }

    .prod-info-main .product-deatil span.discount {
        background-color: #71e134
    }

    .prod-info-main .product-deatil span.hot {
        background-color: #fa9442
    }

    .prod-info-main .description {
        font-size: 12.5px;
        line-height: 20px;
        padding: 10px 14px 16px 19px;
        background: #fff
    }

    .prod-info-main .product-info {
        padding: 11px 19px 10px 20px
    }

    .prod-info-main .product-info a.add-to-cart {
        color: #2f383d;
        font-size: 13px;
        padding-left: 16px
    }

    .prod-info-main name.a {
        padding: 5px 10px;
        margin-left: 16px
    }

    .product-info.smart-form .btn {
        padding: 6px 12px;
        margin-left: 12px;
        margin-top: -10px
    }

    .load-more-btn {
        background-color: #21c2f8;
        border-bottom: 2px solid #037ca5;
        border-radius: 2px;
        border-top: 2px solid #0cf;
        margin-top: 20px;
        padding: 9px 0;
        width: 100%
    }

    .product-block .product-deatil p.price-container span,
    .prod-info-main .product-deatil p.price-container span,
    .shipping table tbody tr td p.price-container span,
    .shopping-items table tbody tr td p.price-container span {
        color: #21c2f8;
        font-family: Lato, sans-serif;
        font-size: 24px;
        line-height: 20px
    }

    .product-info.smart-form .rating label {
        margin-top:15px;
        
    }

    .prod-wrap .product-image span.tag2 {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        padding: 10px 0;
        color: #fff;
        font-size: 11px;
        text-align: center
    }

    .prod-wrap .product-image span.tag3 {
        position: absolute;
        top: 10px;
        right: 20px;
        width: 60px;
        height: 36px;
        border-radius: 50%;
        padding: 10px 0;
        color: #fff;
        font-size: 11px;
        text-align: center
    }

    .prod-wrap .product-image span.sale {
        background-color: #57889c;
    }

    .prod-wrap .product-image span.hot {
        background-color: #a90329;
    }

    .prod-wrap .product-image span.special {
        background-color: #3B6764;
    }
    .shop-btn {
        position: relative
    }

    .shop-btn>span {
        background: #a90329;
        display: inline-block;
        font-size: 10px;
        box-shadow: inset 1px 1px 0 rgba(0, 0, 0, .1), inset 0 -1px 0 rgba(0, 0, 0, .07);
        font-weight: 700;
        border-radius: 50%;
        padding: 2px 4px 3px!important;
        text-align: center;
        line-height: normal;
        width: 19px;
        top: -7px;
        left: -7px
    }

    .product-deatil hr {
        padding: 0 0 5px!important
    }

    .product-deatil .glyphicon {
        color: #3276b1
    }

    .product-deatil .product-image {
        border-right: 0px solid #fff !important
    }

    .product-deatil .name {
        margin-top: 0;
        margin-bottom: 0
    }

    .product-deatil .name small {
        display: block
    }

    .product-deatil .name a {
        margin-left: 0
    }

    .product-deatil .price-container {
        font-size: 24px;
        margin: 0;
        font-weight: 300;
        
    }

    .product-deatil .price-container small {
        font-size: 12px;
        
    }

    .product-deatil .fa-2x {
        font-size: 16px!important
    }

    .product-deatil .fa-2x>h5 {
        font-size: 12px;
        margin: 0
    }

    .product-deatil .fa-2x+a,
    .product-deatil .fa-2x+a+a {
        font-size: 13px
    }

    .product-deatil .certified {
        margin-top: 10px
    }

    .product-deatil .certified ul {
        padding-left: 0
    }

    .product-deatil .certified ul li:not(first-child) {
        margin-left: -3px
    }

    .product-deatil .certified ul li {
        display: inline-block;
        background-color: #f9f9f9;
        padding: 13px 19px
    }

    .product-deatil .certified ul li:first-child {
        border-right: none
    }

    .product-deatil .certified ul li a {
        text-align: left;
        font-size: 12px;
        color: #6d7a83;
        line-height: 16px;
        text-decoration: none
    }

    .product-deatil .certified ul li a span {
        display: block;
        color: #21c2f8;
        font-size: 13px;
        font-weight: 700;
        text-align: center
    }

    .product-deatil .message-text {
        width: calc(100% - 70px)
    }

    @media only screen and (min-width:1024px) {
        .prod-info-main div[class*=col-md-4] {
            padding-right: 0
        }
        .prod-info-main div[class*=col-md-8] {
            padding: 0 13px 0 0
        }
        .prod-wrap div[class*=col-md-5] {
            padding-right: 0
        }
        .prod-wrap div[class*=col-md-7] {
            padding: 0 13px 0 0
        }
        .prod-info-main .product-image {
            border-right: 1px solid #dfe5e9
        }
        .prod-info-main .product-info {
            position: relative
        }
    }
    </style>
-->
</head>
<body>
    <div  class="bg-white">
        <header>
            <div class="container px-6 py-3 mx-auto">
                <div class="flex items-center justify-between">


                    <div class="flex items-center justify-end w-full">
                        <button" class="mx-4 text-gray-600 focus:outline-none sm:mx-0">

                        </button>
                    </div>
                </div>
                <nav  class="p-6 mt-4 text-white bg-black sm:flex sm:justify-center sm:items-center">
                    <div class="flex flex-col sm:flex-row">
                        <a class="mt-3 hover:underline sm:mx-3 sm:mt-0" href="/">Home</a>
                        <!-- proposed changes for adding links to the top of the page to navigate between (this has been causing errors)
                        <a href="cart.blade.php" class="button-class">Cart</a>
                        <a href="products.blade.php" class="button-class">Product List</a>
                        <a href="profile.blade.php" class="button-class">Profile</a>
                        --> 
                        <a href="{{ route('cart.list') }}" class="flex items-center justify-end">
                            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ Cart::getTotalQuantity()}}
                        </a>

                    </div>
                </nav>
            </div>
        </header>

        <main class="my-8">
            @yield('content')
        </main>

    </div>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <a href="{{ route('cart.list') }}" class="flex items-center">
                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    {{ Cart::getTotalQuantity() }}
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>

        <div class="container px-6 mx-auto">
            <h3 class="text-2xl font-medium text-gray-700">Product List</h3>
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                        <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full max-h-60">
                        <div class="px-5 py-3">
                            <h3 class="text-gray-700 uppercase">{{ $product->name }}</h3>
                            <span class="mt-2 text-gray-500">${{ $product->price }}</span>
                            <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $product->id }}" name="id">
                                <input type="hidden" value="{{ $product->name }}" name="name">
                                <input type="hidden" value="{{ $product->price }}" name="price">
                                <input type="hidden" value="{{ $product->image }}" name="image">
                                <input type="hidden" value="1" name="quantity">
                                <button class="px-4 py-2 text-white bg-blue-800 rounded">Add To Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-app-layout>
    <!-- my proposed changes for creating products
    <div class="container">
        <div class="col-xs-12 col-md-6">
            // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="https://fastly.picsum.photos/id/204/200/200.jpg?hmac=gppQCOIV43fSCLsdUCoPQxrc16lrOEvVu2u5nH-I4Zo" class="img-responsive"> 
                                <span class="tag2 hot"> HOT </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here
                                    </a>
                                    <a href="#">
                                        <span>Product Category</span>
                                    </a>                            

                                </h5>
                                <p class="price-container">
                                    <span>$199</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 
        </div>
        <div class="col-xs-12 col-md-6">
            // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="images/products/p1.png" alt="194x228" class="img-responsive"> 
                                <span class="tag2 hot">
                                    HOT
                                </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here <span>Product Category</span>
                                    </a>
                                </h5>
                                <p class="price-container">
                                    <span>$50</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 
        </div>
        <div class="col-xs-12 col-md-6">
        // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="images/products/p2.png" alt="194x228" class="img-responsive"> 
                                <span class="tag3 special">
                                    Special
                                </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here <span>Product Category</span>
                                    </a>
                                </h5>
                                <p class="price-container">
                                    <span>$299</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 
        </div>
        <div class="col-xs-12 col-md-6">
            // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="images/products/p3.png" alt="194x228" class="img-responsive"> 
                                <span class="tag2 sale">
                                    SALE
                                </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here <span>Product Category</span>
                                    </a>
                                </h5>
                                <p class="price-container">
                                    <span>$1000</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 


                
        </div>


        <div class="col-xs-12 col-md-6">
            // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="images/products/p3.png" alt="194x228" class="img-responsive"> 
                                <span class="tag2 sale">
                                    SALE
                                </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here <span>Product Category</span>
                                    </a>
                                </h5>
                                <p class="price-container">
                                    <span>$1000</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 


                
        </div>

        <div class="col-xs-12 col-md-6">
            // First product box start here
            <div class="prod-info-main prod-wrap clearfix">
                <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <img src="images/products/p3.png" alt="194x228" class="img-responsive"> 
                                <span class="tag2 sale">
                                    SALE
                                </span> 
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-deatil">
                                <h5 class="name">
                                    <a href="#">
                                        Product Code/Name here <span>Product Category</span>
                                    </a>
                                </h5>
                                <p class="price-container">
                                    <span>$1000</span>
                                </p>
                                <span class="tag1"></span> 
                        </div>
                        <div class="description">
                            <p>A Short product description here </p>
                        </div>
                        <div class="product-info smart-form">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <a href="javascript:void(0);" class="btn btn-danger">Add to cart</a>
                                    <a href="javascript:void(0);" class="btn btn-info">More info</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating">Rating:
                                        <label for="stars-rating-5"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-4"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-3"><i class="fa fa-star text-danger"></i></label>
                                        <label for="stars-rating-2"><i class="fa fa-star text-warning"></i></label>
                                        <label for="stars-rating-1"><i class="fa fa-star text-warning"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            // end product 


                
        </div>
    </div>
-->
</body>
</html>

