@extends('frontend.layout.master')

@section('content')

<style>
    .project-tab {
        padding: 10%;
        margin-top: -8%;
    }
    .project-tab #tabs{
        background: #007b5e;
        color: #ffffff;
    }
    .project-tab #tabs h6.section-title{
        color: #eee;
    }
    .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }
    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        font-size: 16px;
        font-weight: 600;
    }
    .project-tab .nav-link:hover {
        border: none;
    }
    .project-tab thead{
        background: #f3f3f3;
        color: #333;
    }
    .project-tab a{
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
    .user-avatar-img img {
        border-radius: 50%;
        border: 1px solid #e4e4e4;
        width: 180px;
        height: 180px;
    }
    .user-avatar-btn {
        margin: 30px 20px 0;
    }
    .user-avatar-btn label {
        border: 1px solid #e4e4e4;
        width: 100%;
        padding: 10px 10px; 
        border-radius: 5px;
        box-shadow: 0 1px 1px 0 rgb(0 0 0 / 3%);
        text-align: center;
        cursor: pointer;
    }
</style>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Order history</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('home')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Order history</p>
        </div>
    </div>
</div>

<div id="tabs" class="project-tab">
    <div class="container shadow-sm bg-body rounded">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <nav>
                    <div class="nav nav-tabs nav-fill">
                        <a href="{{route('profile')}}" class="nav-item nav-link text-primary {{ request()->segment(1) == 'profile' ? 'active' : ''}}">Proflie</a>
                        <a href="{{route('order-history')}}" class="nav-item nav-link text-primary {{ request()->segment(1) == 'order-history' ? 'active' : ''}}" >Order history</a>
                        <a href="{{route('profile.change-password')}}" class="nav-item nav-link text-primary {{ request()->segment(1) == 'change-password' ? 'active' : ''}}">Change password</a>
                    </div>
                </nav>
                <div class="tab-content" >
                    <div class="tab-pane active show">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date / Time</th>
                                    <th class="text-center">Payment</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Total price</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ date_format($order->created_at,"d-m-Y / H:i:s") }}</td>
                                        <td class="text-center">{{ $order->payment == 1 ? 'VNPay' : 'COD'}}</td>
                                        @if($order->status == 0)
                                        <td class="text-center"><span class="status cancel">Cancel</span></td>
                                        @elseif($order->status == 1)
                                        <td class="text-center"><span class="status return">Return</span></td>
                                        @elseif($order->status == 2)
                                        <td class="text-center"><span class="status pending">Pending</span></td>
                                        @elseif($order->status == 3)
                                        <td class="text-center"><span class="status inprogress">In progress</span></td>
                                        @else
                                        <td class="text-center"><span class="status delivered">Delivered</span></td>
                                        @endif
                                        <td class="text-center">{{ number_format($order->total_price) }}đ</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-end">
                                                @if($order->status == 2)
                                                <form action="{{route('order.cancel', $order)}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary cancel mr-3">Cancel</button>
                                                </form>
                                                @elseif($order->status == 3)
                                                <form action="{{route('order.cancel', $order)}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger return mr-3">Return</button>
                                                </form>
                                                <form action="{{route('order.receive', $order)}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info receive mr-3">Receive</button>
                                                </form>
                                                
                                                @endif
                                                <a href="{{route('order.detail', $order)}}" class="btn btn-primary detail">Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="text-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    
</div>

@endsection