<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request){
        $this->validate($request, [
            'id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        $retMess = '';
        $item = Item::find($request->id);
        // check item quantity and quantity to sell
        if ($item->quantity < $request->quantity){
            return ['type'=>'error' ,'mess' => 'Not enough items in stock'];
        }

        // check if item already in cart, then update else create
        $found_cart = Cart::where('item_id', $item->id)->first();

        // update
        if ($found_cart){
            $found_cart->price = $item->selling_price * $request->quantity;
            $found_cart->quantity = $request->quantity;
            $found_cart->profit = ($item->selling_price*$request->quantity) - ($item->purchase_price*$request->quantity);
            $found_cart->update();
            $retMess = $item->name.' updated in cart';
        }

        // create
        else{
            $cart = $item->cart()->create([
                'item_name' => $item->name,
                'price' => $item->selling_price * $request->quantity,
                'profit' => ($item->selling_price*$request->quantity) - ($item->purchase_price*$request->quantity),
                'quantity' => $request->quantity,
                'store_box' => $item->store_box
            ]);
            $retMess = $item->name.' added to cart';
        }

        return ['type'=>'success' ,'mess' => $retMess, 'carts'=>Cart::all()];
    }

    public function all(){
        $carts = Cart::all();
        $totalPrice = 0;
        foreach ($carts as $cart){
            $totalPrice += $cart->price;
        }
        return ['carts' => $carts, 'totalPrice' => $totalPrice];
    }

    public function clear(Request $request){
        $carts = Cart::all();
        foreach ($carts as $cart){
            $cart->delete();
        }
    }

    public function destroy(Request $request){
        $this->validate($request, ['id' => 'required|numeric']);
        $cart = Cart::find($request->id);
        $cart->delete();
    }

    public function confirm(){
        $carts = Cart::all();
        $carted_id = rand(0, 9).time();
        $carted_items = [];
        $total_amount_paid = 0;

        foreach ($carts as $cart){
            $item = $cart->item;

            // add cart price to total price
            $total_amount_paid += $cart->price;

            // update item quantity
            $item->quantity = $item->quantity - $cart->quantity;
            $item->update();

            // create individual sale
            $item->sales()->create([
                'cart_id' => $carted_id,
                'user_id' => Auth::id(),
                'item_name' => $cart->item_name,
                'price' => $cart->price,
                'profit' => ($item->selling_price - $item->purchase_price) * $cart->quantity,
                'quantity' => $cart->quantity
            ]);
            // delete item from cart
            $cart->delete();
        }
        return ['success'=>'true'];
    }

}
