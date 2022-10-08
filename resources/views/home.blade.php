
@extends('layouts.app')
@section('title')
    Welcome |EcommerceShop
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Nouvelle Arrivage !</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                                {{-- display products --}}
                                @foreach ($products as $product)
                                <div class="col-md-6 mb-2 p-1 shadow-sm">
                                    <div class="card" style="width: 18rem;height:100%">
                                        <div class="card-img-top">
                                            @if (!$product->image)
                                            <img src="{{ asset("images/products/".$product->image) }}" class="img-fluid rounded" alt="{{$product->title}}" >
                                            @else
                                            <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{$product->title}}" >

                                            @endif
                                        </div>
                                            <div class="card-body">
                                            <div class="card-title">
                                                <h5>{{$product->title}}</h5>
                                            </div>
                                            <p class="d-flex flex-row justify-content-between align-items-center">
                                                
                                                <span class="text-muted"> {{$product->price}}DH</span>
                                                <span class="text-danger"> <s>{{$product->old_price}}DH</s></span>

                                            </p>
                                            <p class="card-text">
                                                {{Str::limit($product->description,100)}}
                                            </p>
                                            
                                                <a href="{{route("products.show",$product->slug)}}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            
                                    </div>

                                </div>
                        </div>
                     @endforeach

                       </div>
                       <hr>
                       {{-- Pagination --}}
                       <div class="d-flex justify-content-center">
                            {{$products->links()}}
                       </div>
                    </div>
                </div>
            </div>
            {{-- display categories --}}
            <div class="col-md-4">
                <ul class="list-group shadow-sm">
                    <li class="list-group-item  active">
                        Categories
                    </li>
                    @foreach ($categories as $category)
                            <a href="{{route('category.products',$category->slug)}}" class="list-group-item">
                                {{$category->title}}

                               ({{$category->products->count()}})
                            </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
