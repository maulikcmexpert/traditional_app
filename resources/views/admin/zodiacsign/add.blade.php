<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('zodiacsign.index')}}">Zodiac Sign</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add</h4>

                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form method="POST" id="zodiacsign" action="{{ route('zodiacsign.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group AddInterest">
                                <div class="row" id="zodiac_sign">
                                    <div class="col-xxl-12 col-md-6">
                                        <div class="w-100 d-flex align-items-end gap-2">
                                            <div class="w-100 mb-2 position-relative">
                                                <label class="form-label">Zodiac Sign</label>
                                                <input type="text" class="form-control zodiacsign" name="zodiacsign[]" />
                                                <span class="text-danger"> @if ($errors->has('zodiacsign*.')){{ $errors->first('zodiacsign*.') }} @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-2">
                                    <span class="btn btn-primary" id="addMore"><i class="fa-solid fa-plus"></i></span>
                                </div>
                            </div>

                            <div class="text-center"><input type="button" id="add" class="btn btn-primary interestButton" value="Add Zodiac Sign"></div>



                        </form>
                        <!--end row-->
                    </div>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>

</div>


<div id="addMoreData" style="display: none;">
    <div class="col-xl-6">
        <div class="d-flex align-items-end gap-2 mt-2 mb-2">
            <div class="w-100 position-relative">
                <label class="form-label">Zidiac Sign</label>
                <input type="text" class="form-control zodiacsign" name="zodiacsign[]" />

                <span class="text-danger"> @if($errors->has('zodiacsign*.')){{ $errors->first('zodiacsign*.') }} @endif</span>
            </div>
            <span class="btn remove"><i class="fa-solid fa-delete-left"></i></span>
        </div>
    </div>
</div>