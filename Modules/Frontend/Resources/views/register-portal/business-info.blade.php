@extends('frontend::new-layouts.master')

@section('css')
    <style>
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        #contens {
            border: 2px solid black;
            border-radius: 8px;
            padding: 15px;
            height: auto !important;
            /* let content define height */
            min-height: 530px;
            /* optional baseline height */
            position: relative;
            /* ensures footer absolute positioning works inside */
        }

        #footers {
            bottom: -10px;
            left: 0;
            right: 0;
        }
    </style>
    <style>
        /* Make accordion title bold when open */
        .card-header:not(.collapsed) .card-title {
            font-weight: 700;
            /* bold */
        }

        /* Optional: add transition for smooth effect */
        .card-title {
            transition: font-weight 0.2s ease;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12">
                <h3 class="h3">Business registration application</h3>
            </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">

                <div style="border-radius: 7px;border: 2px solid black;">
                    <h4 class="h3" style="padding: 10px;font-weight: 600;
                font-size: 17px; "> <img
                            src="/home.png" style="width: 22px;margin-top: -5px;"> Your business information
                    </h4>

                    <div class="footers">
                        <h4
                            style="padding-left: 13px;
                        color: black;
                        font-weight: 600;">
                            Help information: </h4>
                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                            <div class="card accordion collapse-icon accordion-icon-rotate"
                                style="box-shadow: none;margin-right: 10px;margin-left: 10px;">

                                <a id="ac_company_name" class="card-header info collapsed" data-toggle="collapse"
                                    href="#collapsec_name" aria-expanded="false" aria-controls="collapsec_name">
                                    <div class="card-title lead">Registered <span class="cname"
                                            @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>
                                        name (?)</div>
                                </a>
                                <div id="collapsec_name" data-parent="#accordionWrap1" role="tabpanel"
                                    aria-labelledby="ac_company_name" class="collapse" style="">
                                    <div class="card-content">
                                        <div class="card-body company_name_text">
                                            This is the exact company name as
                                            registered at Companies House. It
                                            may be different from your trading
                                            name (the name customers see).
                                            Check your official registration
                                            documents if you’re unsure.
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <a id="company_number" class="card-header info collapsed" data-toggle="collapse"
                                    href="#collapsec_c_number" aria-expanded="false" aria-controls="collapsec_c_number">
                                    <div class="card-title lead">Registered <span class="cname"
                                            @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>
                                        number (?)</div>
                                </a>
                                <div id="collapsec_c_number" data-parent="#accordionWrap1" role="tabpanel"
                                    aria-labelledby="company_number" class="collapse" style="">
                                    <div class="card-content">
                                        <div class="card-body company_number_text">
                                            This is your unique Companies House
                                            registration number (8 characters,
                                            usually letters and/or numbers). It
                                            identifies your company officially and
                                            helps us verify your business.
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <a id="company_address" class="card-header info collapsed" data-toggle="collapse"
                                    href="#collapsec_c_address" aria-expanded="false" aria-controls="collapsec_c_address">
                                    <div class="card-title lead">Registered <span class="cname"
                                            @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>
                                        address (?)</div>
                                </a>
                                <div id="collapsec_c_address" data-parent="#accordionWrap1" role="tabpanel"
                                    aria-labelledby="company_address" class="collapse" style="">
                                    <div class="card-content">
                                        <div class="card-body company_address_text">
                                            This is the official address listed at
                                            Companies House. It may be different
                                            from your trading or garage address
                                            where customers drop off vehicles.

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>






                </div>






            </div>

            <div class="col-md-8" id="contens" style="border: 2px solid black;border-radius: 8px;padding: inherit">
                <form action="{{ route('vender.profile.business.info') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="is_save_later" name="is_save_later" value="0">
                    <div class="link-body" style="padding: 10px">
                        <div class="form-group row">
                            <label class="col-md-4 label-control">Business setup <span style="color: red">*</span> </label>
                            <div class="col-md-8 mx-auto">
                                <div class="input-group">


                                    <select name="organization_status" id="organization_status" class="form-control select2"
                                        style="max-width:60%!important">
                                        <option value="Limited Company (Ltd)"
                                            @if ($user['profile']['organization_status'] == 'Limited Company (Ltd)') selected @endif>Limited Company (Ltd)</option>
                                        <option value="Sole Trader / Self-Employed"
                                            @if ($user['profile']['organization_status'] == 'Sole Trader / Self-Employed') selected @endif>Sole Trader / Self-Employed
                                        </option>
                                        <option value="General Partnership"
                                            @if ($user['profile']['organization_status'] == 'General Partnership') selected @endif>General Partnership</option>
                                        <option value="Limited Liability Partnership (LLP)"
                                            @if ($user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)') selected @endif>Limited Liability Partnership
                                            (LLP)</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 label-control" for="eventRegInput5">Registered <span class="cname"
                                    @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span> name <span
                                    style="color: red">*</span> <a style="color: black" href="#collapsec_name"
                                    data-toggle="collapse" aria-expanded="false"
                                    aria-controls="collapsec_name">(?)</a></label>
                            <div class="col-md-8 mx-auto">
                                <input type="tel" id="company_name" value="{{ $user['profile']['company_name'] }}"
                                    class="form-control" onkeyup="lookup(this);" name="company_name" required
                                    placeholder=" ">
                                <p class="text-danger company_name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                    Required !</p>

                            </div>
                        </div>
                        <div class="form-group row company_feild">
                            <label class="col-md-4 label-control" for="eventRegInput5">Registered <span class="cname"
                                    @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span> number
                                <span style="color: red">*</span> <a style="color: black" href="#collapsec_c_number"
                                    data-toggle="collapse" aria-expanded="false"
                                    aria-controls="company_number">(?)</a></label>
                            <div class="col-md-8 mx-auto">
                                <input type="text" id="registration_no" class="form-control"
                                    value="{{ $user['profile']['registration_no'] }}" onkeyup="lookup(this);"
                                    name="registration_no" required placeholder=" ">
                                <p class="text-danger registration_no"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                    Required !</p>

                            </div>
                        </div>
                        <div class="form-group row company_feild">
                            <label class="col-md-4 label-control" for="eventRegInput5">Registered <span
                                    class="cjurisdiction cname"
                                    @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>
                                Jurisdiction </label>
                            <div class="col-md-8 mx-auto">
                                <input type="hidden" id="company_jurisdiction" class="form-control"
                                    value="{{ $user['profile']['company_jurisdiction'] }}" onkeyup="lookup(this);"
                                    name="company_jurisdiction" required placeholder=" ">

                                <p id="jurisdictionResult" class="text-danger"
                                    style="padding-left: 10px;width:100%;margin-bottom: -8px;color:black!important">
                                    {{ $user['profile']['company_jurisdiction'] }}</p>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 label-control" for="eventRegInput5">Registered <span class="cname"
                                    @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span> address
                                <span style="color: red">*</span> <a style="color: black" href="#collapsec_c_address"
                                    data-toggle="collapse" aria-expanded="false"
                                    aria-controls="collapsec_c_address">(?)</a></label>
                            <div class="col-md-8 mx-auto">
                                <input type="tel" id="address_line_1" onkeyup="lookup(this);" class="form-control"
                                    name="address_line_1" required value="{{ $user['profile']['address_line_1'] }}"
                                    placeholder="Address line one *">
                                <input type="tel" id="address_line_2" class="form-control" name="address_line_2"
                                    required value="{{ $user['profile']['address_line_2'] }}" style="margin-top: 5px "
                                    placeholder="Address line two ">
                                <input type="tel" id="eventRegInput5" class="form-control" name="address_line_3"
                                    value="{{ $user['profile']['address_line_3'] }}" style="margin-top: 5px "
                                    placeholder="Address line three ">
                                <input type="tel" id="eventRegInput5" class="form-control" name="address_line_4"
                                    value="{{ $user['profile']['address_line_4'] }}" style="margin-top: 5px "
                                    placeholder="Address line four ">
                                <input type="tel" id="city" class="form-control" onkeyup="lookup(this);"
                                    name="city" required value="{{ $user['profile']['city'] }}"
                                    style="margin-top: 5px " placeholder="City / Town *">
                                <input type="tel" id="postcode" class="form-control" onkeyup="lookup(this);"
                                    name="postcode" required value="{{ $user['profile']['postcode'] }}"
                                    style="margin-top: 5px " placeholder="postcode *">

                                <p class="text-danger address"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">Address Field
                                    is Required !</p>

                            </div>
                        </div>
                        <div class="form-group row" id="proof_doc" style="display: none">
                            <label class="col-md-4 label-control" for="eventRegInput5">Proof of Sole Trader / Self
                                Employed
                                status <span style="color: red">*</span> <a style="color: black"
                                    href="#collapsec_c_proof" data-toggle="collapse" aria-expanded="false"
                                    aria-controls="collapsec_c_proof">(?)</a></label>
                            <div class="col-md-8 mx-auto">
                                <div>
                                    <input type="file" class="d-none" name="document_proof"
                                        accept="image/*,.doc, .docx,.pdf" id="">
                                    <input type="button" id="eventRegInput5" class="form-control form-btn"
                                        value="{{ $user['profile']['document_proof_name'] ?? 'Document Upload' }}"
                                        name="contact" placeholder="Document Upload ">
                                    <button type="button" class="btn btn-primary btn-sm view-btn"
                                        @if ($user['profile']['document_proof_name'] == null) style="display: none" @endif> <a
                                            href="{{ URL::to($user['profile']['document_proof']) }}" id="view_file"
                                            target="_blank" style="color: white">View</a></button>
                                </div>
                                <br>
                                <br>
                                <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none">
                                    Proof
                                    of Sole Trader / Self Employed status is Required !</p>
                            </div>
                        </div>



                    </div>
                    <div class="footers" id="footers">
                        @if ($user['profile']['edit_step'] == 0)
                            <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                onclick="submitDetailsForm()" style="float: right;"> NEXT</button>
                            <button onclick="saveforlater()" type="button"
                                class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">SAVE AND
                                EXIT</button>
                            <a href="{{ route('vender.profile.back', $user['profile']['step']) }}"> <button
                                    type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">PREVIOUS</button></a>
                        @else
                            <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                onclick="submitDetailsForm()" style="float: right;"> UPDATE</button>
                        @endif

                    </div>
                </form>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // On page load
            let value = $('#organization_status').val();
            toggleFields(value);

            // On change
            $('#organization_status').change(function() {
                toggleFields(this.value);

            });

            function toggleFields(value) {
                if (value === 'Limited Company (Ltd)' || value === 'Limited Liability Partnership (LLP)') {
                    $('.cname').show();
                    $('.company_feild').show();
                    $('#company_number').show();


                } else {

                    $('.cname').hide();
                    $('.company_feild').hide();
                    $('#company_number').hide();
                }

                showHideHelpinfo(value);
            }
        });
    </script>

    <script>
        function showHideHelpinfo(value) {

            if (value === "Limited Liability Partnership (LLP)") {

                $('.company_name_text').html(
                    `This is the exact LLP name as registered at Companies House. It may be different from your trading name (the name customers see).`
                );
                $('.company_number_text').html(
                    `This is your unique Companies House registration number (8 characters, usually letters and/or numbers) that officially identifies your LLP.`
                );
                $('.company_address_text').html(
                    `This is the official address listed at Companies House. It may be different from your trading or garage address where customers drop off vehicles.`
                );


            }
            if (value === "Sole Trader / Self-Employed") {

                $('.company_name_text').html(
                    ` This is the name of the person who legally owns the business.`
                );
                $('.company_number_text').html(
                    ``
                );
                $('.company_address_text').html(
                    ` This is the address where your business operates.`
                );

            }
            if (value === "General Partnership") {

                $('.company_name_text').html(
                    `This is the official name of your partnership. If your partnership doesn’t have a formal name, you can use the owner(s) names or a commonly used garage name.
                    <strong>A trading name will be asked separately later</strong> for customer facing purposes.`
                );
                $('.company_number_text').html(
                    ``
                );
                $('.company_address_text').html(
                    `This is the address where your business operates.`
                );

            }
            if (value === "Limited Company (Ltd)") {

                $('.company_name_text').html(
                    `This is the exact company name as registered at Companies House. It may be different from your trading name (the name customers see). Check your official registration documents if you’re unsure.`
                );
                $('.company_number_text').html(
                    `This is your unique Companies House registration number (8 characters, usually letters and/or numbers). It identifies your company officially and helps us verify your business.`
                );
                $('.company_address_text').html(
                    `This is the official address listed at Companies House. It may be different from your trading or garage address where customers drop off vehicles.`
                );

            }

        }
    </script>

    <script>
        $('.form-btn').click(function() {
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
        function submitDetailsForm() {
            let organization_status = $('#organization_status').val();;

            let status = false;
            let company_name = $('#company_name').val();
            let registration_no = $('#registration_no').val();

            let address_line_1 = $('#address_line_1').val();
            let address_line_2 = $('#address_line_2').val();
            let city = $('#city').val();
            let postcode = $('#postcode').val();
            let company_jurisdiction = $('#company_jurisdiction').val();

            if (company_name === "") {

                $('.company_name').show();
                $('#company_name').attr('style', 'border:2px solid red!important');

                status = false;
                return false;

            } else {
                $('.company_name').hide();
                $('#company_name').attr('style', 'border:2px solid black!important');
                status = true;

            }
            if (organization_status === "Limited Company (Ltd)") {
                if (registration_no === "") {

                    $('.registration_no').show();
                    $('#registration_no').attr('style', 'border:2px solid red!important');

                    status = false;
                    return false;

                } else {
                    $('.registration_no').hide();
                    $('#registration_no').attr('style', 'border:2px solid black!important');
                    status = true;
                }
                if (company_jurisdiction === "") {
                    $('.company_jurisdiction').show();
                    $('#company_jurisdiction').attr('style', 'border:2px solid red!important;margin-top: 5px ');
                    status = false;
                    return false;


                } else {
                    // $('.address').hide();
                    $('#company_jurisdiction').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                    status = true;


                }
            }


            if (address_line_1 === "") {
                $('.address').show();
                $('#address_line_1').attr('style', 'border:2px solid red!important;margin-top: 5px ');
                status = false;
                return false;


            } else {
                // $('.address').hide();
                $('#address_line_1').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                status = true;


            }



            if (city === "") {
                $('.address').show();
                $('#city').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                status = false;
                return false;

            } else {
                // $('.address').hide();
                $('#city').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                status = true;


            }
            if (postcode === "") {
                $('.address').show();
                $('#postcode').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                status = false;
                return false;

            } else {
                // $('.address').hide();
                $('#postcode').attr('style', 'border:2px solid black!important;margin-top: 5px ');
                status = true;

            }
            if (postcode !== "" && city !== "" && address_line_1 !== "" && address_line_2 !== "") {
                $('.address').hide();
            }








            $("form").submit();




        }
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





            if (id.indexOf("address") >= 0) {
                let address_line_1 = $('#address_line_1').val();
                let address_line_2 = $('#address_line_2').val();
                let city = $('#city').val();
                let postcode = $('#postcode').val();
                if (address_line_1 !== "" && address_line_2 !== "" && city !== "" && postcode !== "") {
                    $(`.address`).hide();
                }
            }
            if (id.indexOf("city") >= 0) {
                let address_line_1 = $('#address_line_1').val();
                let address_line_2 = $('#address_line_2').val();
                let city = $('#city').val();
                let postcode = $('#postcode').val();
                if (address_line_1 !== "" && address_line_2 !== "" && city !== "" && postcode !== "") {
                    $(`.address`).hide();
                }
            }
            if (id.indexOf("postcode") >= 0) {
                let address_line_1 = $('#address_line_1').val();
                let address_line_2 = $('#address_line_2').val();
                let city = $('#city').val();
                let postcode = $('#postcode').val();
                if (address_line_1 !== "" && address_line_2 !== "" && city !== "" && postcode !== "") {
                    $(`.address`).hide();
                }
            }
            if (id.indexOf("name") >= 0) {
                let first_name = $('#first_name').val();
                let last_name = $('#last_name').val();
                let middle_name = $('#middle_name').val();

                if (first_name !== "" && last_name !== "" && middle_name !== "") {
                    $(`.name`).hide();
                }
            }
            if (id.indexOf("city") >= 0) {
                let first_name = $('#first_name').val();
                let last_name = $('#last_name').val();
                let middle_name = $('#middle_name').val();

                if (first_name !== "" && last_name !== "" && middle_name !== "") {
                    $(`.name`).hide();
                }
            }
            if (id.indexOf("postcode") >= 0) {
                let first_name = $('#first_name').val();
                let last_name = $('#last_name').val();
                let middle_name = $('#middle_name').val();

                if (first_name !== "" && last_name !== "" && middle_name !== "") {
                    $(`.name`).hide();
                }
            }








        }
    </script>
    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>

    <script>
        function detectJurisdiction(number) {
            if (!number) return "";

            // Normalize input
            let val = number.toUpperCase().trim();

            // Check prefixes
            if (val.startsWith("SC") || val.startsWith("SL") || val.startsWith("SO") || val.startsWith("SF")) {
                return "Scotland";
            } else if (val.startsWith("NI") || val.startsWith("R0") || val.startsWith("NL")) {
                return "Northern Ireland";
            } else {
                return "England and Wales";
            }
        }

        document.getElementById("registration_no").addEventListener("input", function() {
            const result = detectJurisdiction(this.value);
            document.getElementById("jurisdictionResult").textContent = result ? result : "";
            $('#company_jurisdiction').val(result);
        });
    </script>
@endsection
