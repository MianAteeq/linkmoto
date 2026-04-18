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
  /* Ensures it stretches nicely if flex is applied later */
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
      <h3 class="h3">Trading names</h3>
      <div class="breadcrumb-wrapper col-12 p-0">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Business</a></li>
          <li class="breadcrumb-item">Trading names</li>
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
        <img src="/home.png" style="width: 22px; margin-top: -5px;"> Trading Names
      </h4>
      <p style="border-top: 2px solid black; padding: 10px; line-height: 1.5rem; color: black; margin: 0;">
        Add and manage the different names your business operates under. These names can be linked to invoices, trade
        units, and marketplace listings. Your registered business name is included automatically, but you can add other
        trading names as needed.
      </p>
    </div>
  </div>

  <div class="col-12 col-md-8 col-lg-9">
    <div class="main-content-box" id="contens">

      <div class="main-content-inner">
        <div class="row m-0" style="border-bottom: 2px solid black;">
          <div class="col-12 p-0">
            <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">
              Trading names
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
                    <th>Trading Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($trading_names as $trading_name)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                      {{ $trading_name['name'] }}
                      @if ($trading_name['is_change'] == 1)
                      <span style="background-color: #ff6600;" class="badge badge-primary">Registered</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('vender.trading.name.view', $trading_name['id']) }}"><i class="ft-eye"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Trading Name</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="footers">
        <a href="{{ route('vender.trading.name.add') }}">
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
</script>
@endsection