<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin - CodeLean eShop</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description"
        content="This is an example dashboard (CodeLean) created using build-in elements and components.">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <link href="/assets/admin/css/main.css" rel="stylesheet">
    <link href="/assets/admin/css/my_style.css" rel="stylesheet">
    <link href="/assets/admin/css/pe-icon-7-stroke.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <div class="app-header header-shadow justify-content-between">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mr-3">
                <div class="font-weight-bold">{{Auth::guard('admin')->user()->name}}</div>
                <div>
                    <form action="{{route('admin.logout')}}" method="post">
                        @csrf
                        <button type="submit">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Menu</li>

                            <li class="mm-active">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-plugin"></i>Applications
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('dashboard.index') }}" class="{{ request()->segment(2) == 'dashboard' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.index') }}" class="{{ request()->segment(2) == 'user' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('order.index') }}" class="{{ request()->segment(2) == 'order' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Order
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.index') }}" class="{{ request()->segment(2) == 'product' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Product
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('category.index')}}" class="{{ request()->segment(2) == 'category' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Category
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('brand.index')}}" class="{{ request()->segment(2) == 'brand' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Brand
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post_type.index')}}" class="{{ request()->segment(2) == 'post_type' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Post type
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('post.index')}}" class="{{ request()->segment(2) == 'post' ? 'mm-active' : ''}}">
                                            <i class="metismenu-icon"></i>Post
                                        </a>
                                    </li>
                                    <li class="nav-item">

                                        <h2 class="report-title">Monthly report </h2>
                                        <form action="{{ route('admin.downloadMonthlyReport') }}" method="GET">
                                            <div class="form-group">
                                                <label for="month">Month:</label>
                                                <select name="month" id="month" class="form-control">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>Month {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="year">Year:</label>
                                                <select name="year" id="year" class="form-control">
                                                    @for ($i = 2024; $i <= date('Y'); $i++) 
                                                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>Year {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Download</button>
                                        </form>
                                        <style>
.nav-item {
    padding: 10px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    margin-bottom: 20px;
    max-width: 400px;
}

.report-title {
    font-size: 1.25rem; /* Kích thước chữ nhỏ hơn */
    margin-bottom: 15px;
    color: #333;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.Btn {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 100px;
  height: 40px;
  border: none;
  padding: 0px 20px;
  background-color: rgb(168, 38, 255);
  color: white;
  font-weight: 500;
  cursor: pointer;
  border-radius: 10px;
  box-shadow: 5px 5px 0px rgb(140, 32, 212);
  transition-duration: .3s;
}

.svg {
  width: 13px;
  position: absolute;
  right: 0;
  margin-right: 20px;
  fill: white;
  transition-duration: .3s;
}

.Btn:hover {
  color: transparent;
}

.Btn:hover svg {
  right: 43%;
  margin: 0;
  padding: 0;
  border: none;
  transition-duration: .3s;
}

.Btn:active {
  transform: translate(3px , 3px);
  transition-duration: .3s;
  box-shadow: 2px 2px 0px rgb(140, 32, 212);
}
</style>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="app-main__outer">

                @yield('content')

            </div>
        </div>

    </div>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/assets/admin/js/jquery-3.2.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/admin/js/main.js"></script>
    <script type="text/javascript" src="/assets/admin/js/my_script.js"></script>
    @stack('scripts')
</body>

</html>