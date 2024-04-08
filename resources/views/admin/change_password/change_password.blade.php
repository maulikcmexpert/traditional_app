<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="container">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="changePasswordForm" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class=" form-group AddMoreForm">
                            <div class="row" id="general_setting">
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control current_password" id="current_password" name="current_password" />
                                            <span class="text-danger"> @if ($errors->has('current_password')){{ $errors->first('current_password') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control new_password" id="new_password" name="new_password" />
                                            <span class="text-danger"> @if ($errors->has('new_password')){{ $errors->first('new_password') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control confirm_password" name="confirm_password" />
                                            <span class="text-danger"> @if ($errors->has('confirm_password')){{ $errors->first('confirm_password') }} @endif</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="Change Password"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->


</div>