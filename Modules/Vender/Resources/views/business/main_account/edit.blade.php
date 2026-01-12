@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter {

            display: none;
        }

        table.dataTable thead {
            background: #fafbfc;
            color: black;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: white;
        }

        table.dataTable tbody td {
            padding: 8px 10px;
            padding-bottom: 2px;
            padding-top: 2px;
            font-size: 10px;
        }

        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        table.dataTable tbody td {

            color: black;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
            font-size: 11px;
            padding-left: 8px;
            padding-right: 1px;
        }

        th {
            white-space: pre-line;
        }

        table.dataTable tfoot th,
        table.dataTable tfoot td {
            padding: 10px 18px 6px 18px;
            border-top: 1px solid #111;
            font-size: 10px;
            padding-right: 0px;
            padding-left: 8px;
            color: black;
        }

        #headingCollapse14:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e843";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845";
            transition: all 300ms linear 0s;
        }

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .footers {
            /* position: absolute; */
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 5px;
            width: 100%;
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
            width: 60%;

        }

        .form-btn {
            text-align: left;
            /* opacity: -0.5; */
            color: #babfcc;
            width: 60%;
            padding: 7px;
            padding-left: 14px;
            float: left;
        }

        .view-btn {
            float: left;
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: #ff822f !important;
            border-color: #ff822f !important;
        }

        body {
            color: black;
        }

        .view-btn-black {
            /* float: left; */
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: black !important;
            border-color: black !important;
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        body.vertical-layout.vertical-menu.menu-expanded .main-menu {
            width: 274px;
            transition: 300ms ease all;
            backface-visibility: hidden;
        }

        body.vertical-layout.vertical-menu.menu-expanded .content,
        body.vertical-layout.vertical-menu.menu-expanded .footer {
            margin-left: 274px;
            /* background-color: white; */
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        .accordion .card-header,
        .default-collapse .card-header {

            color: black !important;
            padding: 1rem 1rem !important;
        }

        .card>hr {
            margin-right: 0;
            margin-left: 0;
            height: 0px;
        }

        .card .card-title {
            font-weight: 700;
            letter-spacing: 0.05rem;
            font-size: 1rem;
        }

        .hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Main contact</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>



                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.main.contact') }}">Main
                                contact</a></li>
                        <li class="breadcrumb-item">Edit main contact
                        </li>

                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 7px;border: 2px solid black; ">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> Edit Main Contact
                </h4>
                <div class="footers" id="show_help" style="border-top:2px solid black;">
                    <h4
                        style="padding-left: 13px;
                        color: black;
                        font-weight: 600;">
                        Help information: </h4>

                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card accordion collapse-icon accordion-icon-rotate" style="box-shadow: none;">
                            <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                href="#collapsebusiness_vat" aria-expanded="false" aria-controls="collapsebusiness_vat">
                                <div class="card-title lead"> Role / position (?)</div>
                            </a>
                            <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                                aria-labelledby="business_VAT" class="collapse" style="">
                                <div class="card-content">
                                    <div class="card-body" style="color:black">
                                        Select the main contact’s official role
                                        in the business. This determines their
                                        authority to act on behalf of the
                                        business.




                                    </div>
                                </div>
                            </div>
                            <hr class="hr">
                            <a id="business_proof_id" class="card-header info collapsed" data-toggle="collapse"
                                href="#collapsebusiness_proof_id" aria-expanded="false"
                                aria-controls="collapsebusiness_proof_id">
                                <div class="card-title lead"> Proof of Id (?)
                                </div>
                            </a>
                            <div id="collapsebusiness_proof_id" data-parent="#accordionWrap1" role="tabpanel"
                                aria-labelledby="business_proof_id" class="collapse" style="">
                                <div class="card-content">
                                    <div class="card-body" style="color:black">
                                        Upload a valid photo ID to verify the
                                        main contact’s identity. Accepted
                                        documents include passport, driving
                                        licence, or national ID card. This is
                                        mandatory for all main contacts.




                                    </div>
                                </div>
                            </div>
                            <hr class="hr">
                            <a id="business_proof_auth" class="card-header info collapsed" data-toggle="collapse"
                                href="#collapsebusiness_proof_auth" aria-expanded="false"
                                aria-controls="collapsebusiness_proof_auth">
                                <div class="card-title lead"> Proof of Authorisation (?)
                                </div>
                            </a>
                            <div id="collapsebusiness_proof_auth" data-parent="#accordionWrap1" role="tabpanel"
                                aria-labelledby="business_proof_auth" class="collapse" style="">
                                <div class="card-content">
                                    <div class="card-body" style="color:black">
                                        Required only if the main contact is
                                        not automatically authorised (e.g., a
                                        CEO who is not listed as a Director or
                                        Owner). Accepted documents include
                                        a board resolution or formal
                                        authorisation letter <strong>confirming the
                                            person can act on behalf of the
                                            business.</strong>




                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-md-9"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0;padding-right: 0;">
            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Main
                        contacts</h3>
                </div>


            </div>
            <form action="{{ route('vender.main.contact.update') }}" id="contens" method="POST"
                enctype="multipart/form-data" id="contens"> @csrf
                <input type="hidden" name="id" value="{{ $user['id'] }}">
                <div class="link-body" style="padding: 10px">

                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">First name <span style="color: red">*</span> </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="name" class="form-control" value="{{ $user['name'] }}"
                                onkeyup="lookup(this);" name="name" placeholder="First name">
                            <p class="text-danger name"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Middle name </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="middle_name" class="form-control"
                                value="{{ $user['middle_name'] }}" name="middle_name" placeholder="Middle name ">
                            <p class="text-danger middle_name"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Last name <span style="color: red">*</span> </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="last_name" class="form-control" value="{{ $user['last_name'] }}"
                                onkeyup="lookup(this);" name="last_name" placeholder="Last name">
                            <p class="text-danger last_name"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Email <span style="color: red">*</span>  </label>
                        <div class="col-md-8 mx-auto">
                            <input type="email" id="email" readonly class="form-control"
                                value="{{ $user['email'] }}" onkeyup="lookup(this);" name="email" placeholder="Email">
                            <p class="text-danger email"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                            @if ($errors->has('email'))
                                <p class="text-danger email" style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('email') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Mobile <span style="color: red">*</span>  </label>
                        <div class="col-md-8 mx-auto">
                            <input type="tel" id="phone_no" class="form-control"
                                value="{{ $user['sub_profile']['phone_no'] ?? '' }}" onkeyup="lookup(this);" name="phone_no"
                                placeholder="Mobile">
                            <p class="text-danger phone_no"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Landline </label>
                        <div class="col-md-8 mx-auto">
                            <input type="tel" id="landline" class="form-control"
                                value="{{ $user['profile']['landline'] ?? '' }}" name="landline" placeholder="Landline">
                            <p class="text-danger landline"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-md-4 label-control">Role / position <span style="color: red">*</span> <a
                                style="color: black" href="#collapsebusiness" data-toggle="collapse"
                                aria-expanded="false" aria-controls="collapsebusiness">(?)</a></label>
                        <div class="col-md-8 mx-auto">
                            <div class="input-group">


                                <select name="job_title" id="job_title" class="form-control select2"
                                    style="max-width:60%!important">
                                    <option value="Director" @if ($user['profile']['job_title'] == 'Director') selected @endif>Director
                                    </option>
                                    <option value="Owner" @if ($user['profile']['job_title'] == 'Owner') selected @endif>Owner
                                    </option>
                                    <option value="Partner" @if ($user['profile']['job_title'] == 'Partner') selected @endif>Partner
                                    </option>
                                    <option value="Other – Authorised Person"
                                        @if ($user['profile']['job_title'] == 'Other – Authorised Person') selected @endif>Other – Authorised Person
                                    </option>


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Proof of Id <span style="color: red">*</span>  (?)</label>
                        <div class="col-md-8 mx-auto">
                            <input type="file" name="proof_of_id" accept="image/*,.doc, .docx,.pdf" class="d-none"
                                id="">
                            <input type="button" id="proof_of_id" class="form-control form-btn btn-2"
                                value="{{ $user['proof_id'] ?? 'Document Upload' }}" name="contact"
                                placeholder="Document Upload ">
                            <button type="button" class="btn btn-primary btn-sm view-btn"
                                @if (($user['proof_id'] ?? '') == null) style="display: none" @endif> <a
                                    href="{{ URL::to($user['proof_id'] ?? '') }}" id="view_file" target="_blank"
                                    style="color: white">View</a></button>
                            <br>
                            <br>
                            <p class="text-danger proof_d" style="padding-left: 10px;width:100%;display: none">Proof of
                                Id is Required !</p>

                        </div>
                    </div>


                    <div class="form-group row Poof_div">
                        <label class="col-md-4 label-control" for="eventRegInput5"> Proof of Authorisation <span style="color: red">*</span>  (?)</label>
                        <div class="col-md-8 mx-auto">
                            <input type="file" name="proof_of_main_contact" accept="image/*,.doc, .docx,.pdf"
                                class="d-none" id="">
                            <input type="button" id="proof_of_main_contact" class="form-control form-btn btn-1"
                                value="{{ $user['profile']['proof_of_main_contact_name'] ?? 'Document Upload' }}"
                                name="contact" placeholder="Document Upload ">
                            <button type="button" class="btn btn-primary btn-sm view-btn"
                                @if (($user['profile']['proof_of_main_contact'] ?? '') == null) style="display: none" @endif> <a
                                    href="{{ URL::to($user['profile']['proof_of_main_contact'] ?? '') }}" id="view_file"
                                    target="_blank" style="color: white">View</a></button>
                            <br>
                            <br>
                            <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none"> Proof
                                of Authorisation is Required !</p>

                        </div>
                    </div>
                    <div class="form-group row Poof_div-2">
                        <label class="col-md-4 label-control" for="eventRegInput5"> Proof of Authorisation <span style="color: red">*</span>  (?)</label>
                        <div class="col-md-8 mx-auto">

                            <p class="proof_error" style="color:red">Automatic ({{ $user['profile']['job_title'] }})
                                Proof Not Required!</p>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5"> Status</label>
                        <div class="col-md-8 mx-auto">

                            <p class="">{{ $user['user_verified'] }}</p>

                        </div>
                    </div>


                </div>
                <div class="footers">

                    <button type="button" onclick="submitDetailsForm()"
                        class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Update</button>
                    <a href="{{ redirect()->back()->getTargetUrl() }}"><button type="button"
                            class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Cancel</button></a>

                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    {{-- <script src="/modules/admin/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script> --}}


    <script>
        oTable = $('.zero-configuration').DataTable({
            "bPaginate": $('.zero-configuration tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>
    <script>
        $('.btn-1, .btn-2').click(function() {
            // Find the file input only inside the same form-group
            $(this).closest('.form-group').find('input[type=file]').trigger('click');
        });
    </script>
    <script>
        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {

                $('.Poof_div').show();
                var contentHeight = $('#contens').height();
                $('#contens').height(contentHeight);

            } else {
                $('.Poof_div').hide();
                var contentHeight = $('#contens').height();
                $('#contens').height('550px');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                const fileInput = $(this);
                const parentDiv = fileInput.closest('.form-group'); // Scope to this file section
                const fileName = e.target.files[0].name;

                // Update filename display button in the same section
                parentDiv.find('.form-btn').val(fileName);

                // Show the view button and set preview link
                parentDiv.find('.view-btn').show();
                parentDiv.find('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));

                // Hide "Proof required" error text only in this section
                parentDiv.find('.file_proof').hide();

                // Add border highlight
                parentDiv.find('.form-btn').css('border', '2px solid black');
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
            let array = ['name', 'last_name', 'phone_no'];

            let status = false;
            array.some((item) => {
                let name = $(`#${item}`).val();
                console.log(name, item);

                if (name === "" || name === null) {


                    $(`#${item}`).attr('style', 'border:2px solid red!important');

                    status = false;

                    console.log(name, 'jjjj');


                    return false;

                } else {

                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    status = true;

                }
            });
            let file = $('input[name="proof_of_id"]').val();
            if (file === "" && @json($user['proof_id'] ?? null) == null) {

                $(`#proof_of_id`).attr('style', 'border:2px solid red!important');
                $(`.proof_d`).show();

                return true;




            } else {
                $(`.proof_d`).hide();
            }


            const proofDiv = $('.Poof_div');
            const proofVisible = proofDiv.is(':visible');
            // console.log(proofVisible)

            if (proofVisible) {
                const fileInput = proofDiv.find('input[type=file]');
                const fileValue = fileInput.val();
                const oldFile = @json($user['profile']['proof_of_main_contact'] ?? null);


                if (!fileValue && !oldFile) {
                    $('#proof_of_main_contact').attr('style', 'border:2px solid red!important');
                    proofDiv.find('.file_proof').show();
                    isValid = false;
                    return true;
                } else {
                    $('#proof_of_main_contact').attr('style', 'border:2px solid black!important');
                    proofDiv.find('.file_proof').hide();
                }
            }
            array.some((item) => {
                let name = $(`#${item}`).val();
                console.log(name, item);

                if (name === "") {


                    $(`#${item}`).attr('style', 'border:2px solid red!important');

                    status = false;

                    // console.log(name, 'jjjj');

                    return true;

                } else {

                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    status = true;

                }
            });









            if (status === true) {

                $("form").submit();
            }








        }
    </script>

    <script>
        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };
    </script>

    <script>
        $(document).ready(function() {
            function toggleProofDiv() {
                let jobTitle = $('#job_title').val()?.toLowerCase() || '';
                let businessType = @json($user['profile']['organization_status']).toLowerCase();
                let proofDiv = $('.Poof_div');
                let proofDiv2 = $('.Poof_div-2');

                // Default: proof required
                let proofRequired = true;
                console.log(jobTitle)

                // ✅ Not Required (Automatic Verification)
                if (
                    (jobTitle === 'director' && businessType.includes('ltd')) ||
                    (jobTitle === 'partner' && businessType.includes('llp')) ||
                    (jobTitle === 'owner' && (businessType.includes('sole trader') || businessType.includes(
                        'self-employed')))
                ) {
                    proofRequired = false;
                }

                console.log(jobTitle, proofRequired, businessType)

                // Show or hide Proof div
                if (proofRequired) {
                    proofDiv.show();
                    proofDiv2.hide();

                } else {
                    proofDiv.hide();
                    proofDiv2.show();
                    $('.proof_error').text(`Automatic (${jobTitle}) Proof Not Required!`);
                }
            }

            // Run once on load
            toggleProofDiv();

            // Re-run when Role or Business Type changes
            $('#job_title').on('change', function() {
                toggleProofDiv();
                // alert(1);
            });
        });
    </script>
@endsection
