@extends('layouts.front')

@section('content')
<div class="container my-4">
    <h1>Historial de ordenes</h1>

    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo electrónico</th>
                <th scope="col">Celular</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_email }}</td>
                    <td>{{ $order->customer_mobile }}</td>
                    <td>$ {{ number_format($order->total, 0, ",", "."); }}</td>
                    <td>
                        @if ( $order->status == 'PAYED' )
                            <span class="badge bg-success">Aprobada</span>
                        @else
                            <span class="badge bg-danger">Rechazada</span>
                        @endif
                    </td>
                    <td>{{ date('Y-m-d h:m:s', strtotime($order->created_at)) }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" disabled="disabled">Producto</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex">
        {!! $orders->links() !!}
    </div>

</div>

@endsection