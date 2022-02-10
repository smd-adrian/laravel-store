@extends('layouts.front')

@section('content')
<div class="container my-4">

    <h1>Detalles de la orden</h1>

    @if ( $order_status_checkout->status->status == 'APPROVED' )
        @include('front.order.messages.approved')
    @else
        @include('front.order.messages.rejected')
    @endif

    <div class="info ">
        <ul class="nav nav-tabs" id="order-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="transaction-tab" data-toggle="tab" href="#order-detail" role="tab" aria-controls="home" aria-selected="true">Detalles del pedido</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="false">Datos de la transacción</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="order-detail" role="tabpanel" aria-labelledby="home-tab">
                <table id="cart" class="table table-condensed mt-3" style="vertical-align: middle">
                    <thead>
                        <tr>
                            <th>Detalle</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
    
                    <tbody>
                    
                        @foreach($order->products()->get() as $key => $product)
                            <tr data-id="{{ $product['id'] }}">
                                <td>
                                    <img src="{{ asset('images/products/' . $product['photo']) }}" width="50" height="50" class="img-responsive"/>
                                </td>
                                <td>
                                    {{ $product['title'] }}
                                </td>
                                <td>$ {{ number_format($product['price'], 0, ",", "."); }} </td>
                            </tr>
                        @endforeach
    
                    </tbody>
    
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><h3><strong>Total ${{ number_format($order->total, 0, ",", "."); }}</strong></h3></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane fade" id="transaction" role="tabpanel" aria-labelledby="profile-tab">
                <ul class="mt-3">
                        <li><strong>Nombre del comprador:</strong> {{ $order_status_checkout->request->buyer->name }} </li>
                        <li><strong>Correo electrónico:</strong> {{ $order_status_checkout->request->buyer->email }}</li>
                        <li>
                            <strong>Estado:</strong>
                            @if ( $order_status_checkout->status->status == 'APPROVED' )
                                <span class="badge bg-success">Aprobada</span>
                            @else
                                <span class="badge bg-danger">Rechazada</span>
                            @endif
                        </li>
                        
                        <li><strong>Total: </strong> ${{ number_format($order_status_checkout->request->payment->amount->total, 0, ",", "."); }}</li>

                        @if ( $order_status_checkout->status->status == 'APPROVED' )
                            <li><strong>Fecha de transacción:</strong> {{ date('Y-m-d h:m:s', strtotime($order_status_checkout->payment[0]->status->date)) }}</li>
                        @endif
                    
                </ul>
            </div>
            
            <div class="retry-payment mt-3">
                @if ( $order_status_checkout->status->status != 'APPROVED' )
                    <a href="{{ route('front.order.retry', $order->id) }}" class="btn btn-success">Reintentar pago</a>
                @endif
            </div>

        </div>
    </div>


</div>

@endsection