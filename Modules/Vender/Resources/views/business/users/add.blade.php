@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: auto;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .main-content-inner {
            flex-grow: 1;
            padding: 10px 15px;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 15px 10px 15px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        body {
            color: black;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 991.98px) {

            /* Stack both columns full width below lg */
            .col-12.col-lg-3,
            .col-12.col-lg-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Prevent outer row overflow */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            /* Stack label above input on smaller screens */
            .form-group.row {
                flex-direction: column !important;
                margin-bottom: 12px;
            }

            .form-group.row .col-md-4,
            .form-group.row .col-md-8 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .form-group.row .col-md-8 {
                margin-top: 4px;
            }

            /* All inputs full width */
            .form-control {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }
        }

        @media (max-width: 767.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            /* Footer buttons stacked */
            .footers {
                text-align: center;
                padding: 10px !important;
            }

            .footers button,
            .footers a button {
                float: none !important;
                width: 100% !important;
                margin: 5px 0 !important;
                display: block;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Add new user</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.user') }}">Users</a></li>
                        <li class="breadcrumb-item">Add new user</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3 mb-3">
            <div class="info-sidebar">
                <h4 class="h3" style="font-weight: 600; font-size: 17px; padding: 10px; margin: 0;">
                    <img src="/user.png" style="width: 22px; margin-top: -5px;"> New user
                </h4>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-12 col-lg-9">
            <div class="main-content-box">

                <div class="row m-0" style="border-bottom: 2px solid black;">
                    <div class="col-12 p-0">
                        <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">
                            User information
                        </h3>
                    </div>
                </div>

                <form action="{{ route('vender.user.store') }}" id="contens" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="main-content-inner">

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="name">First name *</label>
                            <div class="col-md-8">
                                <input type="text" id="name" class="form-control" value=""
                                    onkeyup="lookup(this);" name="name" placeholder="First name">
                                <p class="text-danger name"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    This Field is Required!
                                </p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="middle_name">Middle name</label>
                            <div class="col-md-8">
                                <input type="text" id="middle_name" class="form-control" value=""
                                    name="middle_name" placeholder="Middle name">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="last_name">Last name *</label>
                            <div class="col-md-8">
                                <input type="text" id="last_name" class="form-control" value=""
                                    onkeyup="lookup(this);" name="last_name" placeholder="Last name">
                                <p class="text-danger last_name"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    This Field is Required!
                                </p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="email">Email *</label>
                            <div class="col-md-8">
                                <input type="email" id="email" class="form-control" value=""
                                    onkeyup="lookup(this);" name="email" placeholder="Email">
                                <p class="text-danger email"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    Invalid Email!
                                </p>
                                @if ($errors->has('email'))
                                    <p class="text-danger" style="padding-left: 0; width:100%; margin-bottom: -8px;">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="phone_no">Mobile *</label>
                            <div class="col-md-8">
                                <input type="tel" id="phone_no" class="form-control" value=""
                                    onkeyup="lookup(this);" name="phone_no" placeholder="Mobile">
                                <p class="text-danger phone_no"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    This Field is Required!
                                </p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="landline">Landline</label>
                            <div class="col-md-8">
                                <input type="tel" id="landline" class="form-control" value=""
                                    onkeyup="lookup(this);" name="landline" placeholder="Landline">
                            </div>
                        </div>

                    </div>

                    <div class="footers">
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width float-md-right mr-md-1 mb-1 mb-md-0">Save</button>
                        <a href="{{ redirect()->back()->getTargetUrl() }}">
                            <button type="button"
                                class="btn btn-dark round btn-min-width float-md-right mr-md-1 mb-1 mb-md-0">Cancel</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Real-time validation
            window.lookup = function(arg) {
                var id = arg.getAttribute('id');
                var value = arg.value.trim();

                if (value === "") {
                    $('#' + id).css('border', '2px solid red');
                } else {
                    $('#' + id).css('border', '2px solid black');
                    $('.' + id).hide();
                }
            };

            // Email validation
            window.validateEmail = function(email) {
                return String(email).toLowerCase().match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
            };

            // Final form validation
            window.submitDetailsForm = function() {
                let fields = ['name', 'last_name', 'email', 'phone_no'];
                let isValid = true;

                fields.forEach(function(item) {
                    let val = $('#' + item).val().trim();
                    if (val === "") {
                        $('#' + item).css('border', '2px solid red');
                        isValid = false;
                    } else {
                        $('#' + item).css('border', '2px solid black');
                    }
                });

                let email = $('#email').val();
                if (validateEmail(email) === null) {
                    $('#email').css('border', '2px solid red');
                    $('.email').show();
                    isValid = false;
                } else {
                    $('.email').hide();
                }

                if (isValid) {
                    $("#contens").submit();
                }
            };

        });
    </script>
@endsection
