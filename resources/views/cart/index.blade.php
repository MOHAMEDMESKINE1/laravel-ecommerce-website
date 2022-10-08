@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            
            <div class="col-md-12 card p-3">
                <div class="card-header p-auto">
                    <h4 class="text-dark text-center" > Votre Panier  </h4>
                  </div>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $item)
                            <tr>
                                <td><img width="50" height="50" src="{{asset($item->options->has('image') ? $item->options->image : '')}}" alt="{{$item->title}}"></td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->qty}}</td>
                                <td>{{$item->price}}DH</td>
                                <td>{{$item->qty * $item->price}}DH</td>

                                {{-- update product --}}
                                <td>

                                    <form  class="d-flex flex-row justify-content-center align-items-cente" method="post" action=""> {{--{{route('update.carte',$item->associate->slug)}}--}}
                                        @csrf
                                        @method("PUT")
                                        <div class="form-group">
                                            <input type="number" name="qty" id="qty"
                                                value="{{ $item->qty }}"
                                                placeholder="Quantité"
                                                {{-- max="{{ $item->associate->inStock}}" --}}
                                                max="10"
                                                min="1"
                                                class="form-control"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-warning text-white mx-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>

                               
                                {{-- delete product --}}
                                {{-- {{ route("remove.cart",$item->associate->slug) }} --}}
                                <td>
                                    <form class="d-flex flex-row justify-content-center align-items-center" action="" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-danger mx-2">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                          
                        @endforeach
                        <tr >
                            <td colspan="4" class="text-center bg-light border border-success "><b>Total à payer :</b></td>
                            <td  class=" bg-success text-white border border-success ">
                                 <b>{{Cart::subtotal()}}</b> DH
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{-- paiment --}}
                @if (Cart::subtotal() > 0)
                    <a href="{{route('make.payment')}}" class="btn btn-primary mt-3">
                        Payer {{Cart::subtotal()}} DH via PayPal
                    </a>

                   
                @endif
            </div>
        </div>
    </div>
    
@endsection