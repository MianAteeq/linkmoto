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



        .badge {

            display: inline-block;

            padding: 0.6em 0.6em;

            font-size: 83%;

        }



        .badge-primary {

            background-color: #1a469b;

        }



        .card-footer {

            border-top: 2px solid black;

            padding: 0.5rem 1rem;

        }



        .upload-box {

            display: inline-block;

            border: 2px solid #ccc;

            border-radius: 10px;

            padding: 8px 20px;

            color: #666;

            font-size: 14px;

            cursor: pointer;

            transition: all 0.3s ease;

        }



        .upload-box:hover {

            border-color: #999;

            color: #333;

        }



        .hr {

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

            font-weight: 500;

            letter-spacing: 0.05rem;

            font-size: 1rem;

        }



        .badge-primary {

            background-color: #1a469b;

            color: white !important;

        }



        .badge-danger {

            background-color: red;

        }

    </style>

@endsection



@section('header')

    <div class="content-header bg-white">

        <div class="row" style="border-bottom: 3px solid #949494;">

            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">

                <h3 class="h3">Business Information</h3>

                <div class="breadcrumb-wrapper col-12">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a>Business</a>

                        </li>



                        <li class="breadcrumb-item"><a style="color: black"

                                href="{{ route('vender.business.detail') }}">Detail</a>

                        </li>



                        <li class="breadcrumb-item">Business information

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

                <h4 class="h3"

                    style="font-weight: 600; font-size: 17px;padding: 1.36rem 0.5rem;border-bottom:2px solid; ">

                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> Business Information





                </h4>

                <p style="padding-left: 10px; padding-right: 10px; line-height: 1.5rem; color: black;">

                    <strong> {{ $user['profile']['organization_status'] }}</strong> <br>

                    @php

                        $status = $user['profile']['business_info'];



                        // Assign Bootstrap badge color classes based on status

                        switch ($status) {

                            case 'Todo':

                                $badgeClass = 'badge badge-secondary'; // gray

                                break;

                            case 'Pending':

                                $badgeClass = 'badge badge-info text-dark'; // yellow

                                break;

                            case 'Verified':

                                $badgeClass = 'badge badge-success'; // green

                                break;

                            case 'Rejected':

                                $badgeClass = 'badge badge-danger'; // red

                                break;

                            default:

                                $badgeClass = 'badge badge-light text-dark'; // default

                                break;

                        }

                    @endphp



                    <span class="{{ $badgeClass }}" style="margin-top:10px">

                        {{ $status }}

                    </span>



                    <br>

                    <br>



                </p>

                <div class="footers" style="border-top: none;">

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

                                    <div class="card-body company_name_text" style="color:black">

                                        This is the exact company name as

                                        registered at Companies House. It

                                        may be different from your trading

                                        name (the name customers see).

                                        Check your official registration

                                        documents if you’re unsure.

                                    </div>

                                </div>

                            </div>

                            <hr class="hr">

                            <a id="company_number" class="card-header info collapsed" data-toggle="collapse"

                                href="#collapsec_c_number" aria-expanded="false" aria-controls="collapsec_c_number">

                                <div class="card-title lead">Registered <span class="cname"

                                        @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>

                                    number (?)</div>

                            </a>

                            <div id="collapsec_c_number" data-parent="#accordionWrap1" role="tabpanel"

                                aria-labelledby="company_number" class="collapse" style="">

                                <div class="card-content">

                                    <div class="card-body company_number_text" style="color:black">

                                        This is your unique Companies House

                                        registration number (8 characters,

                                        usually letters and/or numbers). It

                                        identifies your company officially and

                                        helps us verify your business.

                                    </div>

                                </div>

                            </div>

                            <hr class="hr">

                            <a id="company_address" class="card-header info collapsed" data-toggle="collapse"

                                href="#collapsec_c_address" aria-expanded="false" aria-controls="collapsec_c_address">

                                <div class="card-title lead">Registered <span class="cname"

                                        @if ($user['profile']['organization_status'] != 'Limited Company (Ltd)') style="display: none" @endif>company</span>

                                    address (?)</div>

                            </a>

                            <div id="collapsec_c_address" data-parent="#accordionWrap1" role="tabpanel"

                                aria-labelledby="company_address" class="collapse" style="">

                                <div class="card-content">

                                    <div class="card-body company_address_text" style="color:black">

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

        <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">

            <div class="card default-collapse collapse-icon accordion-icon-rotate"

                style="box-shadow: none;margin-top: -19px;">











                <a id="headingCollapse1" href="{{ redirect()->back()->getTargetUrl() }}" class="card-header info mt-2"

                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"

                    data-toggle="" href="#collaptr_businesss_info" aria-expanded="true">

                    <div class="card-title lead collapsed">Business information</div>

                </a>

                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"

                    style="border-left: 2px solid black;

            margin-top: -4px;

            border-right: 2px solid black;

            border-bottom: 2px solid black;

            border-bottom-left-radius: 6px;

            border-bottom-right-radius: 6px;"

                    class="collapse show" aria-expanded="false">

                    <div class="card-content">

                        <form method="POST" action="{{ route('vender.business.information.update') }}"

                            enctype="multipart/form-data">

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-sm-5">

                                        <h6 class="mb-0">ID</h6>

                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        BSN{{ sprintf('%07d', $user['id']) }}

                                    </div>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-sm-5">

                                        <h6 class="mb-0">Business setup</h6>

                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        {{ $user['profile']['organization_status'] }}

                                    </div>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-sm-5">

                                        <h6 class="mb-0">Registered @if (

                                            $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                                $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                                company

                                            @endif name</h6>

                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        {{ $user['profile']['company_name'] }}

                                    </div>

                                </div>

                                @if (

                                    $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                        $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0">Registered @if (

                                                $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                                    $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                                    company

                                                @endif number</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            {{ $user['profile']['registration_no'] }}

                                        </div>

                                    </div>

                                @endif

                                @if (

                                    $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                        $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0">Registered @if (

                                                $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                                    $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                                    company

                                                @endif Jurisdiction</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            {{ $user['profile']['company_jurisdiction'] }}

                                        </div>

                                    </div>

                                @endif

                                <hr>

                                <div class="row">

                                    <div class="col-sm-5">

                                        <h6 class="mb-0">Registered @if (

                                            $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                                $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                                company

                                            @endif address</h6>

                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        {{ $user['profile']['address_line_1'] }} @if (auth()->user()['profile']['address_line_2'] != null)

                                            ,

                                        @endif {{ $user['profile']['address_line_2'] }} ,

                                        {{ $user['profile']['city'] }} , {{ $user['profile']['postcode'] }}

                                    </div>

                                </div>



                                @if ($user['profile']['organization_status'] == 'Sole Trader / Self Employed')

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0">Companies House Proof</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            {{ $user['profile']['document_proof_name'] }} <a

                                                class="btn btn-primary btn-primary_2"

                                                style="float: right;"

                                                target="_blank"

                                                href="{{ URL::to($user['profile']['document_proof']) }}">View</a>

                                        </div>

                                    </div>

                                @endif







                                @if (

                                    $user['profile']['organization_status'] == 'General Partnership' ||

                                        $user['profile']['organization_status'] == 'Sole Trader / Self-Employed')

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0">Proof of business registration</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            <label class="upload-box">

                                                Document upload

                                                <input type="file" name="document_proof" hidden>

                                            </label>

                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0"> Proof of trading activity</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            <label class="upload-box">

                                                Document upload

                                                <input type="file" name="trading_activity" hidden>

                                            </label>

                                        </div>

                                    </div>

                                @endif

                                @if (

                                    $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||

                                        $user['profile']['organization_status'] == 'Limited Company (Ltd)')

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0">Proof of business registration</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">



                                            <p>

                                                Registered company number supplied. Proof not required.

                                            </p>



                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row">

                                        <div class="col-sm-5">

                                            <h6 class="mb-0"> Proof of trading activity</h6>

                                        </div>

                                        <div class="col-sm-7 text-secondary">

                                            <label class="upload-box">

                                                Document upload

                                                <input type="file" name="trading_activity" hidden>

                                            </label>

                                        </div>

                                    </div>

                                @endif

                                <hr>

                                <div class="row">

                                    <div class="col-sm-5">

                                        <h6 class="mb-0"> Verification Status</h6>

                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        <p>{{ $user['profile']['business_info'] }}</p>



                                    </div>

                                </div>







                            </div>

                            <div class="card-footer">

                                <div class="text-secondary" style="text-align: right">

                                    <a href="{{ route('vender.business.information') }}"

                                        style=" background-color: black !important;

                                       border-color: black !important;"

                                        class="btn btn-primary"> Cancel</a>

                                    <button type="submit"

                                        style=" background-color: black !important;

                                       border-color: black !important;"

                                        class="btn btn-primary"> Save</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>



















            </div>











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

            // On page load

            let value = @json($user['profile']['organization_status']);

            showHideHelpinfo(value);





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

@endsection

