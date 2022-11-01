@extends('app')
@section('contain')
<div class="container margin">
    <div class="row">
        <div class="col-lg-12">
            <h1>Thanks for your order!</h1>
            {{$customer->name}}
            <h4>Your Order Details</h4><br>
            Your Order Id: {{$order->id}}<br>
            Total Price : {{$order->total_price}}
            <p>
                We appreciate your business!
                If you have any questions, please email
                <a href="mailto:orders@example.com">orders@example.com</a>.
            </p>
        </div>
    </div>
</div>
@endsection