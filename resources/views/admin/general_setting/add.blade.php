<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('generalsetting.index')}}">General Setting</a></li>
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
                    <form method="POST" id="generalsetting" action="{{ route('generalsetting.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 AddMoreForm">
                            <div class="row" id="general_setting">
                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Min age</label>
                                            <input type="text" class="form-control min_age" id="min_age" name="min_age" value="{{($setting == null)? '':$setting->min_age }}" />
                                            <span class="text-danger"> @if ($errors->has('min_age')){{ $errors->first('min_age') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Max age</label>
                                            <input type="text" class="form-control max_age" id="max_age" name="max_age" value="{{($setting == null)? '':$setting->max_age }}" />
                                            <span class="text-danger"> @if ($errors->has('max_age')){{ $errors->first('max_age') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ghost Count</label>
                                            <input type="text" class="form-control ghost_count" name="ghost_count" value="{{($setting == null)? '':$setting->ghost_count }}" />
                                            <span class="text-danger"> @if ($errors->has('ghost_count')){{ $errors->first('ghost_count') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Ghost Day</label>
                                            <input type="text" class="form-control ghost_day" name="ghost_day" value="{{($setting == null)? '':$setting->ghost_day }}" />
                                            <span class="text-danger"> @if ($errors->has('ghost_day')){{ $errors->first('ghost_day') }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">No Chat Day duration</label>
                                            <input type="text" class="form-control no_chat_day_duration" name="no_chat_day_duration" value="{{($setting == null)? '':$setting->no_chat_day_duration }}" />
                                            <span class="text-danger"> @if ($errors->has('no_chat_day_duration')){{ $errors->first('no_chat_day_duration') }} @endif</span>
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