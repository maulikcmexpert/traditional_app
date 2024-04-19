<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('version_setting.index')}}">Version Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{($setting == null)? 'Add' : 'Update' }}</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{($setting == null)? 'Add' : 'Update' }}</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="version_setting" action="{{ route('version_setting.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 form-group AddMoreForm">
                            <div class="row" id="versionsetting">
                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Android Version</label>
                                            <input type="text" class="form-control android_version" id="android_version" name="android_version" value="{{($setting == null)? '':$setting->android_version }}" />
                                            <span class="text-danger"> @if ($errors->has('android_version')){{ $errors->first('android_version') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <!-- <label class="form-label">Android In Force</label>
                                            <select class="form-control" name="android_in_force" id="android_in_force">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                            </select>
                                            <span class="text-danger"> @if ($errors->has('android_in_force')){{ $errors->first('android_in_force') }} @endif</span> -->
                                            <div class="d-flex flex-column">
                                                <label class="form-label">Android Version</label>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ios Version</label>
                                            <input type="text" class="form-control ios_version" id="ios_version" name="ios_version" value="{{($setting == null)? '':$setting->ios_version }}" />
                                            <span class="text-danger"> @if ($errors->has('ios_version')){{ $errors->first('ios_version') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ios In Force</label>
                                            <select class="form-control" name="ios_in_force" id="ios_in_force">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                            </select>
                                            <span class="text-danger"> @if ($errors->has('ios_in_force')){{ $errors->first('ios_in_force') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="{{($setting == null)? 'Add' : 'Update' }}"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->


</div>