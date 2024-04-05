<!-- -----header-breadcrumb-start-- -->
<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('sizeoforganization.index')}}">Size Of Organization</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->



    <div class="container">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit</h4>

            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="sizeoforganization" action="{{ route('sizeoforganization.update',encrypt($getData->id))}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="row gy-4 align-items-end" id="size_of_organization">
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label">Size Of Organization</label>
                                    <input type="hidden" value="{{encrypt($getData->id)}}" class="form-control sizeoforganization_id" name="id" />
                                    <input type="text" value="{{$getData->size_range}}" class="form-control size_range" name="size_range" />
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