@extends('vender::layouts.master')

@section('css_custom')
<link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
<style>
/* Table Resets */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info {
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

/* Icons & Structural */
.collapsed {
  border-bottom-left-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
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

/* Custom Containers */
.info-sidebar {
  border-radius: 7px;
  border: 2px solid black;
  height: 100%;
}

.main-content-box {
  border: 2px solid black;
  border-radius: 6px;
  margin-bottom: 10px;
  padding: 0;
  display: flex;
  flex-direction: column;
}

/* Content inside main box takes up remaining space above footer */
.main-content-inner {
  flex-grow: 1;
  padding-bottom: 20px;
}

/* Ensure wide tables scroll smoothly on mobile */
.table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

/* --- RESPONSIVE MEDIA QUERIES --- */
@media (max-width: 767.98px) {
  .headerbg {
    padding-left: 25px !important;
  }

  /* Adds spacing between the stacked info box and the main table */
  .info-sidebar-wrapper {
    margin-bottom: 20px;
  }

  .footers .btn-dark {
    float: none !important;
    width: 100%;
    display: block;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white">
  <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
    <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
      <h3 class="h3">Bank Accounts</h3>
      <div class="breadcrumb-wrapper col-12 p-0">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Business</a></li>
          <li class="breadcrumb-item">Bank Accounts</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-md-4 col-lg-3 info-sidebar-wrapper">
    <div class="info-sidebar">
      <h4 class="h3" style="font-weight: 600; font-size: 17px; padding: 10px; margin: 0;">
        <img src="/home.png" style="width: 22px; margin-top: -5px;"> Bank Accounts
      </h4>
      <p style="border-top: 2px solid black; padding: 10px; line-height: 1.5rem; color: black; margin: 0;">
        Add and manage your business bank accounts here. These will be linked in other sections such as invoice document
        settings and payout account selection. Multiple accounts can be stored for different purposes (e.g. main
        business account, remittance, trade unit specific account, etc).
        <br><br>
        At least 1 bank account needs to be added for the <a>Payout Account</a>.
      </p>
    </div>
  </div>

  <div class="col-12 col-md-8 col-lg-9">
    <div class="main-content-box" id="contens">

      <div class="main-content-inner">
        <div class="row m-0" style="border-bottom: 2px solid black;">
          <div class="col-12 p-0">
            <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">
              Bank Accounts
            </h3>
          </div>
        </div>

        <div class="row m-0 mt-3 px-2 align-items-center">
          <div class="col-10 col-md-11 pr-1">
            <input type="text" class="form-control" id="myInputTextField"
              style="border: 2px solid black; border-radius: 6px;" placeholder="Search">
          </div>
          <div class="col-2 col-md-1 text-center pl-0">
            <a href="">
              <i class="ft-filter" style="font-size: 30px; color: black; line-height: 1;"></i>
            </a>
          </div>
        </div>

        <div class="row m-0 mt-3 px-2">
          <div class="col-12 p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered zero-configuration w-100">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Sort Code</th>
                    <th>Account Number</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($banks as $bank)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bank['label'] }}</td>
                    <td>{{ $bank['bank_name'] }}</td>
                    <td>{{ $bank['account_name'] }}</td>
                    <td>{{ $bank['sort_code'] }}</td>
                    <td>{{ $bank['account_number'] }}</td>
                    <td>{{ $bank['status'] }}</td>
                    <td>
                      <a href="{{ route('vender.bank.view', $bank['id']) }}"><i class="ft-eye"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Sort Code</th>
                    <th>Account Number</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="footers">
        <a href="{{ route('vender.bank.add') }}">
          <button type="button" class="btn btn-dark round btn-min-width float-md-right m-0">Add</button>
        </a>
        <div class="clearfix"></div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('script')
<script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script>
$(document).ready(function() {
  // Initialize DataTable
  var oTable = $('.zero-configuration').DataTable({
    "bPaginate": $('.zero-configuration tbody tr').length > 10,
    "iDisplayLength": 10,
    "bAutoWidth": false,
    "ordering": false,
  });

  // Custom Search Functionality
  $('#myInputTextField').keyup(function() {
    oTable.search($(this).val()).draw();
  });
});
// Note: The script that hardcoded the height of #contens has been removed so the layout can naturally respond to mobile screens.
</script>
@endsection