@extends('layouts.front')

@section('content')
    <div class="container my-4">
        <h1>Productos</h1>

        @include('front.alerts.success')

        @include('front.alerts.warning')

        <div class="row mt-4 row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
            
            @foreach ($products as $product)
                <div class="col hp">
                    <div class="card h-100 shadow-sm">
                        <a href="#" class="border-bottom">
                            <img src="{{ asset('images/products/'. $product->photo) }}" class="card-img-top" alt="{{ explode('.', $product->photo)[0] }}" />
                        </a>
                        <div class="card-body">
                            <div class="clearfix mb-3 text-center">
                                <span class="badge rounded-pill bg-success">$ {{ number_format($product->price, 0, ",", "."); }}</span>
                            </div>
                            <h5 class="card-title text-center">{{ $product->title }} </h5>
                            <p class="mb-0">{{ substr($product->description, 0, 40); }}...</p>
                            <div class="d-grid gap-2 my-4">
                                <a class="btn btn-warning bold-btn w" href="{{ route('front.cart.add', $product->id) }}">Añadir al carrito</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
