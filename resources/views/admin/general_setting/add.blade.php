<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('generalsetting.index')}}">General Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="container">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Add</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="generalsetting" action="{{ route('generalsetting.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group AddMoreForm">
                            <div class="row" id="general_setting">
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Min age</label>
                                            <input type="text" class="form-control min_age" name="min_age" />
                                            <span class="text-danger"> @if ($errors->has('min_age')){{ $errors->first('min_age') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Max age</label>
                                            <input type="text" class="form-control max_age" name="max_age" />
                                            <span class="text-danger"> @if ($errors->has('max_age')){{ $errors->first('max_age') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ghost Count</label>
                                            <input type="text" class="form-control ghost_count" name="ghost_count" />
                                            <span class="text-danger"> @if ($errors->has('ghost_count')){{ $errors->first('ghost_count') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ghost Day</label>
                                            <input type="text" class="form-control ghost_day" name="ghost_day" />
                                            <span class="text-danger"> @if ($errors->has('ghost_day')){{ $errors->first('ghost_day') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="Add"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->


</div>