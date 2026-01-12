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

    <style>

        .section {

            border: 1px solid #000;

            border-radius: 6px;

            margin-bottom: 20px;

            overflow: hidden;

        }



        .section-header {

            font-weight: bold;

            font-size: 16px;

            padding: 10px 15px;

            border-bottom: 1px solid #000;

            background: white;

        }



        .section-body {

            padding: 10px 15px;

        }



        .item {

            display: grid;

            grid-template-columns: 1fr auto 1fr;

            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid #ddd;

        }



        .item:last-child {

            border-bottom: none;

        }



        .item a {

            color: black;

            text-decoration: none;

            font-weight: 500;

        }



        .badge {

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;

            color: #fff;

            display: inline-block;

            text-align: center;

            min-width: 80px;

        }



        .badge.todo {

            background: #007bff;

        }



        .badge.verified {

            background: #28a745;

        }



        .badge.pending {

            background: #999;

        }



        .timestamp {

            font-size: 12px;

            color: #555;

            text-align: right;

            white-space: nowrap;

        }



        @media (max-width: 600px) {

            .item {

                grid-template-columns: 1fr;

                row-gap: 5px;

            }



            .badge {

                justify-self: start;

            }



            .timestamp {

                justify-self: start;

            }

        }

    </style>

@endsection



@section('header')

    <div class="content-header bg-white">

        <div class="row" style="border-bottom: 3px solid #949494;">

            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">

                <h3 class="h3">Verifications</h3>

                <div class="breadcrumb-wrapper col-12">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a>Business</a>

                        </li>







                        <li class="breadcrumb-item">Verifications

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

                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 1rem 0.5rem;border-bottom:2px solid; ">

                    <img src="/not-pad.png" style="width: 30px;margin-top: -5px;"> Verifications





                </h4>

                <p style="padding-left: 10px; padding-right: 10px; line-height: 1.5rem; color: black;">

                    Track the status of key business

                    items that require approval: <br>

                    <strong>• Business Verification</strong><br>

                    (registration) <br>

                    <strong>• VAT</strong><br>

                    <strong>• Main Contacts</strong><br>

                    <strong> • Sites</strong><br>

                    <strong> • Bank Accounts</strong><br>

                    Each item may require supporting

                    documents. Statuses: <strong>To-Do,

                        Pending, Verified, Rejected,

                        Cancelled, Inactive</strong>



                </p>





            </div>

        </div>

        <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">



            <div class="section">

                <div class="section-header">Business Verification</div>

                <div class="section-body">

                    <div class="item">

                        <a href="{{ route('vender.business.information') }}"> {{ $user['profile']['company_name'] }}</a>

                        @php

                            $status = $user['profile']['business_info'];



                            // Assign Bootstrap badge color classes based on status

                            switch ($status) {

                                case 'Todo':

                                    $badgeClass = 'badge todo'; // gray

                                    break;

                                case 'Pending':

                                    $badgeClass = 'badge pending'; // yellow

                                    break;

                                case 'Verified':

                                    $badgeClass = 'badge verified'; // green

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

                        <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}</div>

                    </div>

                </div>

            </div>



            <div class="section">

                <div class="section-header">VAT Verification</div>

                <div class="section-body">

                    @if ($user['profile']['vat_register'] == 'No')

                        <div class="item">

                            <a href="{{ route('vender.business.vat') }}">UK VAT registered: No</a>

                            <span class="badge verified">Verified</span>

                            <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}

                            </div>

                        </div>

                    @else

                        <div class="item">

                            <a href="{{ route('vender.business.vat') }}">UK VAT registered: Yes</a>

                            @php

                                $status = $user['profile']['vat_info'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

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

                            <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}

                            </div>

                        </div>

                    @endif

                </div>

            </div>



            <div class="section">

                <div class="section-header">Main Contacts Verification</div>

                <div class="section-body">

                    <div class="item">

                        <a href="{{ route('vender.main.contact.view', $user['id']) }}">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}</a>

                        @php

                            $status = $user['user_verified'];



                            // Assign Bootstrap badge color classes based on status

                            switch ($status) {

                                case 'Todo':

                                    $badgeClass = 'badge todo'; // gray

                                    break;

                                case 'Pending':

                                    $badgeClass = 'badge pending'; // yellow

                                    break;

                                case 'Verified':

                                    $badgeClass = 'badge verified'; // green

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

                        <div class="timestamp">Last updated {{ $user->updated_at->format('d M Y, H:i') }}</div>

                    </div>

                    @foreach ($users as $main)

                        <div class="item">

                            <a href="{{ route('vender.main.contact.view', $main['id']) }}">{{ $main['name'] }} {{ $main['middle_name'] }} {{ $main['last_name'] }}</a>

                            @php

                                $status = $main['user_verified'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

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

                            <div class="timestamp">Last updated {{ $main->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach



                </div>

            </div>



            <div class="section">

                <div class="section-header">Sites Verifications</div>

                <div class="section-body">

                    @foreach ($sites as $site)

                        <div class="item">

                            <a href="{{ route('vender.site.view', $site['id']) }}">{{ $site['address_line_1'] }} {{ $site['address_line_2'] }}</a>

                            @php

                                $status = $site['status'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

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

                            <div class="timestamp">Last updated {{ $site->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach

                </div>

            </div>



            <div class="section">

                <div class="section-header">Bank Accounts Verification</div>

                <div class="section-body">

                    @foreach ($banks as $bank)

                        <div class="item">

                            <a href="{{ route('vender.bank.view', $bank['id']) }}">{{ $bank['bank_name'] }} | {{ $bank['account_name'] }} |

                                {{ $bank['account_number'] }} </a>

                            @php

                                $status = $bank['status'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

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

                            <div class="timestamp">Last updated {{ $bank->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach

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

