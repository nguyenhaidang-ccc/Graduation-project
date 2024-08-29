@extends('frontend.layout.master')

@section('content')

<div id="notification">
    <div class="container">
        <div class="text-center">
            <span class="text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="5em" viewBox="0 0 512 512">
                    <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 
                    512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/>
                </svg>
                <h4 class="text-success mt-2 mb-3">Success</h4>
            </span>
            <p>
                Thank you, your order has been successful, the order will be shipped in the next few days.
            </p>
        </div>
    </div>
</div>

@endsection