<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Order;
use App\Evertec\Evertec;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * List all orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $orders = Order::latest()->paginate(10);
        return view('front.order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cart_products = session('cart');
        
        if(!isset($cart_products)){
            return redirect()->route('front.cart.index')->with('warning', '¡Sin productos para procesar!');
        }

        return view('front.order.create', ['cart_products' => $cart_products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $data_cart = session('cart');
            $order_data = $request->all();
            $order_token = Str::random(60);
            
            $total = 0;
            foreach ($data_cart as $cart) {
                $total += $cart['price'];
            }
            
            // Create session
            $service_checkout = Evertec::createSession($order_data, $total, $order_token, false);
            if($service_checkout->status->status != 'OK'){
                return redirect()->back()->with('error', '¡No fue posible procesar el pago!');
            }
            
            // Save order
            $order_data['total'] = intval($total);
            $order_data['status'] = 'CREATED';
            $order_data['request_id'] = intval($service_checkout->requestId);
            $order_data['token'] = $order_token;
            
            $order = Order::create( $order_data );
            $order->products()->attach($cart['id']);

            // Destroy cart
            session()->forget('cart');
            
            // Redirect payment checkout
            return Redirect::away($service_checkout->processUrl);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', '¡Ocurrio un error inesperado!');
        }
    }

    /**
     * Confirm and update the order 
     *
     * @param string  $token
     * @return \Illuminate\Http\Response
     */
    public function confirmOrder($token)
    {
        $order = Order::with('products')->where('token', $token)->firstOrFail();
        $order_status_checkout = Evertec::checkSession($order->request_id, false);

        if( $order_status_checkout->status->status != 'APPROVED' ) {
            $order->update(['status' => 'REJECTED']);
        }else{
            $order->update([
                'status' => 'PAYED'
            ]);
        }

        return view('front.order.confirm', [
            'order' => $order, 
            'order_status_checkout' => $order_status_checkout 
        ]);
    }

    /**
     * Reattempt payment rejected
     *
     * @param  int  $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function retryPayment($id)
    {
        try{
            $order = Order::with('products')->findOrFail($id);
            
            // Create session
            $service_checkout = Evertec::createSession($order, $order->total, $order->token, false);
            if($service_checkout->status->status != 'OK'){
                return redirect()->back()->with('error', '¡No fue posible procesar el pago!');
            }
            
            // Redirect payment checkout
            return Redirect::away($service_checkout->processUrl);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', '¡Ocurrio un error inesperado!');
        }
    }

}
