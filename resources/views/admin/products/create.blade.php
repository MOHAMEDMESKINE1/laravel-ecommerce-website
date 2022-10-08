@extends('layouts.app')
@section('content')
<div class="container m-5 mx-auto">
                    {{-- ajouter produit --}}
                    <form method="POST" action="{{ route("products.store") }}" enctype="multipart/form-data">
                    
                        @csrf
                        {{-- Title --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control" value="{{old('title')}}" id="Title" >
                            <label for="Title">Title</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                                <textarea id="description" name="description"
                                cols="30" rows="10" class="form-control">
                                {{old('description')}}
                            </textarea>
                                <label for="description">description</label>
                        </div>
    
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" value="{{old('price')}}" name="price" id="price">
                            <label for="price">Price</label>
                        </div>
    
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" value="{{old('old_price')}}" name="old_price" id="old_price">
                            <label for="old_price">Old Price</label>
                        </div>
    
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" value="{{old('inStock')}}"  name="inStock" id="inStock">
                            <label for="inStock">Quantité en stock</label>
                        </div>
    
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" name="image" id="image" >
                        </div>
    
                        <div class="form-floating mb-3">
                            <select class="form-control" name="category_id" id="category_id" >
                                {{-- <option value="" selected disabled>
                                   Choisir une catégorie
                                </option> --}}
                             
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="category_id">  Choisir une catégorie</label>
                        </div>
    
                        <button type="submit" class="btn btn-success">Enregistrer </button>
    
                    </form>
         
         
</div>


@endsection