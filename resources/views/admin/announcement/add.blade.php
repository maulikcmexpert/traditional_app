<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>

                <li class="breadcrumb-item active" aria-current="page">General Notification</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">General Notification</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="announcement" action="{{ route('announcement.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 form-group AddMoreForm">
                            <div class="row" id="general_setting">
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Notification Type</label>
                                            <select class="form-control" name="type" id="">
                                                <option value="announcement">Announcement</option>
                                                <option value="promotional">Promotional</option>
                                            </select>
                                            <span class="text-danger"> @if ($errors->has('message')){{ $errors->first('message') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Message</label>
                                            <input type="text" class="form-control message" id="message" name="message" value="" />
                                            <span class="text-danger"> @if ($errors->has('message')){{ $errors->first('message') }} @endif</span>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="Send"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->


</div>