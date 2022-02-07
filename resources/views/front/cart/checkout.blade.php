@extends('layouts.front')

@section('content')
<div class="container my-4">
    <h1>Formulario de pago</h1>

    @include('front.alerts.success')

    @include('front.alerts.warning')

    <div class="row mt-4">
        <div class="col-12 col-md-12 col-lg-6">
            <h4>Datos personales</h4>
            <form action="{{ route('front.cart.checkout') }}" method="post">

                @csrf

                <div class="row g-3">

                    <div class="col-sm-12">
                        <label for="full_name" class="form-label">Nombre completo *</label>
                        <input type="text" class="form-control" name="customer_name" id="full_name" placeholder="Nombre completo" value="{{ old('customer_name') }}" autofocus>

                        @error('customer_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-12">
                        <label for="email" class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" name="customer_email" id="email" placeholder="Correo electrónico" value="{{ old('customer_email') }}">

                        @error('customer_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="col-sm-12">
                        <label for="phone" class="form-label">Celular *</label>
                        <input type="phone" class="form-control" name="customer_mobile" id="phone" placeholder="Celular" value="{{ old('customer_mobile') }}">
                        
                        @error('customer_mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>

                <hr class="my-4">

                <a href="{{ route('front.cart.index') }}" class="btn btn-warning">Regresar</a>
                <button type="submit" class="btn btn-success">Realizar el pago</button>

            </form>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
            @php $total = 0 @endphp
            <h4>Detalles del pedido</h4>
            
            <table id="cart" class="table table-condensed" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(session('cart') as $key => $product)
                        @php $total += $product['price'] @endphp
                        <tr data-id="{{ $product['id'] }}">
                            <td>
                                {{ $product['title'] }}
                            </td>
                            <td>$ {{ number_format($product['price'], 0, ",", "."); }} </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" align="right"><h3><strong>Total ${{ $total }}</strong></h3></td>
                    </tr>
                </tfoot>
                
            </table>
        </div>
    </div>

</div>
@endsection