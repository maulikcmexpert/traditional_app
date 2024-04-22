<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('interest_and_hobby.index')}}">Interest And Hobby</a></li>
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
                    <form method="POST" id="interest_and_hobby" action="{{ route('interest_and_hobby.update',encrypt($getData->id))}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="row gy-4 align-items-end">
                                <div class="col-xxl-6 col-md-6 position-relative">
                                    <label class="form-label">Interest and Hobby</label>
                                    <input type="hidden" value="{{encrypt($getData->id)}}" class="form-control interest_and_hobby_id" name="id" />
                                    <input type="text" value="{{$getData->interest_and_hobby}}" class="form-control interest_and_hobby " name="interest_and_hobby" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-xxl-2">
                                    <input type="button" id="edit" class="btn btn-primary" value="Update">
                                </div>
                            </div>

                        </div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>


</div>