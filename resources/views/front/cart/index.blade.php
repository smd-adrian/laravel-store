@extends('layouts.front')

@section('content')
<div class="container my-4">
    <h1>Carrito</h1>

    @include('front.alerts.success')

    @include('front.alerts.warning')

    <div class="mt-4">
        @php $total = 0 @endphp
        @if(session('cart'))
            <table id="cart" class="table table-condensed" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Detalle</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                
                    @foreach(session('cart') as $key => $product)
                        @php $total += $product['price'] @endphp
                        <tr data-id="{{ $product['id'] }}">
                            <td>
                                <img src="{{ asset('images/products/' . $product['photo']) }}" width="50" height="50" class="img-responsive"/>
                            </td>
                            <td>
                                {{ $product['title'] }}
                            </td>
                            <td>$ {{ number_format($product['price'], 0, ",", "."); }} </td>
                            <td class="actions">
                                <a href="{{ route('front.cart.remove', $product['id']) }}">
                                    <i class="bi bi-trash" title="Eliminar producto"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ route('front.products.index') }}" class="btn btn-warning">Ver productos</a>
                            <a href="{{ route('front.cart.checkout') }}" class="btn btn-success">Continuar</a>
                        </td>
                    </tr>
                </tfoot>
                
            </table>
        @else 

            <div class="alert alert-warning">
                <span>¡El carrito esta vacio! <strong><a href="{{ route('front.products.index') }}" > Ver productos</a></strong></span>
            </div>

        @endif
    </div>

</div>

@endsection
