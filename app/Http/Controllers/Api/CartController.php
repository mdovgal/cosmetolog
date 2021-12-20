<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CartResource;

use App\Cart;
use App\Product;
use App\CartItems;

class CartController extends Controller
{
    public function index( $user_id )
    {
        $cart = Cart::where('user_id', $user_id)
            ->where('status', 'new')
            ->with('cart_items')
            ->get();

        return CartResource::collection( $cart );
    }

    public function save(Request $request){
        $cart = Cart::where('user_id', $request->user_id )
            ->where('status', 'new')->get()->toArray();
//dd($cart);
        if(count($cart)){
            return $this->index( $cart[0]['user_id'] );
        }

        $data = [
            'user_id' => $request->user_id,
            'status' => 'new',
            'status_changed_at' => date('Y-m-d H:i:s')
        ];

        $cart = Cart::create( $data );

        return $this->index( $request->user_id );
    }


    public function save_item($cart_id, $product_id, $quantity){
//dd($cart_id, $product_id, $quantity);
        $current_cart = Cart::find( $cart_id );
//dd($current_cart);
        $product_info = Product::find( $product_id );
//dd($product_info->items_on_stock);

        if($quantity >  $product_info->items_on_stock){
            throw new ModelNotFoundException('Запитаного кількості товару немає в наявності ');
        }else{
            $data = [
                'cart_id' => $cart_id,
                'product_id' => $product_id,
                'count_items' => $quantity
            ];

            $card_items = CartItems::create( $data );
        }

        return $this->index( $current_cart->user_id );
    }
}
