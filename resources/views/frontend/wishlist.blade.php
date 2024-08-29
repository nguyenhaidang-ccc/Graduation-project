@extends('frontend.layout.master')

@section('content')
<div class="container">
    <h1>Your wishlist</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($wishlists->isEmpty())
        <p>Your wishlist is currently empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
           
                    @foreach ($wishlists as $wishlist)
                        <tr>
                            <td>
                            <a href="{{route('product', $wishlist['product_id'])}}">{{ $wishlist->product->name }}</a>
                                    
                            
                            </td>
                            <td>{{ number_format($wishlist->product->price, 0, ',', '.') }}VND</td>
                            <td>
                                <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this product from your favorites list?')">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                   
            </tbody>
        </table>

        {{ $wishlists->links() }} 
    @endif
</div>
@endsection
