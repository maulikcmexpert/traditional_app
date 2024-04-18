<div class="page-content form-main-wrp">
    <div class="header-breadcrumb form-main-wrp">

        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('legal_agreement.index')}}">Legal Agreement</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{($legalAgreement == null)? 'Add' : 'Update' }}</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{($legalAgreement == null)? 'Add' : 'Update' }}</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="POST" id="legal_agreement" action="{{ route('legal_agreement.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 form-group AddMoreForm">
                            <div class="row" id="legalagreement">
                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Privacy Policy</label>

                                            <textarea class="ckeditor form-control privacy_policy" id="privacy_policy" name="privacy_policy">{{($legalAgreement == null)? '':$legalAgreement->privacy_policy }}</textarea>
                                            <span class="text-danger"> @if ($errors->has('privacy_policy')){{ $errors->first('privacy_policy') }} @endif</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-md-3 mb-2">
                                    <div class="w-100 d-flex align-items-end gap-2">
                                        <div class="w-100 position-relative">
                                            <label class="form-label">Term And Condition</label>

                                            <textarea class="ckeditor form-control term_and_condition" id="term_and_condition" name="term_and_condition">{{($legalAgreement == null)? '':$legalAgreement->term_and_condition }}</textarea>
                                            <span class="text-danger"> @if ($errors->has('term_and_condition')){{ $errors->first('term_and_condition') }} @endif</span>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="text-center"><input type="submit" id="add" class="btn btn-primary submitButton" value="{{($legalAgreement == null)? 'Add' : 'Update' }}"></div>

                    </form>
                    <!--end row-->
                </div>

            </div>
        </div>
    </div>
    <!--end col-->
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>

</div>