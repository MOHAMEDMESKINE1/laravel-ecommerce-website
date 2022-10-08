{{-- errors --}}
@if ($errors->all())
    @foreach ($errors->all() as $error)
          <div class="alert alert-danger">
                {{$error}}
          </div>
    @endforeach
    
@endif
{{-- sessions --}}

@if (session()->has('success'))

          <div class="alert alert-success">
                {{-- {{session("success")}} --}}
                <strong>{{session()->get("success")}}</strong>
                
          </div>
@endif

@if (session()->has('warning'))

          <div class="alert alert-warning">
                {{-- {{session("warning")}} --}}
                <strong>{{session()->get("warning")}}</strong>
             
          </div>
@endif

@if (session()->has('errorLink'))

          <div class="alert alert-danger">
                {{-- {{session("errorLink")}} --}}
                <strong>{!!session()->get("errorLink")!!}</strong>
              
          </div>
@endif

@if (session()->has('info'))

          <div class="alert alert-info">
                {{-- {{session("info")}} --}}
                <strong>{{session()->get("info")}}</strong>
               
          </div>
@endif