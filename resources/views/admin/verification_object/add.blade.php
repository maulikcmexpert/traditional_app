<!-- -----header-breadcrumb-start-- -->
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
    <div class="container">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Add</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="verificationobject" action="{{ route('verificationobject.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group AddMoreForm">
                            <div class="row" id="interest">
                                <div class="col-xxl-6 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Object Type</label>
                                            <input type="text" class="form-control object_type" name="object_type" />
                                            <span class="text-danger"> @if ($errors->has('object_type*.')){{ $errors->first('object_type*.') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <input id="file-upload" type="file" name="fileUpload" accept="image/*" />

                                <label for="file-upload" id="file-drag">
                                    <img id="file-image" src="#" alt="Preview" class="hidden">
                                    <div id="start">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <div>Select a file or drag here</div>
                                        <div id="notimage" class="hidden">Please select an image</div>
                                        <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                    </div>
                                    <div id="response" class="hidden">
                                        <div id="messages"></div>
                                        <progress class="progress" id="file-progress" value="0">
                                            <span>0</span>%
                                        </progress>
                                    </div>
                                </label>
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