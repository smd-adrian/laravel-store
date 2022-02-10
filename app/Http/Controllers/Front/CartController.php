<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCarRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.cart.index');
    }

    /**
     * Add product to shopping cart
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
  
        if( !isset($cart[$product->id]) ){
            $cart[$product->id] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'photo' => $product->photo
            ];
        }else{
            return redirect()->back()->with('warning', '¡El producto ya existe en la cesta!');
        }
        
        session()->put('cart', $cart);

        return redirect()->back()->with('success', '¡Producto añadido a la cesta con éxito!');
    }

    /**
     * Remove product from shopping cart
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeItemCart($id)
    {   
        $product = Product::findOrFail($id);

        $cart = session()->get('cart');
        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', '¡Producto retirado con éxito!');
    }

}
