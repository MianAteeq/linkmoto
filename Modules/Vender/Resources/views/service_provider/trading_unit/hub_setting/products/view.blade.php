@extends('vender::layouts.master')

@section('css_custom')
    <link href="/modules/admin/app-assets/vendors/css/forms/selects/select2.min.css" rel="stylesheet" />
    <style>
        /* ================= ORIGINAL STYLES (UNCHANGED) ================= */

        .select2-container {
            width: 55% !important;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border: 2px solid black;
            border-radius: 6px;
            border-color: black !important;
        }

        .footers {
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

        form .form-control {
            border: 2px solid #000000;
            color: #000000;
        }

        p {
            color: black;
        }

        .form-control:focus {
            color: #000000;
            background-color: #fff;
            border-color: #000000;
            outline: 0;
            box-shadow: none;
        }

        .form-control {
            width: 55%;
        }

        #headingCollapse1:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845" !important;
            transition: all 300ms linear 0s;
        }

        .select2-container--default {
            color: #000000;
        }

        .select2-dropdown {
            width: 414px !important;
            min-width: 315.516px !important;
            position: relative;
        }

        .select2-container--default .select2-selection--single {
            height: 40px !important;
            padding: 5px;
            border-color: black !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 2px solid black !important;
            border-radius: 4px;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            width: 54%;
        }

        .tag {
            background-color: #f58220;
            color: white;
            padding: 9px 11px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            font-size: 14px;
        }

        .tag .close {
            margin-left: 8px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }

        /* ================= RESPONSIVE FIXES ================= */

        /* Global safety */
        img {
            max-width: 100%;
            height: auto;
        }

        h3,
        h4,
        span,
        p {
            word-wrap: break-word;
        }

        .breadcrumb {
            flex-wrap: wrap;
        }

        .btn {
            white-space: normal;
        }

        .card {
            overflow: hidden;
        }

        /* Fix tabs wrapping */
        #contens .row {
            flex-wrap: wrap;
        }

        #contens .row a {
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Remove float issues */
        .float-left {
            float: none !important;
        }

        /* ================= MOBILE ================= */
        @media (max-width: 768px) {

            .col-md-3,
            .col-md-9 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .col-md-3 {
                margin-bottom: 15px;
            }

            /* Fix sidebar floats */
            .col-md-3 div[style*="float: left"] {
                width: 100% !important;
                float: none !important;
                margin-bottom: 5px;
            }

            /* Fix select2 */
            .select2-container {
                width: 100% !important;
            }

            .select2-dropdown {
                width: 100% !important;
                min-width: 100% !important;
            }

            /* Inputs full width */
            .form-control {
                width: 100% !important;
            }

            /* Tags full width */
            .tag-container {
                width: 100% !important;
            }

            /* Product info rows stack */
            .row.mt-1 {
                display: flex;
                flex-direction: column;
            }

            .row.mt-1 .col-sm-5,
            .row.mt-1 .col-sm-7 {
                max-width: 100%;
                flex: 100%;
            }

            .row.mt-1 .col-sm-5 {
                margin-bottom: 5px;
            }

            /* Buttons full width */
            .footers button {
                width: 100% !important;
                float: none !important;
                margin-bottom: 8px;
            }

            /* Fix tag header */
            .tags {
                float: none !important;
                margin-top: 10px;
                margin-right: 0 !important;
            }
        }

        /* ================= TABLET ================= */
        @media (min-width: 769px) and (max-width: 1024px) {

            .col-md-3 {
                flex: 0 0 35%;
                max-width: 35%;
            }

            .col-md-9 {
                flex: 0 0 65%;
                max-width: 65%;
            }

            .form-control,
            .select2-container,
            .tag-container {
                width: 80% !important;
            }
        }

        /* ================= DESKTOP ================= */
        @media (min-width: 1025px) {
            .form-control {
                width: 55%;
            }
        }
    </style>
    <style>
        .dropdown-menu {
            min-width: 150px;
            border-radius: 8px;
        }

        .dropdown-item {
            font-size: 14px;
        }
    </style>
@endsection


@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">View Products</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a></li>

                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider') }}">Service
                                Provider</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                                {{ $trading_unit['name'] }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                                style="color: black">App Settings</a></li>
                        <li class="breadcrumb-item"> <a
                                href="{{ url('vender/service/provider/trading/unit/app/setting/' . $trading_unit['id']) }}#product_offera"
                                style="color: black">Products</a>
                        </li>
                        <li class="breadcrumb-item">View Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 8px; border: 2px solid black; overflow: hidden; background-color: #fff;">

                <div style="display: flex; align-items: center; padding: 16px; border-bottom: 2px solid black;">
                    <img src="/gear-black.png" style="width: 38px; margin-right: 12px; flex-shrink: 0;" alt="Gear">

                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                        <span style="color: #F07D44; font-size: 15px;">Product:</span>
                        <span style="font-weight: 600; font-size: 18px; color: #000; margin-top: 2px;">MOT</span>
                    </div>
                </div>

                <div style="padding: 16px;">

                    <div style="margin-bottom: 16px; line-height: 1.4;">
                        <div style="color: #F07D44; font-size: 14px;">Created:</div>
                        <div style="font-size: 14px; color: #000;">12/07/2024 at 4:59am</div>
                    </div>

                    <div style="line-height: 1.4;">
                        <div style="color: #F07D44; font-size: 14px;">Last updated:</div>
                        <div style="font-size: 14px; color: #000;">15/10/2024 at 10am</div>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
            <div class="row">
                <a href="{{ redirect()->back()->getTargetUrl() }} ">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: white!important;margin-left: 15px;background-color:black">
                        &lt; Back
                    </h4>
                </a>
            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">

                <a id="headingCollapse1" href="{{ redirect()->back()->getTargetUrl() }}" class="card-header info mt-0"
                    style="border: 2px solid black;border-radius: 7px; padding: 0.8rem 0.8rem;color: black;">
                    <div class="card-title lead collapsed" style="text-align: left; color: black; padding-top: 20px;">
                        Product Information
                        <div class="tags" style="float: right; margin-right: 40px;">
                            <div class="tag">Service Provider</div>
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>

                <div class="collapse show"
                    style="border-left: 2px solid black;margin-top: -4px;border-right: 2px solid black;border-bottom: 2px solid black;border-radius: 0 0 6px 6px;">
                    <div class="card-content">
                        <form action="{{ route('vender.service.provider.trading.unit.hub.setting.product.offer.update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="link-body" style="padding: 10px">

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>ID</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $product['product_no'] }}</div>
                                    <div class="position-relative">

                                        <!-- 3 DOT MENU -->
                                        <div class="dropdown" style="position: absolute; top: -13px; right: 10px;">
                                            <button class="btn p-1 shadow-none" type="button" data-bs-toggle="dropdown"
                                                style="border: none; background: transparent;">
                                                <span style="font-size: 24px; font-weight: bold; color: #000;">⋮</span>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end"
                                                style="border: 2px solid #000; border-radius: 6px; padding: 0; min-width: 130px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

                                                <li>
                                                    <a class="dropdown-item"
                                                        style="color: #333; font-size: 14px; font-weight: 400; padding: 8px 16px; cursor: pointer; margin: 0;"
                                                        onclick="handleDelete({{ $product['id'] }}, {{ $is_reference == 1 ? 'true' : 'false' }})">
                                                        Delete Product
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Product Name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $product['product_name'] }}</div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Job Type</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ collect($jobstypes)->pluck('name')->implode(', ') }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Job Request Description</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <strong>
                                            {{ collect($jobstypes)->pluck('name')->implode(', ') }}
                                        </strong>
                                        <br>
                                        @php
                                            $jobTypeString = collect($jobstypes)->pluck('name')->implode(', ');
                                            $cleanDescription = trim(
                                                str_replace($jobTypeString, '', $product['description']),
                                            );
                                        @endphp


                                        {{ $cleanDescription }}

                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Job Coverage</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $product['job_coverage']['name'] }}</div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Price Type</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($product['price_type'] == 'FIXED')
                                            Fixed
                                        @endif
                                        @if ($product['price_type'] == 'STARTING_FROM')
                                            Starting From
                                        @endif
                                        @if ($product['price_type'] == 'HOURLY')
                                            Hourly
                                        @endif
                                        @if ($product['price_type'] == 'POA')
                                            POA
                                        @endif
                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Price (£)</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($product['price_type'] == 'POA')
                                            POA
                                        @else
                                            {{ number_format($product['price'], 2, '.', '') }}
                                        @endif
                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <h6>Status</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">

                                        @if ($product['status'] == 'ACTIVE')
                                            Active
                                        @else
                                            InActive
                                        @endif


                                    </div>
                                </div>

                            </div>

                            <!-- FOOTER BUTTONS -->
                            <div class="footers">
                                <a
                                    href="{{ route('vender.service.provider.trading.unit.hub.setting.edit.product.offer', [$product['id'], $trading_unit['id']]) }}">
                                    <button type="button" class="btn btn-dark round mr-1 mb-1"
                                        style="float: right;">Edit</button>
                                </a>
                            </div>

                        </form>
                    </div>

                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-3">

                                <h5 class="text-danger">Delete Product</h5>
                                <p class="mb-3">
                                    You are about to permanently delete this product. This action cannot be undone.
                                </p>

                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="d-flex justify-content-between">

                                        <!-- DELETE BUTTON -->
                                        <button type="submit" class="btn btn-dark">
                                            DELETE PRODUCT
                                        </button>

                                        <!-- CANCEL BUTTON -->
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                                            CANCEL
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="cannotDeleteModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-3">

                                <h5 class="text-danger">Delete Product</h5>
                                <p>
                                    This product cannot be deleted because it is currently referenced in the system.
                                    You can deactivate it instead.
                                </p>

                                <div class="text-center mt-3">
                                    <button class="btn btn-dark" data-bs-dismiss="modal">OK</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts_lib')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleDelete(productId, isReferenced) {

            if (isReferenced) {
                let modal = new bootstrap.Modal(document.getElementById('cannotDeleteModal'));
                modal.show();
            } else {
                let form = document.getElementById('deleteForm');
                form.action = @json(route('vender.service.provider.trading.unit.hub.setting.delete.product.offer', [
                        $product['id'],
                        $trading_unit['id'],
                    ])); // adjust route

                let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
            }
        }
    </script>

    <script>
        function closeModal(modalId) {
            const modalEl = document.getElementById(modalId);

            if (window.bootstrap && bootstrap.Modal) {
                // Bootstrap 5
                let modalInstance = bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);

                modalInstance.hide();
            } else if (window.$) {
                // Bootstrap 4
                $('#' + modalId).modal('hide');
            } else {
                // Fallback
                modalEl.style.display = 'none';
            }
        }

        function handleDelete(productId, isReferenced) {
            if (isReferenced) {
                let modal = new bootstrap.Modal(document.getElementById('cannotDeleteModal'));
                modal.show();
            } else {
                document.getElementById('deleteForm').action = @json(route('vender.service.provider.trading.unit.hub.setting.delete.product.offer', [
                        $product['id'],
                        $trading_unit['id'],
                    ]));;
                let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
            }
        }
    </script>
@endsection
