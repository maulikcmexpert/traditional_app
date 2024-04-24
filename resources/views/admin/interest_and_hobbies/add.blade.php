<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" tabindex="1">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('interest_and_hobby.index')}}" tabindex="2">Interest and Hobbies</a></li>
                <li class="breadcrumb-item active" aria-current="page" tabindex="3">Add</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1" tabindex="4">Add</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="interest_and_hobby" action="{{ route('interest_and_hobby.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group AddMoreForm">
                            <div class="row" id="interest">
                                <div class="col-xxl-6 col-md-6 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label" tabindex="5">Interest and Hobby</label>
                                            <input type="text" class="form-control interest_and_hobby" name="interest_and_hobby[]" tabindex="6" />
                                            <span class="text-danger" tabindex="7"> @if ($errors->has('interest_and_hobby*')){{ str_replace(".0", "", $errors->first('interest_and_hobby*')); }} @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-2" tabindex="8">
                                <span class="btn btn-primary" id="addMore"><i class="fa-solid fa-plus"></i></span>
                            </div>
                        </div>

                        <div class="text-center" tabindex="9"><input type="button" id="add" class="btn btn-primary submitButton" value="Add"></div>

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
                <label class="form-label" tabindex="10">Interest And Hobby</label>
                <input type="text" class="form-control interest_and_hobby" name="interest_and_hobby[]" tabindex="11" />

                <span class="text-danger" tabindex="12"> @if($errors->has('interest_and_hobby*')){{ $errors->first('interest_and_hobby*') }} @endif</span>
            </div>
            <span class="btn remove" tabindex="13"><i class="fa-solid fa-delete-left"></i></span>
        </div>
    </div>
</div>