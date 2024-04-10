<div class="page-content">
    <!-- -----header-breadcrumb-start-- -->
    <div class="header-breadcrumb">
        <!-- <h5>Interest and hobbies</h5> -->
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('report_management.index')}}">Report Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Chat View</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">User Chat View</h4>
            </div>
            <div class="card-body">
                @foreach($userchat as $username=> $collection)
                <h1>{{ $username }}</h1>
                dd($collection);
                @endforeach
            </div>
        </div>
    </div>
</div>