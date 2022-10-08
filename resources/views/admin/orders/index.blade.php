@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-4">
                  {{-- sidebar --}}
                  @include('layouts.sidebar')
            </div>
            <div class="col-md-8">
              
                <table class="table table-hover border border-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Delivered</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- display products --}}
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->product_name}}</td>
                                <td>{{$order->qty}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->total}}</td>

                                <td>
                                    @if ($order->paid)
                                        <i class="fa fa-check text-success"></i>
                                    @else 
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    {{--  $order->delivered == 1 --}}
                                    @if ($order->delivered) 
                                        <i class="fa fa-check text-success"></i>
                                    @else 
                                        <i class="fa fa-times text-danger"></i>
                                    @endif

                                </td>
                               
                                <td class="d-flex flex-row justify-content-center align-items-center">
                                    
                                        {{-- update order --}}
                                        <form action="{{ route('orders.update',$order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <button 
                                                onclick="return confirm('Are You Sure !')"
                                                class="btn btn-sm btn-success mx-2">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- delete order --}}
                                        
                                        <form action="{{ route('orders.destroy',$order->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                           
                                            <button
                                                onclick="return confirm('Are You Sure !')"
                                                class="btn btn-sm btn-danger">

                                                <i class="fas fa-trash"></i>

                                            </button>
                                        </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center align-items-center">
                    {{$orders->links()}}
                </div>
            </div>      
        </div>
       
    </div>    
@endsection