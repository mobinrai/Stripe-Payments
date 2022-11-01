@extends('app')
@section('contain')

<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <h4 class="text-danger border-bottom margin">Checkout Products</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Image</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                    <tr>
                        <td>{{Str::substr($item->name, 0, 50)}}</td>
                        <td><img src="{{$item->attributes->image}}" class="img-responsive img-thumbnail" style="width: 30% !important;" alt="Image"></td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price * $item->quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">GrandTotal</td>
                        <td>{{ Cart::getTotal() }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row margin">
        <form action="{{ route('proceedCheckout')}}" method="POST">
            @csrf
            <button type="submit">Proceed to checkout</button>
        </form>
        <form action="{{ route('cart.clear')}}" method="POST">
            @csrf
            <button type="submit">Clear All</button>
        </form>
    </div>
</div>
@endsection
