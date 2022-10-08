@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
       
        <div class="col-md-8">
          
            {{-- add product --}}
      <a  class="btn btn-outline-primary btn-sm w-25" 
            href="{{ route("products.create") }}"
            class="btn btn-primary my-2">
                <i class="fa fa-plus"></i> 
                Ajouter
        </a> 

        <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Disponible</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- display products --}}
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ Str::limit($product->title,15)}}</td>
                            <td>{{ Str::limit($product->description,30) }}</td>
                            <td>{{ $product->inStock }}</td>
                            <td>{{ $product->price }} DH</td>
                            <td>
                                @if($product->inStock > 0)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                               @if ($product->image)

                                    <img src="{{ asset($product->image) }}"
                                        alt="{{ $product->title }}"
                                        width="50"
                                        height="50"
                                        class="img-fluid rounded"
                                    >
                               @endif
                            </td>
                            <td>
                                {{ $product->category->title }}
                            </td>
                            {{-- edit product --}}
                            <td class="d-flex flex-row justify-content-center align-items-center">
                                <a
                                    href="{{ route("products.edit",$product->slug) }}"
                                    class="btn btn-sm btn-warning mx-2">
                                        <i class="fa fa-edit"></i>
                                </a>
                                {{-- delete product --}}
                                <form  method="POST" action="{{ route("products.destroy",$product->slug) }}">
                                    @csrf
                                    @method("DELETE")

                                    <button
                                    onclick='return confirm("Voulez vous vraiment supprimer le produit :{{$product->title}}")'
                                    class="btn btn-sm btn-danger">

                                    <i class="fa fa-trash"></i>

                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="justify-content-center d-flex">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
<script>
   

</script>
@endsection