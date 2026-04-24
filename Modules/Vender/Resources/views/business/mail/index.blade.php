@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* 1. LAYOUT FOUNDATIONS */
        .content-wrapper {
            min-height: 85vh !important;
            background-color: #f4f7fa;
            /* Light gray background to make white boxes pop */
        }

        /* 2. BOX STYLING (Sidebar & Main Box) */
        .info-sidebar,
        .main-content-box {
            background-color: white;
            border: 2px solid #000;
            border-radius: 8px;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.05);
            height: 100%;
            /* Ensures both boxes take equal height if needed */
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* 3. INTERNAL HEADERS */
        .box-header {
            padding: 15px 20px;
            border-bottom: 2px solid #000;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .box-header h3,
        .box-header h4 {
            margin: 0;
            font-weight: 700;
            color: #000;
            font-size: 1.1rem;
        }

        /* 4. CONTENT SPACING */
        .box-body {
            padding: 20px;
            flex-grow: 1;
        }

        /* 5. TABLE STRETCH & BORDER FIX */
        .dataTables_wrapper {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 15px 0 !important;
        }

        /* Fix for missing right border */
        .table-responsive {
            border: none !important;
            overflow-x: auto;
            padding: 1px;
            /* Small buffer to prevent border clipping */
        }

        /* 6. BUTTONS & FOOTER */
        .box-footer {
            padding: 15px 20px;
            border-top: 2px solid #000;
            background: #fff;
            text-align: right;
        }

        .btn-dark {
            background-color: #000 !important;
            border: none !important;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 6px;
        }

        /* 7. SEARCH BAR */
        .search-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-container input {
            border: 2px solid #000;
            border-radius: 6px;
            padding: 10px 15px;
        }

        /* 8. RESPONSIVE ALIGNMENT */
        @media (max-width: 991px) {
            .info-sidebar-wrapper {
                margin-bottom: 25px;
            }

            .col-lg-9 {
                padding-left: 15px !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Email Addresses</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Email Addresses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        {{-- Breadcrumb Row - Aligned with boxes below --}}
        <div class="row mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent; padding-left: 0;">
                        <li class="breadcrumb-item"><a href="#" style="color: #666;">Business</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #000; font-weight: 600;">Email
                            Addresses</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row align-items-stretch">
            {{-- Left Sidebar --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-3 mb-lg-0">
                <div class="info-sidebar">
                    <div class="box-header">
                        <img src="/home.png" style="width: 20px;">
                        <h4>Email Addresses</h4>
                    </div>
                    <div class="box-body">
                        <p style="line-height: 1.6; color: #444; font-size: 0.9rem; margin: 0;">
                            Add and manage your business email addresses here. These will be linked in other sections such
                            as remittance advise, invoice settings, and billing notifications.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-12 col-lg-9">
                <div class="main-content-box" id="contens">
                    <div class="box-header">
                        <h3>Email Addresses</h3>
                    </div>

                    <div class="box-body">
                        {{-- Search Section --}}
                        <div class="search-container">
                            <div style="flex-grow: 1;">
                                <input type="text" class="form-control" id="myInputTextField" placeholder="Search...">
                            </div>
                            <a href="#"><i class="ft-filter" style="font-size: 24px; color: #000;"></i></a>
                        </div>

                        {{-- Table Section --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>Label</th>
                                        <th>Email Address</th>
                                        <th style="width: 15%; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($banks as $bank)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bank['label'] }}</td>
                                            <td>{{ $bank['email'] }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('vender.mail.view', $bank['id']) }}">
                                                    <i class="ft-eye" style="color: #ff6600;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- DataTables handles the empty message, but we keep the structure clean --}}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Action Footer --}}
                    <div class="box-footer">
                        <a href="{{ route('vender.mail.add') }}" class="btn btn-dark">
                            Add
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Destroy existing instance to avoid the "reinitialise" error
            if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                $('.zero-configuration').DataTable().destroy();
            }

            var oTable = $('.zero-configuration').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": true,
                "autoWidth": false,
                "dom": 't', // Only show the table (custom search handled below)
                "language": {
                    "emptyTable": "No data available in table"
                }
            });

            // Force the table to recalculate its width to match the professional spacing
            setTimeout(function() {
                oTable.columns.adjust().draw();
            }, 200);

            // Custom search trigger
            $('#myInputTextField').on('keyup', function() {
                oTable.search(this.value).draw();
            });
        });
    </script>
@endsection
