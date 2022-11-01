@extends('app')

@section('contain')
  <!-- Third Container (Grid) -->
<div class="container bg-3 text-center">    
  <h3 class="margin">Products</h3><br> 
  @foreach ($products as $item)
  @if ($loop->first || $loop->index%4==0)
      <div class="row">
  @endif
      <div class="col-sm-3">   
          <p>
              <img src="{{$item->image}}" class="img-responsive margin" style="width:100%" alt="Image">
              <b>Name:</b> {{Str::substr($item->name, 0, 50)}}<br>
              <b>Price:</b> {{$item->price}}
              <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $item->id }}" name="id">
                <input type="hidden" value="1" name="quantity">
                <button class="px-4 py-1.5 text-white text-sm bg-blue-800 rounded">Add To Cart</button>
            </form>
          </p>
      </div>
  @if ($loop->iteration%4==0 || $loop->last)
      </div>
  @endif  
  @endforeach
  <div class="container">
    <div class="row">
      <a href="{{route('checkout')}}">Checkout</a>
    </div>
  </div>
</div>
@endsection
