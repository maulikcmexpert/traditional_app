<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('verificationobject.index')}}">Verification Object</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Add</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="verificationobject" action="{{ route('verificationobject.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 form-group AddMoreForm">
                            <div class="row" id="interest">
                                <div class="col-xxl-4 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Object Type</label>
                                            <input type="text" class="form-control object_type" name="object_type" />
                                            <span class="text-danger"> @if ($errors->has('object_type*.')){{ $errors->first('object_type*.') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3">
                                    <div>
                                        <label class="form-label">Object Image</label>
                                        <input id="file-upload" class="form-control" type="file" name="object_image" accept="image/*" onchange="readURL(this);" />
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="preview-Img">
                                        <img id="blah" src="http://placehold.it/180" alt="your image" />
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