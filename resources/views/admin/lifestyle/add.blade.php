<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('lifestyle.index')}}">Lifestyle</a></li>
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
                        <form method="POST" id="lifestyle" action="{{ route('lifestyle.store')}}">
                            @csrf
                            <div class="form-group" id="interest">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        <label class="form-label">Lifestyle</label>
                                        <input type="text" class="form-control lifestyle" name="lifestyle[]" />

                                        <span class="text-danger"> @if ($errors->has('lifestyle*.')){{ $errors->first('lifestyle*.') }} @endif</span>


                                    </div>
                                    <div class="col-lg-4">
                                        <span class="btn btn-primary" id="addMore"><i class="fa-solid fa-plus"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div><input type="button" id="add" class="btn btn-primary" value="Add"></div>

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
    <div class="row gy-4">

        <div class="col-xxl-6 col-md-6">
            <label class="form-label">Lifestyle</label>
            <input type="text" class="form-control lifestyle" name="lifestyle[]" />

            <span class="text-danger"> @if($errors->has('lifestyle*.')){{ $errors->first('lifestyle*.') }} @endif</span>

        </div>

        <div class="col-lg-4">
            <span class="btn remove"><i class="fa-solid fa-delete-left"></i></span>
        </div>

    </div>
</div>