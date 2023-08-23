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
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Profile</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('home')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Profile</p>
        </div>
    </div>
</div>

<div id="tabs" class="project-tab">
    <div class="container shadow-sm bg-body rounded">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link text-primary active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Proflie</a>
                        <a class="nav-item nav-link text-primary" id="nav-order-tab" data-toggle="tab" href="#nav-order" role="tab" aria-controls="nav-order" aria-selected="false">Order history</a>
                        <a class="nav-item nav-link text-primary" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password" aria-selected="false">Change password</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active mt-5" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-7">
                                    <div class="info-account mb-3">
                                        <div class="row">
                                            <div class="col-3 text-right">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-9 text-start text-dark">
                                                {{Auth::guard('web')->user()->email}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-account mb-3">
                                        <div class="row">
                                            <div class="col-3 text-right">
                                                <label>Username</label>
                                            </div>
                                            <div class="col-9 text-start text-dark">
                                                {{Auth::guard('web')->user()->username}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-account mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 text-right">
                                                <label for="name">Name</label>
                                            </div>
                                            <div class="col-9 text-start">
                                                <input class="form-control" type="text" name="name" id="name" value="{{Auth::guard('web')->user()->name}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="info-account mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 text-right">
                                                <label for="phone">Phone</label>
                                            </div>
                                            <div class="col-9 text-start">
                                                <input class="form-control" type="text" name="phone" id="phone" value="{{Auth::guard('web')->user()->phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-account mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 text-right">
                                                <label for="address">Address</label>
                                            </div>
                                            <div class="col-9 text-start">
                                                <input class="form-control" type="text" name="address" id="address" value="{{Auth::guard('web')->user()->address}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mb-5">
                                        <button type="submit"class="btn btn-primary btn-md" >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="col-5 d-flex align-items-center justify-content-center">
                                    <div class="user-avatar">
                                        <div class="user-avatar-img">
                                            <img src="{{ Auth::guard('web')->user()->avatar ?? '/assets/frontend/img/no-avatar.png' }}" id="user-avatar" alt="user-avatar">
                                        </div>
                                        <div class="user-avatar-btn text-primary">
                                            <label for="avatar">Choose Image
                                                <input accept="image/png, image/jpg, image/jpeg" hidden onchange="previewImg(this,'user-avatar')" type="file" name="avatar" id="avatar">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date / Time</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Total price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::guard('web')->user()->orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->payment == 1 ? 'VNPay' : 'COD'}}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->total_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Contest Name</th>
                                    <th>Date</th>
                                    <th>Award Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#">Work 1</a></td>
                                    <td>Doe</td>
                                    <td>john@example.com</td>
                                </tr>
                                <tr>
                                    <td><a href="#">Work 2</a></td>
                                    <td>Moe</td>
                                    <td>mary@example.com</td>
                                </tr>
                                <tr>
                                    <td><a href="#">Work 3</a></td>
                                    <td>Dooley</td>
                                    <td>july@example.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection