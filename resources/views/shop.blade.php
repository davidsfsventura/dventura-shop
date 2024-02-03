<!DOCTYPE html>
<html lang="en">

<head>
  @include('components.navigationBar')
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('assets/img/main_logo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/shop.css') }}" />
  <script defer src="{{ asset('assets/js/shop.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Koulen&family=Lato&family=Nunito&family=Playfair+Display:ital@1&family=Prata&family=Raleway:ital,wght@1,100&family=Roboto&family=Roboto+Condensed&family=Teko&display=swap">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    var TimerForCard = [];
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <title>Diodav</title>
</head>

<body>
  <h2 style="width:100%;position: absolute;text-align:center">Still working on it</h2>
  <div style="display: flex; margin-top:3rem">
    <button class="menuButton" onclick="showSideMenu()"><i class="fa-solid fa-bars fa-2xl"></i></button>
    <div id="sidemenu" class="sidemenu animate__animated">
      <div class="bodyType">
        <input type="checkbox" class="bodyFilter" name="men" id="men" onchange="filter();">
        <label for="men">Men</label><br>
        <input type="checkbox" class="bodyFilter" name="women" id="women" onchange="filter();">
        <label for="women">Women</label><br>
        <input type="checkbox" class="bodyFilter" name="kids" id="kids" onchange="filter();">
        <label for="kids">Kids</label>
      </div>
      <div>
        <label for="price-min">Min Price: <span id="min-price">0€</span></label>
        <input type="range" name="price-min" id="price-min" value="0" min="0" max="200"
          oninput="document.getElementById('min-price').innerHTML = this.value + '€';" onchange="filter()">
        <label for="price-max">Max Price: <span id="max-price">200€</span></label>
        <input type="range" name="price-max" id="price-max" value="200" min="0" max="200"
          oninput="document.getElementById('max-price').innerHTML = this.value + '€';" onchange="filter()">
      </div>
      <div class="clothesType">
        <input type="checkbox" class="clothesFilter" name="shoes" id="shoes" onchange="filter();">
        <label for="shoes">Shoes</label><br>
        <input type="checkbox" class="clothesFilter" name="pants" id="pants" onchange="filter();">
        <label for="pants">Pants</label><br>
        <input type="checkbox" class="clothesFilter" name="shirts" id="shirts" onchange="filter();">
        <label for="shirts">Shirts</label><br>
      </div>
    </div>

    <div class="searchDiv">
      <input type="text" name="searchBox" placeholder="Search something.." class="searchInput"
        onchange="filter()"><button class="btnSearch"><i class="fa-solid fa-magnifying-glass fa-lg"
          onclick="filter()"></i></button>
    </div>
    <button class="cartButton"><i class="fa-solid fa-cart-shopping fa-xl"><span style="margin-left: 7px"
          id="cart-quantity">@php if(Session::get("cartQuantity") != ""){ echo Session::get("cartQuantity");}else {
          echo 0;
          } @endphp</span></i></button>
  </div>
  <h1 id="noAvailable" style='text-align:center; margin-top:10%; display:none'>No products available.</h1>
  <div id="cardsDiv" style="text-align: center; position: relative;">
    <br>
    @php
    $product = DB::table('products')->get();
    if ($product == NULL) {

    }
    else {
    foreach ($product as $prodItem) {
    @endphp
    <div id={{ $prodItem->id }} data-body_type="{{ $prodItem->body_type }}" data-type="{{ $prodItem->type }}"
      data-price="{{ $prodItem->price }}" data-name="{{ $prodItem->name }}" data-description="{{ $prodItem->description
      }}" class="cardContainer inactive"
      style="margin-bottom:2rem">
      <div class="card">
        <div class="side front">
          <div><img id="prodImage_<?= $prodItem->id ?>" class="img"
              src="{{ asset('assets/img/productImages/') }}/<?= $prodItem->image ?>">
          </div>
          <div class="info">
            <h2>{{ $prodItem->name }}</h2>
            <p>{{ $prodItem->description }}</p>
            <p><strong>{{ $prodItem->price }} €</strong></p>
            <div>
              <div id="add_<?= $prodItem->id ?>" class="btn-circle-add"
                onclick='Card(this.id,"{{ $prodItem->id }}", "{{ $prodItem->name }}");'>
                <a>
                  <svg id="plus" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                      <path d="M4 12H20M12 4V20" stroke="#9098a9" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    </g>
                  </svg>
                  <svg id="check" width="21px" height="15px" viewBox="13 17 21 15">
                    <polyline points="32.5 18.5 20 31 14.5 25.5"></polyline>
                  </svg>
                  <svg id="border" width="48px" height="48px" viewBox="0 0 48 48">
                    <path
                      d="M24,1 L24,1 L24,1 C36.7025492,1 47,11.2974508 47,24 L47,24 L47,24 C47,36.7025492 36.7025492,47 24,47 L24,47 L24,47 C11.2974508,47 1,36.7025492 1,24 L1,24 L1,24 C1,11.2974508 11.2974508,1 24,1 L24,1 Z">
                    </path>
                  </svg></a>
              </div>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
    @php
    }
    }
    @endphp
  </div>
  <div style="position:absolute; width: auto; top:20%;right:2rem" id="alerts">
  </div>

</body>

</html>