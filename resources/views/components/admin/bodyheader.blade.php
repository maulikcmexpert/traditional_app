<!--wrapper-->
<div class="wrapper">

    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <a href="index.php">
                    <img src="{{asset('admin/assets/img/logo.png')}}" class="logo-icon" alt="logo icon">
                    <img src="{{asset('admin/assets/img/close-nav-logo.png')}}" class="small-icon" alt="">
                </a>
            </div>
            <div class="toggle-icon ms-auto"><i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <!--navigation-->
        @include('components.admin.sidebar');
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->

    <!--start header -->
    <header>
        @include('components.admin.navbar');
    </header>
    <!--end header -->