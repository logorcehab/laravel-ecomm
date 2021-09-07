@extends('customer.layouts.guest')
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Verify Number</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('customer.verify', $customer_id) }}">
                            @csrf
                            <div class="form-group mb-3">
                                <p class="text-center">{{$customer_name}}</p>
                            </div>
                            <div class="form-group mb-3">
                                <p class="text-center">{{$customer_phone}}</p>
                            </div>
                            <div class="form-group mb-3">
                                <input type="tel" id="code" class="form-control" 
                                    name="code">
                                @if ($errors->has('code'))
                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                @endif
                            </div>

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection