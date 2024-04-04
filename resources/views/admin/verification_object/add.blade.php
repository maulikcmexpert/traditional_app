<form method="POST" id="verificationobject" action="{{ route('verificationobject.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group AddMoreForm">
        <div class="row" id="interest">
            <div class="col-xxl-4 col-md-6 mb-2">
                <div class="w-100 d-flex align-items-end gap-2">
                    <div class="w-100 position-relative">
                        <label class="form-label">Object Type</label>
                        <input type="text" class="form-control object_type" name="object_type" />
                        <span class="text-danger"> @if ($errors->has('object_type*.')){{ $errors->first('object_type*.') }} @endif</span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div>
                    <label class="form-label">Object Image</label>
                    <input id="file-upload" class="form-control" type="file" name="object_image" accept="image/*" onchange="readURL(this);" />
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="preview-Img">
                    <img id="blah" src="http://placehold.it/180" alt="your image" />
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <input type="submit" class="btn btn-primary submitButton" value="Submit">
    </div>
</form>