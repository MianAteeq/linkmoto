@extends('frontend::new-layouts.master')

@section('css')
    <style>
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;

        }

        .custom-control-label::before {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid black;
            margin-left: 1px;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            vertical-align: top;
            padding-left: 8px;
            padding-top: 3px;
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #f47c42;
            background-color: #f26723;
        }

        .custom-control-label::after {
            width: 1.5rem;
            height: 1.5rem;
            /* background: #f26723; */
        }
    </style>
@endsection

@section('content')
    <div class="content-body pb-1">

        <div class="row" style="border-bottom: 3px solid #949494; margin-bottom: 15px;">
            <div class="col-xl-12 col-12 px-1 px-md-1">
                <h3 class="h3" style="font-weight: 800; font-size: 18px; color: black; margin-bottom: 14px;">
                    Business registration application @if($user['application_status'] == 'Request for Info' || $user['application_status'] == 'PENDING')
                                            <span class="badge badge-info" style="padding: 0.5em 0.6em;font-size: 13px;"> Request
                                                for Info
                                            </span>
                                            @elseif ($user['application_status'] == 'DECLINE')
                                            <span class="badge badge-info" style="padding: 0.5em 0.6em;font-size: 13px;background-color: black!important; color: white;"> Decline
                                            </span>
                                            @else
                                             <span class="badge badge-success" style="padding: 0.5em 0.6em;font-size: 13px;"> In Review
                                            </span>


                                            @endif
                </h3>
            </div>
        </div>

        <div class="px-1 px-md-1">
            <div class="row" style="margin-top: 10px;">

                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div style="border-radius: 7px; border: 2px solid black;">
                        <h4 class="h3" style="padding: 10px;font-weight: 600;font-size: 17px; ">
                            <img src="/home.png" style="width: 22px;margin-top: -5px;"> Main contact
                        </h4>
                        <p style="padding-left: 10px; padding-right: 10px;">This is the main contact person that Motonos
                            should
                            use for this account. This is the person who will receive the username and password to access
                            Motonos and set up other users. <strong> This is a director, owner, or partner of the
                                business.</strong> By providing
                            these details, you confirm that this person is <strong> authorised to act on behalf of the
                                business
                            </strong> for
                            registration and account management purposes
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-8 body-height">
                    <form action="{{ route('vender.profile.main.account') }}" method="POST" enctype="multipart/form-data"
                        id="contens" class="flex-column-container h-100"
                        style="border: 2px solid black; border-radius: 8px; overflow: hidden;">
                        @csrf
                        <input type="hidden" id="is_save_later" name="is_save_later" value="0">

                        <div class="link-body" style="padding: 10px; flex-grow: 1;">

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="name">First name <span
                                        style="color: red">*</span>
                                </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="name" class="form-control" value="{{ $user['name'] }}"
                                        onkeyup="lookup(this);" name="name" placeholder="First name">
                                    <p class="text-danger name"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                        Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="middle_name">Middle name </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="middle_name" class="form-control"
                                        value="{{ $user['middle_name'] }}" name="middle_name" placeholder="Middle name ">
                                    <p class="text-danger middle_name"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field
                                        is
                                        Required !</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="last_name">Last name <span
                                        style="color: red">*</span>
                                </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="last_name" class="form-control"
                                        value="{{ $user['last_name'] }}" onkeyup="lookup(this);" name="last_name"
                                        placeholder="Last name">
                                    <p class="text-danger last_name"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="email">Email <span
                                        style="color: red">*</span> </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="email" class="form-control" value="{{ $user['email'] }}"
                                        onkeyup="lookup(this);" name="email" placeholder="Email">
                                    <p class="text-danger email"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                        Field is Required !</p>
                                    @if ($errors->has('email'))
                                        <p class="text-danger email"
                                            style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                            {{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="phone_no">Mobile <span
                                        style="color: red">*</span>
                                </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="phone_no" class="form-control"
                                        value="{{ $user['profile']['phone_no'] }}" onkeyup="lookup(this);" name="phone_no"
                                        placeholder="Mobile">
                                    <p class="text-danger phone_no"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control">Role / position <span
                                        style="color: red">*</span>
                                    <a style="color: black" href="#collapsebusiness" data-toggle="collapse"
                                        aria-expanded="false" aria-controls="collapsebusiness">(?)</a></label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <div class="input-group" style="width:60%">
                                        <select name="job_title" id="job_title" class="form-control select2"
                                            style="width: 100%!important">
                                            <option value="Director" @if ($user['profile']['job_title'] == 'Director') selected @endif>
                                                Director
                                            </option>
                                            <option value="Owner" @if ($user['profile']['job_title'] == 'Owner') selected @endif>Owner
                                            </option>
                                            <option value="Partner" @if ($user['profile']['job_title'] == 'Partner') selected @endif>
                                                Partner
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="confirm_authorised"
                                            name="confirm_authorised" value="1"
                                            {{ $user['profile']['person_authorised'] == 1 ? 'checked' : null }} required>
                                        <label class="custom-control-label" for="confirm_authorised">
                                            I confirm this person is a director, owner, or partner and is authorised to act
                                            on
                                            behalf of the business <span style="color:red">*</span>
                                        </label>
                                    </div>
                                    <p class="text-danger confirm_authorised"
                                        style="display:none; padding-left: 10px; margin-top: 5px;">
                                        You must confirm this before proceeding.
                                    </p>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none">
                                <label class="col-12 col-md-4 label-control">Is this person authorised to act on behalf of
                                    this
                                    business? <span style="color: red">*</span> (?)</label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <div class="input-group">
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" name="person_authorised" class="custom-control-input"
                                                value="YES" @if ($user['profile']['person_authorised'] == 'YES') checked @endif
                                                id="Yes">
                                            <label class="custom-control-label" for="Yes">Yes</label>
                                        </div>
                                        <div class="d-inline-block custom-control custom-radio">
                                            <input type="radio" name="person_authorised" class="custom-control-input"
                                                value="NO" @if ($user['profile']['person_authorised'] == 'NO') checked @endif
                                                id="No">
                                            <label class="custom-control-label" for="No">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none">
                                <label class="col-12 col-md-4 label-control">Proof main contact person is
                                    authorised to act on behalf of this business <span style="color: red">*</span> <a
                                        style="color: black" href="#collapsebusiness_vat" data-toggle="collapse"
                                        aria-expanded="false" aria-controls="collapsec_c_address">(?)</a></label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="file" name="proof_of_main_contact" accept="image/*,.doc, .docx,.pdf"
                                        class="d-none" id="">
                                    <input type="button" id="form-btn" class="form-control form-btn mt-1 mt-md-0"
                                        value="{{ $user['profile']['proof_of_main_contact_name'] ?? 'Document Upload' }}"
                                        name="contact" placeholder="Document Upload ">
                                    <button type="button" class="btn btn-primary btn-sm mt-2 view-btn"
                                        @if ($user['profile']['proof_of_main_contact'] == null) style="display: none" @endif> <a
                                            href="{{ URL::to($user['profile']['proof_of_main_contact'] ?? '') }}"
                                            id="view_file" target="_blank" style="color: white">View</a></button>
                                    <br><br>
                                    <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none">
                                        Proof main contact person is Required !</p>
                                </div>
                            </div>

                        </div>

                        <div class="footers d-flex flex-wrap justify-content-center justify-content-md-end w-100 mt-auto"
                            style="gap: 10px; padding: 15px; ">
                            @if ($user['profile']['edit_step'] == 0)
                                <a href="{{ route('vender.profile.back', 3) }}" class="btn btn-dark round btn-min-width">
                                    PREVIOUS
                                </a>
                                <button type="button" onclick="saveforlater()" class="btn btn-dark round btn-min-width">
                                    SAVE AND EXIT
                                </button>
                                <button type="button" onclick="submitDetailsForm()"
                                    class="btn btn-dark round btn-min-width">
                                    NEXT
                                </button>
                            @else
                                <button type="button" onclick="submitDetailsForm()"
                                    class="btn btn-dark round btn-min-width">
                                    UPDATE
                                </button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // JS Height calculation removed. CSS handles container expansions dynamically now!
    </script>
    <script>
        $('#form-btn').click(function() {
            $('input[type=file]').trigger('click');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $('.form-btn').val(fileName);

                $('.view-btn').show();
                $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
                $('.file_proof').hide();
            });
        });
    </script>

    <script>
        async function lookup(arg) {
            var id = arg.getAttribute('id');
            var value = arg.value;

            let trading_name = $(`#${id}`).val();
            if (id !== "address_line_2" && id !== "city" && id !== "postcode") {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;");
                    $(`.${id}`).hide();
                }
            } else {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;margin-top: 5px ");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;margin-top: 5px;");
                    $(`.${id}`).hide();
                }
            }
        }
    </script>

    <script>
        function submitDetailsForm() {
            let array = ['name', 'last_name', 'email', 'phone_no'];

            let status = false;
            array.some((item) => {
                let name = $(`#${item}`).val();

                if (name === "") {
                    $(`.${item}`).show();
                    $(`#${item}`).attr('style', 'border:2px solid red!important');
                    status = false;
                    return false;
                } else {
                    $(`.${item}`).hide();
                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    status = true;
                }
            });

            array.some((item) => {
                let name = $(`#${item}`).val();

                if (name === "") {
                    $(`.${item}`).show();
                    $(`#${item}`).attr('style', 'border:2px solid red!important');
                    status = false;
                    return true;
                } else {
                    $(`.${item}`).hide();
                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    status = true;
                }
            });

            if (!$('#confirm_authorised').is(':checked')) {
                $('.confirm_authorised').show();
                status = false;
            } else {
                $('.confirm_authorised').hide();
            }

            if (status === true) {
                $("form").submit();
            }
        }
    </script>

    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>
@endsection
