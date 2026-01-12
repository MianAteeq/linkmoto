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

        .badge {
            display: inline-block;
            padding: 0.6em 0.6em;
            font-size: 83%;
        }

        .badge-primary {
            background-color: #1a469b;
            color: white !important;
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-secondary {
            background-color: rgb(0 111 192);
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
            margin-right: -15px;
            margin-left: -15px;
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
                        <li class="breadcrumb-item">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}
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
                    <img src="/home.png" style="width: 22px;margin-top: -5px;">
                    Main Contact
                </h4>
                <p
                    style="padding-left: 10px; padding-right: 10px; line-height: 1.5rem; color: black; border-top: 2px solid black; ">

                    <strong>{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}</strong> <br>

                    @php
                        $status = $user['user_verified'];

                        // Assign Bootstrap badge color classes based on status
                        switch ($status) {
                            case 'Todo':
                                $badgeClass = 'badge badge-secondary'; // gray
                                break;
                            case 'Pending':
                                $badgeClass = 'badge badge-primary text-dark'; // yellow
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
                    Created on: {{ $user['profile']->created_at->format('d M Y, H:i') }} <br>
                    Last updated: {{ $user['profile']->updated_at->format('d M Y, H:i') }}
                    @if ($status == 'Pending')
                        <p
                            style="border-top:2px solid;padding-left: 10px;text-align: center;padding-top: 10px; padding-right: 10px; line-height: 1.5rem; color: black; ">
                            <a href="{{ route('vender.main.contact.verify', $user['id']) }}"
                                style=" background-color: black !important;
                                       border-color: black !important;"
                                class="btn btn-primary"> Cancel Verification</a>

                        </p>
                    @endif

                </p>

            </div>
        </div>
        <div class="col-md-9" id="contens"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0;padding-right: 0;">
            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Main
                        contact information</h3>
                </div>
                <div class="col-md-12">
                    <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        style="" class="collapse show" aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ sprintf('%04d', $user['id']) }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">First name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['name'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Middle name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['middle_name'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Last name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['last_name'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['email'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Mobile</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['sub_profile']['phone_no'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Job title / Position</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['job_title'] }}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0"> Proof of Id</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($user['proof_id'] == null)
                                            <p style="color:red"> Proof documentation upload required</p>
                                        @else
                                            Proof.{{Str::after($user['proof_id'], '.')}} <a class="btn btn-primary btn-primary_2"
                                                style="float: right;"
                                                target="_blank" href="{{ URL::to($user['proof_id'] ?? '') }}">View</a>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                @php
                                    $jobTitle = strtolower($user['profile']['job_title'] ?? '');
                                    $businessType = strtolower($user['profile']['organization_status'] ?? '');
                                    $proofRequired = true;

                                    // Auto-verified (no proof required)
                                    if (
                                        ($jobTitle === 'director' && str_contains($businessType, 'ltd')) ||
                                        ($jobTitle === 'partner' && str_contains($businessType, 'llp')) ||
                                        ($jobTitle === 'owner' &&
                                            (str_contains($businessType, 'sole trader') ||
                                                str_contains($businessType, 'self-employed')))
                                    ) {
                                        $proofRequired = false;
                                    }
                                @endphp

                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Proof of Authorisation</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($proofRequired)
                                            @if (!empty($user['profile']['proof_of_main_contact']))
                                                {{ $user['profile']['proof_of_main_contact_name'] ?? 'Document Uploaded' }}
                                                <a class="btn btn-primary btn-primary_2"
                                                    style="float: right;"
                                                    target="_blank"
                                                    href="{{ URL::to($user['profile']['proof_of_main_contact']) }}">
                                                    View
                                                </a>
                                            @else
                                                <span style="color:red">Proof Required (Not Uploaded)</span>
                                            @endif
                                        @else
                                            <span class="">Automatic ({{ $user['profile']['job_title'] }}).
                                                Proof not required.</span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p>{{ $user['user_verified'] }}</p>
                                    </div>
                                </div>












                            </div>
                            @if ($user['user_verified'] != 'Pending')
                                <div class="card-footer">
                                    <div class="text-secondary" style="text-align: right">
                                        <a href="{{ route('vender.main.contact.edit', $user['id']) }}"
                                            style=" background-color: black !important;
                                       border-color: black !important;"
                                            class="btn btn-primary"> Edit</a>
                                    </div>
                                </div>
                            @endif
                        </div>
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
@endsection
