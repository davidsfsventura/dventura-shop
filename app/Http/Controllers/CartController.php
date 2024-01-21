<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function totalQuantity()
    {
        $cart = Session::get('cart');

        if (!$cart) {
            return 0; // Return 0 if the cart is empty
        }

        $totalQuantity = 0;

        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }
        Session::put("cartQuantity", $totalQuantity);
        return $totalQuantity;
    }

    public function AddToCart(Request $request)
    {
        $cart = Session::get('cart');
        $id = $request->prodID;

        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $request->prodName,
                    "quantity" => 1,
                    "description" => $request->prodDescription,
                    "price" => $request->prodPrice,
                    "imageURL" => $request->prodImgSrc
                ]
            ];

            Session::put("cart", $cart);
            $quantity = $this->totalQuantity();
            return response()->json(['quantity' => $quantity]);
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Session::put('cart', $cart);
            $quantity = $this->totalQuantity();
            return response()->json(['quantity' => $quantity]);
        }

        $cart[$id] = [
            "name" => $request->prodName,
            "quantity" => 1,
            "description" => $request->prodDescription,
            "price" => $request->prodPrice,
            "imageURL" => $request->prodImgSrc
        ];

        Session::put('cart', $cart);
        $quantity = $this->totalQuantity();
        return response()->json(['quantity' => $quantity]);
    }
}
