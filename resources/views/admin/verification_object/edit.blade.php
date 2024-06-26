<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('verificationobject.index')}}">Verification Object</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->



    <div class="">
        <div class="card pb-3">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit</h4>

            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="verificationobject" action="{{ route('verificationobject.update',encrypt($getData->id))}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 AddMoreForm">
                            <div class="row" id="interest">
                                <div class="col-xxl-4 col-md-4 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Object Type</label>
                                            <input type="hidden" value="{{encrypt($getData->id)}}" class="form-control verificationobject_id" name="id" />
                                            <input type="text" class="form-control object_type" name="object_type" value="{{ $getData->object_type}}" />
                                            <span class="text-danger"> @if ($errors->has('object_type*.')){{ $errors->first('object_type*.') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label class="form-label">Object Image</label>

                                        <input id="file-upload" class="form-control" type="file" name="object_image_edit" accept="image/*" onchange="readURL(this);" />
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4 mt-lg-0 mt-md-0 mt-2">
                                    <div class="preview-Img">

                                        <img id="blah" src="{{($getData->object_image != NULL || $getData->object_image != '')?asset('storage/verification_object/'.$getData->object_image):''}}" alt="your image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="Update"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>


</div>