<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('blockreason.index')}}">Block Reason</a></li>
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
                    <form method="POST" id="blockreason" action="{{ route('blockreason.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group AddMoreForm">
                            <div class="row" id="block_reason">
                                <div class="col-xxl-6 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Block Reason</label>
                                            <input type="text" class="form-control reason" name="reason[]" />
                                            <span class="text-danger"> @if ($errors->has('reason*.')){{ $errors->first('reason*.') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-2">
                                <span class="btn btn-primary" id="addMore"><i class="fa-solid fa-plus"></i></span>
                            </div>
                        </div>

                        <div class="text-center"><input type="button" id="add" class="btn btn-primary submitButton" value="Add Interest"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->


</div>
<div id="addMoreData" style="display: none;">
    <div class="col-xl-6 mb-2">
        <div class="d-flex align-items-end gap-2">
            <div class="w-100 position-relative">
                <label class="form-label">Block Reason</label>
                <input type="text" class="form-control reason" name="reason[]" />

                <span class="text-danger"> @if($errors->has('reason*.')){{ $errors->first('reason*.') }} @endif</span>
            </div>
            <span class="btn remove"><i class="fa-solid fa-delete-left"></i></span>
        </div>
    </div>
</div>