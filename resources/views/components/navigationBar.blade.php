<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    @import url("https://fonts.googleapis.com/css2?family=PT+Sans:wght@700&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap");

    * {
        font-family: "PT Sans", sans-serif;
    }


    .topnav {
        width: 100%;
        z-index: 9999;
        overflow: hidden;
        background-color: #3586ff;
    }

    .topnav a {
        cursor: pointer;
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav .icon {
        display: none;
    }

    .topnav a:hover,
    .dropdown:hover .dropbtn {
        background-color: #63a1ff;
        color: white;
    }

    /*     .dropdown {
        float: left;
        overflow: hidden;
    }

    .dropdown .dropbtn {
        font-size: 17px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }


    .dropdown-content a:hover {
        background-color: #63a1ff;
        color: black;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
 */
    @media screen and (max-width: 500px) {

        .topnav a:not(:first-child),
        .dropdown .dropbtn {
            display: none;
        }

        .topnav a.icon {
            float: right;
            display: block;
        }
    }

    @media screen and (max-width: 500px) {
        .topnav.responsive {
            position: relative;
        }

        .topnav.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }

        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }

        .topnav.responsive .dropdown {
            float: none;
        }

        .topnav.responsive .dropdown-content {
            position: relative;
        }

        .topnav.responsive .dropdown .dropbtn {
            display: block;
            width: 100%;
            text-align: left;
        }
    }
</style>

<div class="topnav" id="myTopnav">
    <a href="/">Home</a>
    <a href="/shop">Shop</a>
    <a href="/feedback">Contact</a>
    {{-- <div class="dropdown">
        <button class="dropbtn">Dropdown
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
        </div>
    </div> --}}
    <a href="/about">About</a>
    <a href="https://github.com/davidsfsventura/dventura-shop" target="_blank">Source Code</a>
    @php
    if(Session::get('email') != null){
    @endphp
    <a href="/accountinfo" style="float:right">{{ Session::get('username') }}</a>
    @php
    }
    else{
    @endphp
    <a href="/login" style="float:right">Login</a>
    @php
    }
    @endphp

    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>
<script>
    function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>