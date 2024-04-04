<!-- -----header-breadcrumb-start-- -->
<style>
    // Imports
    // 
    @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css);
    @import url('https://fonts.googleapis.com/css?family=Roboto');

    // Vars and Reset
    // 
    $theme: #454cad;
    $dark-text: #5f6982;

    html,
    body,
    * {
        box-sizing: border-box;
        font-size: 16px;
    }

    html,
    body {
        height: 100%;
        text-align: center;
    }

    body {
        padding: 2rem;
        background: #f8f8f8;
    }

    h2 {
        font-family: "Roboto", sans-serif;
        font-size: 26px;
        line-height: 1;
        color: $theme;
        margin-bottom: 0;
    }

    p {
        font-family: "Roboto", sans-serif;
        font-size: 18px;
        color: $dark-text;
    }

    // Upload Demo
    // 
    .uploader {
        display: block;
        clear: both;
        margin: 0 auto;
        width: 100%;
        max-width: 600px;

        label {
            float: left;
            clear: both;
            width: 100%;
            padding: 2rem 1.5rem;
            text-align: center;
            background: #fff;
            border-radius: 7px;
            border: 3px solid #eee;
            transition: all .2s ease;
            user-select: none;

            &:hover {
                border-color: $theme;
            }

            &.hover {
                border: 3px solid $theme;
                box-shadow: inset 0 0 0 6px #eee;

                #start {
                    i.fa {
                        transform: scale(0.8);
                        opacity: 0.3;
                    }
                }
            }
        }

        #start {
            float: left;
            clear: both;
            width: 100%;

            &.hidden {
                display: none;
            }

            i.fa {
                font-size: 50px;
                margin-bottom: 1rem;
                transition: all .2s ease-in-out;
            }
        }

        #response {
            float: left;
            clear: both;
            width: 100%;

            &.hidden {
                display: none;
            }

            #messages {
                margin-bottom: .5rem;
            }
        }

        #file-image {
            display: inline;
            margin: 0 auto .5rem auto;
            width: auto;
            height: auto;
            max-width: 180px;

            &.hidden {
                display: none;
            }
        }

        #notimage {
            display: block;
            float: left;
            clear: both;
            width: 100%;

            &.hidden {
                display: none;
            }
        }

        progress,
        .progress {
            // appearance: none;
            display: inline;
            clear: both;
            margin: 0 auto;
            width: 100%;
            max-width: 180px;
            height: 8px;
            border: 0;
            border-radius: 4px;
            background-color: #eee;
            overflow: hidden;
        }

        .progress[value]::-webkit-progress-bar {
            border-radius: 4px;
            background-color: #eee;
        }

        .progress[value]::-webkit-progress-value {
            background: linear-gradient(to right, darken($theme, 8%) 0%, $theme 50%);
            border-radius: 4px;
        }

        .progress[value]::-moz-progress-bar {
            background: linear-gradient(to right, darken($theme, 8%) 0%, $theme 50%);
            border-radius: 4px;
        }

        input[type="file"] {
            display: none;
        }

        div {
            margin: 0 0 .5rem 0;
            color: $dark-text;
        }

        .btn {
            display: inline-block;
            margin: .5rem .5rem 1rem .5rem;
            clear: both;
            font-family: inherit;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            text-transform: initial;
            border: none;
            border-radius: .2rem;
            outline: none;
            padding: 0 1rem;
            height: 36px;
            line-height: 36px;
            color: #fff;
            transition: all 0.2s ease-in-out;
            box-sizing: border-box;
            background: $theme;
            border-color: $theme;
            cursor: pointer;
        }
    }
</style>
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