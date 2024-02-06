@extends('layouts.layout')
@section('content')
<!-- -----content-page---- -->
<section class="page-wrapper">
    <div class="page-content">
        <!-- -----header-breadcrumb-start-- -->
        <div class="header-breadcrumb">
            <h5>Dashboard</h5>
            <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Admingo</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <!-- -----header-breadcrumb-end-- -->
        
        <!-- ----our-total-info-start--- -->
        <div class="our-total-info">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <div class="common-card Total Revenue">
                        <h3>34,152</h3>
                        <p>Total Revenue</p>
                        <h6>
                            <span class="up">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <mask id="mask0_0_1111" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_0_1111)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00009 12.3001H5.40009V7.50014H2.49609L7.20009 2.79614L11.9041 7.50014H9.00009V12.3001Z" fill="#34C38F"/>
                                </g>
                                </svg>
                                2.65%
                            </span>  
                            since last week
                        </h6>
                        <div class="extra-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="67" height="35" viewBox="0 0 67 35" fill="none">
                                <rect x="64" y="14" width="3" height="21" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="57" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="51" y="21" width="3" height="14" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="44" y="27" width="3" height="8" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="38" y="18" width="3" height="17" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="32" y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="25" y="10" width="3" height="25" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="19" width="3" height="35" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="13" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="6" y="9" width="3" height="26" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <div class="common-card Orders">
                        <h3>5,643</h3>
                        <p>Orders</p>
                        <h6>
                            <span class="down">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <mask id="mask0_0_1090" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_0_1090)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.40009 2.69995H9.00009V7.49995H11.9041L7.20009 12.204L2.49609 7.49995H5.40009V2.69995Z" fill="#F46A6A"/>
                                </g>
                                </svg>
                                0.82%
                            </span>  
                            since last week
                        </h6>
                        <div class="extra-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                                <circle cx="17.5" cy="17.5" r="15" stroke="#F2F2F2" stroke-opacity="0.85098" stroke-width="4"/>
                                <circle cx="17.5" cy="17.5" r="15" transform="rotate(90 17.5 17.5)" stroke="#34C38F" stroke-opacity="0.85098" stroke-width="4" stroke-dasharray="76 69"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <div class="common-card Orders">
                        <h3>45,254</h3>
                        <p>Customers</p>
                        <h6>
                            <span class="down">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <mask id="mask0_0_1090" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_0_1090)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.40009 2.69995H9.00009V7.49995H11.9041L7.20009 12.204L2.49609 7.49995H5.40009V2.69995Z" fill="#F46A6A"/>
                                </g>
                                </svg>
                                6.24%
                            </span>  
                            since last week
                        </h6>
                        <div class="extra-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                                <circle cx="17.5" cy="17.5" r="15" stroke="#F2F2F2" stroke-opacity="0.85098" stroke-width="4"/>
                                <circle cx="17.5" cy="17.5" r="15" transform="rotate(90 17.5 17.5)" stroke="#34C38F" stroke-opacity="0.85098" stroke-width="4" stroke-dasharray="76 69"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <div class="common-card Growth">
                        <h3>+ 12.58%</h3>
                        <p>Growth</p>
                        <h6>
                            <span class="up">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <mask id="mask0_0_1111" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_0_1111)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00009 12.3001H5.40009V7.50014H2.49609L7.20009 2.79614L11.9041 7.50014H9.00009V12.3001Z" fill="#34C38F"/>
                                </g>
                                </svg>
                                10.51%
                            </span>  
                            since last week
                        </h6>
                        <div class="extra-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="67" height="35" viewBox="0 0 67 35" fill="none">
                                <rect x="64" y="14" width="3" height="21" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="57" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="51" y="21" width="3" height="14" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="44" y="27" width="3" height="8" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="38" y="18" width="3" height="17" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="32" y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="25" y="10" width="3" height="25" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="19" width="3" height="35" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="13" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect x="6" y="9" width="3" height="26" fill="#304FFD" fill-opacity="0.85098"/>
                                <rect y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ---our-total-info-end--- -->

        <!-- -----graph-upgradeaccoutn-selling-product----- -->
        <div class="row">
            <div class="col-xxl-8">
                <div class="visitors-chart-wrp">
                    <div class="visitors-chart-header">
                        <h3>Visitors</h3>
                        <div class="visitors-chart-button">
                            <button>All</button>
                            <button>1M</button>
                            <button>6M</button>
                            <button class="active">1Y</button>
                        </div>
                    </div>
                    <div class="yearly-info">
                        <div class="data-info">
                            <p>Today</p>
                            <h4>1024</h4>
                        </div>
                        <div class="data-info">
                            <p>This Month</p>
                            <h4>12356 
                                <span>0.2  % 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <mask id="mask0_0_3004" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="13" height="13">
                                    <rect width="13" height="13" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_3004)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04163 10.8333H5.95829V4.3333L2.97913 7.31246L2.20996 6.5433L6.49996 2.2533L10.79 6.5433L10.0208 7.31246L7.04163 4.3333V10.8333Z" fill="#34C38F"/>
                                    </g>
                                    </svg>
                                </span>
                            </h4>
                        </div>
                        <div class="data-info">
                            <p>This Year</p>
                            <h4>102354 
                                <span>0. 1 %
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <mask id="mask0_0_3004" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="13" height="13">
                                    <rect width="13" height="13" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_3004)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04163 10.8333H5.95829V4.3333L2.97913 7.31246L2.20996 6.5433L6.49996 2.2533L10.79 6.5433L10.0208 7.31246L7.04163 4.3333V10.8333Z" fill="#34C38F"/>
                                    </g>
                                    </svg>
                                </span>
                            </h4>
                        </div>
                    </div>
                    
                    <div id="Visitors-charts"></div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="row h-100">
                    <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 mb-3">
                        <div class="upgrade-account">
                            <div class="upgrade-account-content">
                                <h3>Enhance your <span>Campaign</span> for better outreach <i class="fa-solid fa-arrow-right"></i></h3>
                                <button>Upgrade Account!</button>
                            </div>
                            <div class="upgrade-account-img">
                                <img src="{{asset('admin/assets/img/upgrad-account-img.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6">
                        <div class="top-selling-product-info">
                            <div class="top-selling-product-title">
                                <h3>Top Selling Products</h3>
                                <div class="sort-product">
                                    <span>Sort By:</span>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Yearly</option>
                                        <option value="1">Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="top-selling-progress-bar">
                                <h6><span></span>Desktops</h6>
                                <div class="progress">
                                    <div class="progress-bar desktops-bar" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="top-selling-progress-bar">
                                <h6><span class="iPhones-circle"></span>iPhones</h6>
                                <div class="progress">
                                    <div class="progress-bar iPhones-bar" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="top-selling-progress-bar">
                                <h6><span class="Android-circle"></span>Android</h6>
                                <div class="progress">
                                    <div class="progress-bar Android-bar" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="top-selling-progress-bar">
                                <h6><span class="Tablets-circle"></span>Tablets</h6>
                                <div class="progress">
                                    <div class="progress-bar Tablets-bar" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="top-selling-progress-bar">
                                <h6><span class="Cables-circle"></span>Cables</h6>
                                <div class="progress">
                                    <div class="progress-bar Cables-bar" role="progressbar" style="width: 10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -----graph-upgradeaccoutn-selling-product----- -->

        <!-- ----top-user--activity-social--- -->
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
                <div class="top-user-wrp">
                    <div class="top-user-title">
                        <h3>Top Users</h3>
                        <select class="form-select" aria-label="Default select example">
                            <option selected="">All Members</option>
                            <option value="1">Monthly</option>
                        </select>
                    </div>
                    <div class="top-user-info">
                        <table class="display" style="width:100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="user-details">
                                            <div class="user-img">
                                                <img src="{{asset('admin/assets/img/user-img-1.png')}}" alt="user-img">
                                            </div>
                                            <div class="user-content">
                                                <h6>Glenn Holden</h6>
                                                <p><i class="fa-solid fa-location-dot"></i> Nevada</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cancel-status">Cancel</span>
                                    </td>
                                    <td>
                                        <p class="user-price">$250.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-details">
                                            <div class="user-img">
                                                <img src="{{asset('admin/assets/img/user-img-1.png')}}" alt="user-img">
                                            </div>
                                            <div class="user-content">
                                                <h6>Lolita Hamill</h6>
                                                <p><i class="fa-solid fa-location-dot"></i> Texas</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="success-status">Success</span>
                                    </td>
                                    <td>
                                        <p class="user-price">$250.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-details">
                                            <div class="user-img">
                                                <img src="{{asset('admin/assets/img/user-img-1.png')}}" alt="user-img">
                                            </div>
                                            <div class="user-content">
                                                <h6>Lolita Hamill</h6>
                                                <p><i class="fa-solid fa-location-dot"></i> Texas</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="active-status">Active</span>
                                    </td>
                                    <td>
                                        <p class="user-price">$250.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-details">
                                            <div class="user-img">
                                                <img src="{{asset('admin/assets/img/user-img-1.png')}}" alt="user-img">
                                            </div>
                                            <div class="user-content">
                                                <h6>Lolita Hamill</h6>
                                                <p><i class="fa-solid fa-location-dot"></i> Texas</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="pending-status">Pending</span>
                                    </td>
                                    <td>
                                        <p class="user-price">$250.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-details">
                                            <div class="user-img">
                                                <img src="{{asset('admin/assets/img/user-img-1.png')}}" alt="user-img">
                                            </div>
                                            <div class="user-content">
                                                <h6>Lolita Hamill</h6>
                                                <p><i class="fa-solid fa-location-dot"></i> Texas</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="active-status">Active</span>
                                    </td>
                                    <td>
                                        <p class="user-price">$250.00</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
                <div class="recent-activity-wrp">
                    <div class="top-user-title">
                        <h3>Recent Activity</h3>
                        <select class="form-select" aria-label="Default select example">
                            <option selected="">Recent</option>
                            <option value="1">Monthly</option>
                        </select>
                    </div>
                    <div class="recent-activity-detail">
                        <ol class="activity-feed">
                            <li class="feed-item">
                                <time class="date" datetime="9-25">Today <span>12:20 pm</span></time>
                                <span class="text">Andrei Coman magna sed porta finibus, risus posted a new article: <a href="single-need.php"> Forget UX Rowland</a></span>
                            </li>
                            <li class="feed-item">
                                <time class="date" datetime="9-25">22 Jul, 2020 <span>12:20 pm</span></time>
                                <span class="text">Andrei Coman posted a new article:<a href="single-need.php"> Designer Alex</a></span>
                            </li>
                            <li class="feed-item">
                                <time class="date" datetime="9-25">18 Jul, 2020 <span>07:56 am</span></time>
                                <span class="text">Zack Wetass, sed porta finibus, risus Chris Wallace Commented <a href="single-need.php"> Developer Moreno</a></span>
                            </li>
                            <li class="feed-item">
                                <time class="date" datetime="9-25">10 Jul, 2020 <span>08:42 pm</span></time>
                                <span class="text">Zack Wetass, Chris combined Commented <a href="single-need.php"> UX Murphy</a></span>
                            </li> 
                            <li class="feed-item">
                                <time class="date" datetime="9-25">10 Jul, 2020 <span>08:42 pm</span></time>
                                <span class="text">Zack Wetass, Chris combined Commented <a href="single-need.php"> UX Murphy</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
                <div class="social-source-wrp">
                    <div class="top-user-title">
                        <h3>Social Source</h3>
                        <select class="form-select" aria-label="Default select example">
                            <option selected="">Monthly</option>
                            <option value="1">Monthly</option>
                        </select>
                    </div>
                    <div class="social-source-detail">
                        <div class="social-main-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <rect width="48" height="48" rx="24" fill="#5B73E8" fill-opacity="0.25098"/>
                                <mask id="mask0_0_531" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="12" y="12" width="24" height="24">
                                <rect x="12" y="12" width="24" height="24" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_0_531)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 14.04C18.5 14.04 14 18.53 14 24.06C14 29.06 17.66 33.21 22.44 33.96V26.96H19.9V24.06H22.44V21.85C22.44 19.34 23.93 17.96 26.22 17.96C27.31 17.96 28.45 18.15 28.45 18.15V20.62H27.19C25.95 20.62 25.56 21.39 25.56 22.18V24.06H28.34L27.89 26.96H25.56V33.96C30.4288 33.1911 34.0111 28.9891 34 24.06C34 18.53 29.5 14.04 24 14.04Z" fill="#304FFD"/>
                                </g>
                            </svg>
                        </div>
                        <div class="social-main-content">
                            <h3>Facebook - <span>125 sales</span></h3>
                            <p>Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus tincidunt.</p>
                            <a href="">Learn more <i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="more-social-source-wrp">
                        <div class="inner-source-wrp">
                            <div class="more-social-source">
                                <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                    <rect x="0.5" y="0.5" width="32" height="32" rx="16" fill="#304FFD"/>
                                    <mask id="mask0_0_519" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="8" y="8" width="17" height="17">
                                        <rect x="8.5" y="8.5" width="16" height="16" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_519)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5002 9.85999C12.8335 9.85999 9.8335 12.8533 9.8335 16.54C9.8335 19.8733 12.2735 22.64 15.4602 23.14V18.4733H13.7668V16.54H15.4602V15.0667C15.4602 13.3933 16.4535 12.4733 17.9802 12.4733C18.7068 12.4733 19.4668 12.6 19.4668 12.6V14.2467H18.6268C17.8002 14.2467 17.5402 14.76 17.5402 15.2867V16.54H19.3935L19.0935 18.4733H17.5402V23.14C20.786 22.6274 23.1742 19.826 23.1668 16.54C23.1668 12.8533 20.1668 9.85999 16.5002 9.85999Z" fill="white"/>
                                    </g>
                                </svg>
                                <h6>Facebook</h6>
                                <p>125 sales</p>
                            </div>
                            <div class="more-social-source">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                    <rect y="0.5" width="32" height="32" rx="16" fill="#50A5F1"/>
                                    <mask id="mask0_0_511" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="8" y="8" width="16" height="17">
                                        <rect x="8" y="8.5" width="16" height="16" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_511)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.973 12.5C22.4597 12.7333 21.9064 12.8866 21.333 12.96C21.9197 12.6066 22.373 12.0466 22.5864 11.3733C22.033 11.7066 21.4197 11.94 20.773 12.0733C20.2464 11.5 19.5064 11.1666 18.6664 11.1666C17.0997 11.1666 15.8197 12.4466 15.8197 14.0266C15.8197 14.2533 15.8464 14.4733 15.893 14.68C13.5197 14.56 11.4064 13.42 9.9997 11.6933C9.75303 12.1133 9.61303 12.6066 9.61303 13.1266C9.61303 14.12 10.113 15 10.8864 15.5C10.413 15.5 9.97303 15.3666 9.58637 15.1666C9.58637 15.1666 9.58637 15.1666 9.58637 15.1866C9.58637 16.5733 10.573 17.7333 11.8797 17.9933C11.6397 18.06 11.3864 18.0933 11.1264 18.0933C10.9464 18.0933 10.7664 18.0733 10.593 18.04C10.953 19.1666 11.9997 20.0066 13.2597 20.0266C12.2864 20.8 11.053 21.2533 9.70637 21.2533C9.4797 21.2533 9.25303 21.24 9.02637 21.2133C10.293 22.0266 11.7997 22.5 13.413 22.5C18.6664 22.5 21.553 18.14 21.553 14.36C21.553 14.2333 21.553 14.1133 21.5464 13.9866C22.1064 13.5866 22.5864 13.08 22.973 12.5Z" fill="white"/>
                                    </g>
                                </svg>
                                <h6>Twitter</h6>
                                <p>112 sales</p>
                            </div>
                            <div class="more-social-source">
                                <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                    <rect x="0.5" y="0.5" width="32" height="32" rx="16" fill="#E83E8C"/>
                                    <mask id="mask0_0_498" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="8" y="8" width="17" height="17">
                                        <rect x="8.5" y="8.5" width="16" height="16" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_498)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7002 9.83337H19.3002C21.4335 9.83337 23.1668 11.5667 23.1668 13.7V19.3C23.1668 21.4355 21.4357 23.1667 19.3002 23.1667H13.7002C11.5668 23.1667 9.8335 21.4334 9.8335 19.3V13.7C9.8335 11.5645 11.5647 9.83337 13.7002 9.83337ZM13.5669 11.1667C12.2414 11.1667 11.1669 12.2413 11.1669 13.5667L11.1669 19.4334C11.1669 20.7601 12.2402 21.8334 13.5669 21.8334H19.4335C20.759 21.8334 21.8335 20.7589 21.8335 19.4334L21.8335 13.5667C21.8335 12.2401 20.7602 11.1667 19.4335 11.1667H13.5669ZM20.0002 12.1667C20.4604 12.1667 20.8335 12.5398 20.8335 13.0001C20.8335 13.4603 20.4604 13.8334 20.0002 13.8334C19.54 13.8334 19.1669 13.4603 19.1669 13.0001C19.1669 12.5398 19.54 12.1667 20.0002 12.1667ZM16.5002 13.1667C18.3412 13.1667 19.8335 14.6591 19.8335 16.5001C19.8335 18.341 18.3412 19.8334 16.5002 19.8334C14.6593 19.8334 13.1669 18.341 13.1669 16.5001C13.1669 14.6591 14.6593 13.1667 16.5002 13.1667ZM16.5001 14.5C15.3956 14.5 14.5001 15.3954 14.5001 16.5C14.5001 17.6046 15.3956 18.5 16.5001 18.5C17.6047 18.5 18.5001 17.6046 18.5001 16.5C18.5001 15.3954 17.6047 14.5 16.5001 14.5Z" fill="white"/>
                                    </g>
                                </svg>
                                <h6>Instagram</h6>
                                <p>104 sales</p>
                            </div>
                        </div>
                        <a href="" class="view-all-btn">View All Sources  <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- ----top-user--activity-social--- -->

        <!-- ----latest-transaction--- -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="latest-transaction-wrp ">
                    <h3>Latest Transaction</h3>
                    <div class="latest-transaction-table">
                        <table id="example" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        <button style="border: none; background: transparent; font-size: 14px;" id="MyTableCheckAllButton">
                                        <i class="far fa-square"></i>  
                                        </button>
                                    </th>
                                    <th>Order ID</th>
                                    <th>Billing Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Payment Method</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>#MN0131</td>
                                    <td>Roy Michael</td>
                                    <td>09 Jul, 2020</td>
                                    
                                    <td>$130</td>
                                    <td><span class="badge bg-danger">Chargeback</span></td>
                                    <td>
                                        <span class="payment-method-wrp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <mask id="mask0_0_2299" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                                    <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                                </mask>
                                                <g mask="url(#mask0_0_2299)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0725 11.8396C12.0725 12.0308 11.9575 12.1686 11.7925 12.1686C11.6225 12.1686 11.5125 12.0224 11.5125 11.8396C11.5125 11.6567 11.6225 11.5105 11.7925 11.5105C11.9575 11.5105 12.0725 11.6567 12.0725 11.8396ZM4.30246 11.5105C4.12496 11.5105 4.02246 11.6567 4.02246 11.8396C4.02246 12.0224 4.12496 12.1686 4.30246 12.1686C4.46496 12.1686 4.57496 12.0308 4.57496 11.8396C4.57246 11.6567 4.46496 11.5105 4.30246 11.5105ZM7.23994 11.5021C7.10494 11.5021 7.02244 11.6005 7.00244 11.7468H7.47994C7.45744 11.5865 7.36994 11.5021 7.23994 11.5021ZM9.9351 11.5105C9.7651 11.5105 9.6626 11.6567 9.6626 11.8396C9.6626 12.0224 9.7651 12.1686 9.9351 12.1686C10.1051 12.1686 10.2151 12.0308 10.2151 11.8396C10.2151 11.6567 10.1051 11.5105 9.9351 11.5105ZM12.5825 12.2446C12.5825 12.253 12.59 12.2587 12.59 12.2755C12.59 12.284 12.5825 12.2896 12.5825 12.3065C12.575 12.3149 12.575 12.3205 12.57 12.329C12.5625 12.3374 12.5575 12.343 12.5425 12.343C12.535 12.3515 12.53 12.3515 12.515 12.3515C12.5075 12.3515 12.5025 12.3515 12.4875 12.343C12.48 12.343 12.475 12.3346 12.4675 12.329C12.46 12.3205 12.455 12.3149 12.455 12.3065C12.4475 12.2924 12.4475 12.284 12.4475 12.2755C12.4475 12.2615 12.4475 12.253 12.455 12.2446C12.455 12.2305 12.4625 12.2221 12.4675 12.2137C12.475 12.2052 12.48 12.2052 12.4875 12.1996C12.5 12.1912 12.5075 12.1912 12.515 12.1912C12.5275 12.1912 12.535 12.1912 12.5425 12.1996C12.555 12.208 12.5625 12.208 12.57 12.2137C12.5775 12.2193 12.575 12.2305 12.5825 12.2446ZM12.5275 12.2839C12.54 12.2839 12.54 12.2755 12.5475 12.2755C12.555 12.267 12.555 12.2614 12.555 12.253C12.555 12.2445 12.555 12.2389 12.5475 12.2305C12.54 12.2305 12.535 12.222 12.52 12.222H12.48V12.3205H12.5V12.2811H12.5075L12.535 12.3205H12.555L12.5275 12.2839L12.5275 12.2839ZM14.4 2.57803V12.478C14.4 13.2233 13.8625 13.828 13.2 13.828H1.2C0.5375 13.828 0 13.2233 0 12.478V2.57803C0 1.83271 0.5375 1.22803 1.2 1.22803H13.2C13.8625 1.22803 14.4 1.83271 14.4 2.57803ZM1.6001 6.50431C1.6001 8.65587 3.1526 10.3996 5.0626 10.3996C5.7426 10.3996 6.4101 10.169 6.9751 9.74993C5.1526 8.08212 5.1651 4.93494 6.9751 3.26712C6.4101 2.84525 5.7426 2.61744 5.0626 2.61744C3.1526 2.61462 1.6001 4.36118 1.6001 6.50431ZM7.20005 9.56433C8.96255 8.01745 8.95505 5.00246 7.20005 3.44714C5.44505 5.00246 5.43755 8.02027 7.20005 9.56433ZM3.64255 11.7102C3.64255 11.4655 3.50005 11.3052 3.27505 11.2968C3.16005 11.2968 3.03755 11.3361 2.95505 11.4796C2.89505 11.3643 2.79255 11.2968 2.65005 11.2968C2.55505 11.2968 2.46005 11.3361 2.38505 11.4486V11.3249H2.18005V12.3571H2.38505C2.38505 11.8255 2.32255 11.5077 2.61005 11.5077C2.86505 11.5077 2.81505 11.7946 2.81505 12.3571H3.01255C3.01255 11.8424 2.95005 11.5077 3.23755 11.5077C3.49255 11.5077 3.44255 11.7889 3.44255 12.3571H3.64755V11.7102H3.64255ZM4.76495 11.3249H4.56745V11.4486C4.49995 11.3558 4.40495 11.2968 4.27495 11.2968C4.01745 11.2968 3.81995 11.5274 3.81995 11.8396C3.81995 12.1546 4.01745 12.3824 4.27495 12.3824C4.40495 12.3824 4.49995 12.3289 4.56745 12.2305V12.3599H4.76495V11.3249ZM5.7774 12.0449C5.7774 11.623 5.2049 11.8143 5.2049 11.6174C5.2049 11.4571 5.5024 11.4824 5.6674 11.5865L5.7499 11.4036C5.5149 11.2321 4.9949 11.2349 4.9949 11.6343C4.9949 12.0365 5.5674 11.8677 5.5674 12.0561C5.5674 12.2333 5.2299 12.2193 5.0499 12.0786L4.9624 12.2558C5.2424 12.4696 5.7774 12.4246 5.7774 12.0449V12.0449ZM6.66247 12.3064L6.60747 12.1152C6.51247 12.1743 6.30247 12.2389 6.30247 11.9999V11.533H6.62997V11.3249H6.30247V11.0099H6.09747V11.3249H5.90747V11.5302H6.09747V11.9999C6.09747 12.4949 6.52997 12.4049 6.66247 12.3064H6.66247ZM6.99498 11.9296H7.68248C7.68248 11.4739 7.49748 11.2939 7.24748 11.2939C6.98248 11.2939 6.79248 11.5161 6.79248 11.8368C6.79248 12.4133 7.35748 12.5089 7.63748 12.2361L7.54248 12.0674C7.34748 12.2474 7.05248 12.2305 6.99498 11.9296ZM8.47245 11.325C8.35745 11.2687 8.18245 11.2743 8.09245 11.4487V11.325H7.88745V12.3571H8.09245V11.775C8.09245 11.4487 8.32995 11.4909 8.41245 11.5387L8.47245 11.325H8.47245ZM8.73747 11.8396C8.73747 11.519 9.02747 11.4149 9.25497 11.6033L9.34997 11.4205C9.05997 11.1646 8.53247 11.3052 8.53247 11.8424C8.53247 12.3993 9.09247 12.5118 9.34997 12.2643L9.25497 12.0815C9.02497 12.2643 8.73747 12.1546 8.73747 11.8396ZM10.405 11.3249H10.2V11.4487C9.99251 11.1393 9.45251 11.3137 9.45251 11.8396C9.45251 12.3796 10.0125 12.5343 10.2 12.2306V12.3599H10.405V11.3249ZM11.2475 11.3249C11.1875 11.2911 10.9725 11.2433 10.8675 11.4486V11.3249H10.67V12.3571H10.8675V11.7749C10.8675 11.4655 11.0925 11.4852 11.1875 11.5386L11.2475 11.3249H11.2475ZM12.2551 10.9059H12.0576V11.4487C11.8526 11.1421 11.3101 11.3053 11.3101 11.8396C11.3101 12.3853 11.8726 12.5315 12.0576 12.2306V12.3599H12.2551V10.9059V10.9059ZM12.445 8.79362V8.92299H12.465V8.79362H12.5125V8.77112H12.3975V8.79362H12.445H12.445ZM12.61 12.2756C12.61 12.2615 12.61 12.2446 12.6025 12.2306C12.595 12.2221 12.59 12.2081 12.5825 12.1996C12.575 12.1912 12.5625 12.1856 12.555 12.1771C12.5425 12.1771 12.5275 12.1687 12.515 12.1687C12.5075 12.1687 12.495 12.1771 12.48 12.1771C12.4675 12.1856 12.46 12.1912 12.4525 12.1996C12.44 12.2081 12.4325 12.2221 12.4325 12.2306C12.425 12.2446 12.425 12.2615 12.425 12.2756C12.425 12.284 12.425 12.2981 12.4325 12.315C12.4325 12.3234 12.44 12.3375 12.4525 12.3459C12.46 12.3543 12.465 12.36 12.48 12.3684C12.4925 12.3768 12.5075 12.3768 12.515 12.3768C12.5275 12.3768 12.5425 12.3768 12.555 12.3684C12.5625 12.36 12.575 12.3543 12.5825 12.3459C12.59 12.3375 12.595 12.3234 12.6025 12.315C12.61 12.2981 12.61 12.284 12.61 12.2756ZM12.69 8.76831H12.655L12.615 8.86675L12.575 8.76831H12.54V8.92019H12.56V8.80487L12.6 8.90331H12.6275L12.6625 8.80487V8.92019H12.69V8.76831ZM12.8 6.50431C12.8 4.36119 11.2475 2.61462 9.33755 2.61462C8.65755 2.61462 7.99005 2.84525 7.42505 3.26431C9.22755 4.93212 9.25505 8.08775 7.42505 9.74712C7.99005 10.169 8.66255 10.3968 9.33755 10.3968C11.2475 10.3996 12.8 8.65587 12.8 6.50431Z" fill="#495057"/>
                                                </g>
                                            </svg>
                                            Mastercard
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="view_details">View Details</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>#MN0132</td>
                                    <td>Melvin Martin</td>
                                    <td>10 Jul, 2020</td>
                                    
                                    <td>$142</td>
                                    <td><span class="badge bg-success">paid</span></td>
                                    <td>
                                        <span class="payment-method-wrp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <mask id="mask0_0_2275" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                                    <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                                </mask>
                                                <g mask="url(#mask0_0_2275)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7525 6.80546C11.7525 6.80546 11.9425 7.85171 11.985 8.07109H11.15C11.2325 7.82078 11.55 6.84765 11.55 6.84765C11.545 6.85609 11.6325 6.59171 11.6825 6.42859L11.7525 6.80546L11.7525 6.80546ZM14.4 2.5502V12.4502C14.4 13.1955 13.8625 13.8002 13.2 13.8002H1.2C0.5375 13.8002 0 13.1955 0 12.4502V2.5502C0 1.80488 0.5375 1.2002 1.2 1.2002H13.2C13.8625 1.2002 14.4 1.80488 14.4 2.5502ZM3.81255 9.61524L5.39255 5.25024H4.33005L3.34755 8.23149L3.24005 7.62681L2.89005 5.61868C2.83255 5.34024 2.65505 5.26149 2.43505 5.25024H0.817549L0.800049 5.33743C1.19505 5.44993 1.54755 5.61306 1.85505 5.81837L2.75005 9.61524H3.81255ZM6.17254 9.62087L6.80254 5.25024H5.79754L5.17004 9.62087H6.17254V9.62087ZM9.67005 8.19202C9.67505 7.6942 9.40505 7.31452 8.82755 7.00233C8.47505 6.80264 8.26005 6.66764 8.26005 6.46233C8.26505 6.2767 8.44255 6.08545 8.83755 6.08545C9.16505 6.07702 9.40505 6.1642 9.58505 6.25139L9.67505 6.2992L9.81255 5.3542C9.61505 5.26702 9.30005 5.16858 8.91255 5.16858C7.92005 5.16858 7.22255 5.76483 7.21755 6.6142C7.21005 7.24139 7.71755 7.59014 8.09755 7.80108C8.48505 8.01483 8.61755 8.15545 8.61755 8.34389C8.61255 8.63639 8.30255 8.77139 8.01505 8.77139C7.61505 8.77139 7.40005 8.70108 7.07255 8.53796L6.94005 8.46764L6.80005 9.44921C7.03505 9.57014 7.47005 9.67702 7.92005 9.68264C8.97505 9.68546 9.66255 9.09764 9.67005 8.19202H9.67005ZM13.2 9.62087L12.39 5.25024H11.6125C11.3725 5.25024 11.19 5.32899 11.0875 5.61306L9.59497 9.62087H10.65C10.65 9.62087 10.8225 9.08087 10.86 8.96556H12.15C12.18 9.12024 12.27 9.62087 12.27 9.62087H13.2Z" fill="#495057"/>
                                                </g>
                                            </svg>
                                            Visa
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="view_details">View Details</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>#MN0131</td>
                                    <td>Roy Michael</td>
                                    <td>09 Jul, 2020</td>
                                    
                                    <td>$130</td>
                                    <td><span class="badge bg-success">paid</span></td>
                                    <td>
                                        <span class="payment-method-wrp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <mask id="mask0_0_2246" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                                    <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                                </mask>
                                                <g mask="url(#mask0_0_2246)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.65752 7.56204C4.65752 7.90516 4.41502 8.16672 4.10752 8.16672C3.87752 8.16672 3.70752 8.02047 3.70752 7.74485C3.70752 7.40172 3.94502 7.1261 4.25002 7.1261C4.48252 7.1261 4.65752 7.28641 4.65752 7.56204ZM2.01252 6.198H1.89502C1.85752 6.198 1.82002 6.22612 1.81502 6.27394L1.70752 7.02487L1.91252 7.01644C2.18752 7.01644 2.40002 6.97425 2.45002 6.61706C2.50752 6.24019 2.29502 6.198 2.01252 6.198ZM9.11244 6.198H8.99994C8.95494 6.198 8.92494 6.22612 8.91994 6.27394L8.81494 7.02487L9.01494 7.01644C9.33994 7.01644 9.56494 6.93206 9.56494 6.51019C9.56244 6.21206 9.32494 6.198 9.11244 6.198L9.11244 6.198ZM14.4 2.5502V12.4502C14.4 13.1955 13.8625 13.8002 13.2 13.8002H1.2C0.5375 13.8002 0 13.1955 0 12.4502V2.5502C0 1.80488 0.5375 1.2002 1.2 1.2002H13.2C13.8625 1.2002 14.4 1.80488 14.4 2.5502ZM3.20753 6.3583C3.20753 5.76768 2.80253 5.5708 2.34003 5.5708H1.34003C1.27753 5.5708 1.21503 5.62705 1.21003 5.70299L0.800029 8.57455C0.792529 8.6308 0.830029 8.68705 0.880029 8.68705H1.35503C1.42253 8.68705 1.48503 8.60549 1.49253 8.52674L1.60503 7.77861C1.63003 7.57611 1.93503 7.64643 2.05503 7.64643C2.77003 7.64643 3.20753 7.1683 3.20753 6.3583L3.20753 6.3583ZM5.31256 6.6058H4.83756C4.74256 6.6058 4.73756 6.76049 4.73256 6.83643C4.58756 6.59736 4.37756 6.55518 4.14006 6.55518C3.52756 6.55518 3.06006 7.15986 3.06006 7.82643C3.06006 8.37486 3.36506 8.73205 3.85256 8.73205C4.07756 8.73205 4.35756 8.59424 4.51506 8.39736C4.50256 8.43955 4.49006 8.52955 4.49006 8.57174C4.49006 8.63643 4.51506 8.68424 4.57006 8.68424H5.00006C5.06756 8.68424 5.12506 8.60268 5.13756 8.52393L5.39256 6.71549C5.40006 6.66205 5.36256 6.6058 5.31256 6.6058V6.6058ZM6.32501 9.35927L7.91751 6.75489C7.93001 6.74083 7.93001 6.72677 7.93001 6.70708C7.93001 6.65927 7.89251 6.60864 7.85001 6.60864H7.37001C7.32751 6.60864 7.28251 6.63677 7.25751 6.67896L6.59501 7.77583L6.32001 6.72114C6.30001 6.65927 6.24501 6.60864 6.18251 6.60864H5.71501C5.67251 6.60864 5.63501 6.65927 5.63501 6.70708C5.63501 6.74083 6.12251 8.30458 6.16501 8.45364C6.09751 8.56052 5.65251 9.25802 5.65251 9.34239C5.65251 9.39302 5.69001 9.43239 5.73251 9.43239H6.21251C6.25751 9.42958 6.30001 9.40145 6.32501 9.35927H6.32501ZM10.3075 6.3583C10.3075 5.76768 9.90249 5.5708 9.43999 5.5708H8.44749C8.37999 5.5708 8.31749 5.62705 8.30999 5.70299L7.90499 8.57174C7.89999 8.62799 7.93749 8.68424 7.98499 8.68424H8.49749C8.54749 8.68424 8.58499 8.64205 8.59749 8.59424L8.70999 7.77861C8.73499 7.57611 9.03999 7.64643 9.15999 7.64643C9.86999 7.64643 10.3075 7.1683 10.3075 6.3583L10.3075 6.3583ZM12.4125 6.6058H11.9375C11.8425 6.6058 11.8375 6.76049 11.83 6.83643C11.6925 6.59736 11.48 6.55518 11.2375 6.55518C10.625 6.55518 10.1575 7.15986 10.1575 7.82643C10.1575 8.37486 10.4625 8.73205 10.95 8.73205C11.1825 8.73205 11.4625 8.59424 11.6125 8.39736C11.605 8.43955 11.5875 8.52955 11.5875 8.57174C11.5875 8.63643 11.6125 8.68424 11.6675 8.68424H12.1C12.1675 8.68424 12.225 8.60268 12.2375 8.52393L12.4925 6.71549C12.5 6.66205 12.4625 6.6058 12.4125 6.6058V6.6058ZM13.5999 5.66924C13.5999 5.61299 13.5624 5.5708 13.5199 5.5708H13.0574C13.0199 5.5708 12.9824 5.60455 12.9774 5.64674L12.5724 8.57174L12.5649 8.5858C12.5649 8.63643 12.6024 8.68424 12.6524 8.68424H13.0649C13.1274 8.68424 13.1899 8.60268 13.1949 8.52393L13.5999 5.67768V5.66924V5.66924ZM11.35 7.1261C11.045 7.1261 10.8075 7.39891 10.8075 7.74485C10.8075 8.01766 10.9825 8.16672 11.2125 8.16672C11.5125 8.16672 11.755 7.90797 11.755 7.56204C11.7575 7.28641 11.5825 7.1261 11.35 7.1261Z" fill="#495057"/>
                                                </g>
                                            </svg>
                                            Paypal
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="view_details">View Details</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>#MN0132</td>
                                    <td>Melvin Martin</td>
                                    <td>10 Jul, 2020</td>
                                    
                                    <td>$142</td>
                                    <td><span class="badge text-secondary">Refund</span></td>
                                    <td>
                                        <span class="payment-method-wrp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <mask id="mask0_0_2299" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                                    <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                                </mask>
                                                <g mask="url(#mask0_0_2299)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0725 11.8396C12.0725 12.0308 11.9575 12.1686 11.7925 12.1686C11.6225 12.1686 11.5125 12.0224 11.5125 11.8396C11.5125 11.6567 11.6225 11.5105 11.7925 11.5105C11.9575 11.5105 12.0725 11.6567 12.0725 11.8396ZM4.30246 11.5105C4.12496 11.5105 4.02246 11.6567 4.02246 11.8396C4.02246 12.0224 4.12496 12.1686 4.30246 12.1686C4.46496 12.1686 4.57496 12.0308 4.57496 11.8396C4.57246 11.6567 4.46496 11.5105 4.30246 11.5105ZM7.23994 11.5021C7.10494 11.5021 7.02244 11.6005 7.00244 11.7468H7.47994C7.45744 11.5865 7.36994 11.5021 7.23994 11.5021ZM9.9351 11.5105C9.7651 11.5105 9.6626 11.6567 9.6626 11.8396C9.6626 12.0224 9.7651 12.1686 9.9351 12.1686C10.1051 12.1686 10.2151 12.0308 10.2151 11.8396C10.2151 11.6567 10.1051 11.5105 9.9351 11.5105ZM12.5825 12.2446C12.5825 12.253 12.59 12.2587 12.59 12.2755C12.59 12.284 12.5825 12.2896 12.5825 12.3065C12.575 12.3149 12.575 12.3205 12.57 12.329C12.5625 12.3374 12.5575 12.343 12.5425 12.343C12.535 12.3515 12.53 12.3515 12.515 12.3515C12.5075 12.3515 12.5025 12.3515 12.4875 12.343C12.48 12.343 12.475 12.3346 12.4675 12.329C12.46 12.3205 12.455 12.3149 12.455 12.3065C12.4475 12.2924 12.4475 12.284 12.4475 12.2755C12.4475 12.2615 12.4475 12.253 12.455 12.2446C12.455 12.2305 12.4625 12.2221 12.4675 12.2137C12.475 12.2052 12.48 12.2052 12.4875 12.1996C12.5 12.1912 12.5075 12.1912 12.515 12.1912C12.5275 12.1912 12.535 12.1912 12.5425 12.1996C12.555 12.208 12.5625 12.208 12.57 12.2137C12.5775 12.2193 12.575 12.2305 12.5825 12.2446ZM12.5275 12.2839C12.54 12.2839 12.54 12.2755 12.5475 12.2755C12.555 12.267 12.555 12.2614 12.555 12.253C12.555 12.2445 12.555 12.2389 12.5475 12.2305C12.54 12.2305 12.535 12.222 12.52 12.222H12.48V12.3205H12.5V12.2811H12.5075L12.535 12.3205H12.555L12.5275 12.2839L12.5275 12.2839ZM14.4 2.57803V12.478C14.4 13.2233 13.8625 13.828 13.2 13.828H1.2C0.5375 13.828 0 13.2233 0 12.478V2.57803C0 1.83271 0.5375 1.22803 1.2 1.22803H13.2C13.8625 1.22803 14.4 1.83271 14.4 2.57803ZM1.6001 6.50431C1.6001 8.65587 3.1526 10.3996 5.0626 10.3996C5.7426 10.3996 6.4101 10.169 6.9751 9.74993C5.1526 8.08212 5.1651 4.93494 6.9751 3.26712C6.4101 2.84525 5.7426 2.61744 5.0626 2.61744C3.1526 2.61462 1.6001 4.36118 1.6001 6.50431ZM7.20005 9.56433C8.96255 8.01745 8.95505 5.00246 7.20005 3.44714C5.44505 5.00246 5.43755 8.02027 7.20005 9.56433ZM3.64255 11.7102C3.64255 11.4655 3.50005 11.3052 3.27505 11.2968C3.16005 11.2968 3.03755 11.3361 2.95505 11.4796C2.89505 11.3643 2.79255 11.2968 2.65005 11.2968C2.55505 11.2968 2.46005 11.3361 2.38505 11.4486V11.3249H2.18005V12.3571H2.38505C2.38505 11.8255 2.32255 11.5077 2.61005 11.5077C2.86505 11.5077 2.81505 11.7946 2.81505 12.3571H3.01255C3.01255 11.8424 2.95005 11.5077 3.23755 11.5077C3.49255 11.5077 3.44255 11.7889 3.44255 12.3571H3.64755V11.7102H3.64255ZM4.76495 11.3249H4.56745V11.4486C4.49995 11.3558 4.40495 11.2968 4.27495 11.2968C4.01745 11.2968 3.81995 11.5274 3.81995 11.8396C3.81995 12.1546 4.01745 12.3824 4.27495 12.3824C4.40495 12.3824 4.49995 12.3289 4.56745 12.2305V12.3599H4.76495V11.3249ZM5.7774 12.0449C5.7774 11.623 5.2049 11.8143 5.2049 11.6174C5.2049 11.4571 5.5024 11.4824 5.6674 11.5865L5.7499 11.4036C5.5149 11.2321 4.9949 11.2349 4.9949 11.6343C4.9949 12.0365 5.5674 11.8677 5.5674 12.0561C5.5674 12.2333 5.2299 12.2193 5.0499 12.0786L4.9624 12.2558C5.2424 12.4696 5.7774 12.4246 5.7774 12.0449V12.0449ZM6.66247 12.3064L6.60747 12.1152C6.51247 12.1743 6.30247 12.2389 6.30247 11.9999V11.533H6.62997V11.3249H6.30247V11.0099H6.09747V11.3249H5.90747V11.5302H6.09747V11.9999C6.09747 12.4949 6.52997 12.4049 6.66247 12.3064H6.66247ZM6.99498 11.9296H7.68248C7.68248 11.4739 7.49748 11.2939 7.24748 11.2939C6.98248 11.2939 6.79248 11.5161 6.79248 11.8368C6.79248 12.4133 7.35748 12.5089 7.63748 12.2361L7.54248 12.0674C7.34748 12.2474 7.05248 12.2305 6.99498 11.9296ZM8.47245 11.325C8.35745 11.2687 8.18245 11.2743 8.09245 11.4487V11.325H7.88745V12.3571H8.09245V11.775C8.09245 11.4487 8.32995 11.4909 8.41245 11.5387L8.47245 11.325H8.47245ZM8.73747 11.8396C8.73747 11.519 9.02747 11.4149 9.25497 11.6033L9.34997 11.4205C9.05997 11.1646 8.53247 11.3052 8.53247 11.8424C8.53247 12.3993 9.09247 12.5118 9.34997 12.2643L9.25497 12.0815C9.02497 12.2643 8.73747 12.1546 8.73747 11.8396ZM10.405 11.3249H10.2V11.4487C9.99251 11.1393 9.45251 11.3137 9.45251 11.8396C9.45251 12.3796 10.0125 12.5343 10.2 12.2306V12.3599H10.405V11.3249ZM11.2475 11.3249C11.1875 11.2911 10.9725 11.2433 10.8675 11.4486V11.3249H10.67V12.3571H10.8675V11.7749C10.8675 11.4655 11.0925 11.4852 11.1875 11.5386L11.2475 11.3249H11.2475ZM12.2551 10.9059H12.0576V11.4487C11.8526 11.1421 11.3101 11.3053 11.3101 11.8396C11.3101 12.3853 11.8726 12.5315 12.0576 12.2306V12.3599H12.2551V10.9059V10.9059ZM12.445 8.79362V8.92299H12.465V8.79362H12.5125V8.77112H12.3975V8.79362H12.445H12.445ZM12.61 12.2756C12.61 12.2615 12.61 12.2446 12.6025 12.2306C12.595 12.2221 12.59 12.2081 12.5825 12.1996C12.575 12.1912 12.5625 12.1856 12.555 12.1771C12.5425 12.1771 12.5275 12.1687 12.515 12.1687C12.5075 12.1687 12.495 12.1771 12.48 12.1771C12.4675 12.1856 12.46 12.1912 12.4525 12.1996C12.44 12.2081 12.4325 12.2221 12.4325 12.2306C12.425 12.2446 12.425 12.2615 12.425 12.2756C12.425 12.284 12.425 12.2981 12.4325 12.315C12.4325 12.3234 12.44 12.3375 12.4525 12.3459C12.46 12.3543 12.465 12.36 12.48 12.3684C12.4925 12.3768 12.5075 12.3768 12.515 12.3768C12.5275 12.3768 12.5425 12.3768 12.555 12.3684C12.5625 12.36 12.575 12.3543 12.5825 12.3459C12.59 12.3375 12.595 12.3234 12.6025 12.315C12.61 12.2981 12.61 12.284 12.61 12.2756ZM12.69 8.76831H12.655L12.615 8.86675L12.575 8.76831H12.54V8.92019H12.56V8.80487L12.6 8.90331H12.6275L12.6625 8.80487V8.92019H12.69V8.76831ZM12.8 6.50431C12.8 4.36119 11.2475 2.61462 9.33755 2.61462C8.65755 2.61462 7.99005 2.84525 7.42505 3.26431C9.22755 4.93212 9.25505 8.08775 7.42505 9.74712C7.99005 10.169 8.66255 10.3968 9.33755 10.3968C11.2475 10.3996 12.8 8.65587 12.8 6.50431Z" fill="#495057"/>
                                                </g>
                                            </svg>
                                            Mastercard
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="view_details">View Details</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>#MN0131</td>
                                    <td>Roy Michael</td>
                                    <td>09 Jul, 2020</td>
                                    
                                    <td>$130</td>
                                    <td><span class="badge bg-success">paid</span></td>
                                    <td>
                                        <span class="payment-method-wrp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                <mask id="mask0_0_2275" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                                    <rect y="0.300049" width="14.4" height="14.4" fill="white"/>
                                                </mask>
                                                <g mask="url(#mask0_0_2275)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7525 6.80546C11.7525 6.80546 11.9425 7.85171 11.985 8.07109H11.15C11.2325 7.82078 11.55 6.84765 11.55 6.84765C11.545 6.85609 11.6325 6.59171 11.6825 6.42859L11.7525 6.80546L11.7525 6.80546ZM14.4 2.5502V12.4502C14.4 13.1955 13.8625 13.8002 13.2 13.8002H1.2C0.5375 13.8002 0 13.1955 0 12.4502V2.5502C0 1.80488 0.5375 1.2002 1.2 1.2002H13.2C13.8625 1.2002 14.4 1.80488 14.4 2.5502ZM3.81255 9.61524L5.39255 5.25024H4.33005L3.34755 8.23149L3.24005 7.62681L2.89005 5.61868C2.83255 5.34024 2.65505 5.26149 2.43505 5.25024H0.817549L0.800049 5.33743C1.19505 5.44993 1.54755 5.61306 1.85505 5.81837L2.75005 9.61524H3.81255ZM6.17254 9.62087L6.80254 5.25024H5.79754L5.17004 9.62087H6.17254V9.62087ZM9.67005 8.19202C9.67505 7.6942 9.40505 7.31452 8.82755 7.00233C8.47505 6.80264 8.26005 6.66764 8.26005 6.46233C8.26505 6.2767 8.44255 6.08545 8.83755 6.08545C9.16505 6.07702 9.40505 6.1642 9.58505 6.25139L9.67505 6.2992L9.81255 5.3542C9.61505 5.26702 9.30005 5.16858 8.91255 5.16858C7.92005 5.16858 7.22255 5.76483 7.21755 6.6142C7.21005 7.24139 7.71755 7.59014 8.09755 7.80108C8.48505 8.01483 8.61755 8.15545 8.61755 8.34389C8.61255 8.63639 8.30255 8.77139 8.01505 8.77139C7.61505 8.77139 7.40005 8.70108 7.07255 8.53796L6.94005 8.46764L6.80005 9.44921C7.03505 9.57014 7.47005 9.67702 7.92005 9.68264C8.97505 9.68546 9.66255 9.09764 9.67005 8.19202H9.67005ZM13.2 9.62087L12.39 5.25024H11.6125C11.3725 5.25024 11.19 5.32899 11.0875 5.61306L9.59497 9.62087H10.65C10.65 9.62087 10.8225 9.08087 10.86 8.96556H12.15C12.18 9.12024 12.27 9.62087 12.27 9.62087H13.2Z" fill="#495057"/>
                                                </g>
                                            </svg>
                                            Visa
                                        </span>
                                    </td>
                                    <td>
                                        <a href="" class="view_details">View Details</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
        <!-- ----latest-transaction--- -->

        <footer class="page-footer">
            <p class="mb-0">©2023 Admingo Inc. All Rights Reserved.</p>
        </footer>
    </div>
</section>
<!-- -----content-page---- -->

    
<!-- search modal -->
<div class="modal" id="SearchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header gap-2">
                <div class="position-relative popup-search w-100">
                    <input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search"
                        placeholder="Search">
                    <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i
                            class='bx bx-search'></i></span>
                </div>
                <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="search-list">
                    <p class="mb-1">Html Templates</p>
                    <div class="list-group">
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-angular fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-vuejs fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-magento fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-shopify fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Web Designe Company</p>
                    <div class="list-group">
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-windows fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-dropbox fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-opera fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-wordpress fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Software Development</p>
                    <div class="list-group">
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-mailchimp fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-zoom fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-sass fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-vk fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Online Shoping Portals</p>
                    <div class="list-group">
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-slack fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-skype fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-twitter fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;"
                            class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                class='bx bxl-vimeo fs-4'></i>eCommerce Html Templates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end search modal -->

<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr/>
        <h6 class="mb-0">Theme Styles</h6>
        <hr/>
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr/>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr/>
        <h6 class="mb-0">Header Colors</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>
        <hr/>
        <h6 class="mb-0">Sidebar Colors</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end switcher-->

<script>
    // Sample data for demonstration
    const dataAllYear = [/* Your data for all year */];
    const dataOneYearAgo = [/* Your data for one year ago */];
    const dataThisMonth = [/* Your data for this month */];
    const dataToday = [/* Your data for today */];

    // Get the canvas element
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['All Year', 'One Year Ago', 'This Month', 'Today'],
            datasets: [
                {
                    label: 'Previous Data',
                    data: [/* Your previous data for each time period */],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Current Data',
                    data: [/* Your current data for each time period */],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection