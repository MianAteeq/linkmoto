@extends('vender::layouts.master')

@section('css_custom')
<link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
<style>
/* --- DataTable Customizations --- */
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
  font-size: 10px;
  color: black;
}

table.dataTable thead th,
table.dataTable thead td {
  padding: 10px 18px 10px 8px;
  border-bottom: 1px solid #111;
  font-size: 11px;
  white-space: pre-line;
}

table.dataTable tfoot th,
table.dataTable tfoot td {
  padding: 10px 18px 6px 8px;
  border-top: 1px solid #111;
  font-size: 10px;
  color: black;
}

/* Prevent text wrapping in responsive tables */
.table-responsive table th,
.table-responsive table td {
  white-space: nowrap !important;
}

/* --- Global Customizations --- */
.headerbg-custom {
  padding: 15px 15px 0 15px;
}

/* --- Sidebar & Headings --- */
.sidebar-title {
  border-radius: 7px;
  border: 2px solid black;
  padding: 10px;
  font-weight: 600;
  font-size: 17px;
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 15px;
  margin-top: 0;
}

.sidebar-title img {
  width: 22px;
}

/* --- Top Horizontal Navigation --- */
.top-nav-group {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 20px;
}

.nav-btn {
  border-radius: 7px;
  border: 2px solid black;
  padding: 10px 15px;
  font-weight: 600;
  font-size: 17px;
  color: black;
  text-decoration: none;
  text-align: center;
  flex: 1 1 auto;
  min-width: 160px;
  transition: background-color 0.2s ease-in-out;
}

.nav-btn:hover {
  background-color: #f8f9fa;
  color: black;
}

.nav-btn.active {
  border-color: #ff6600;
  color: #ff6600;
}

.nav-btn.active:hover {
  background-color: #fff0e6;
}

/* --- Search Bar Container --- */
.search-container {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 15px;
}

.search-input {
  border: 2px solid black !important;
  border-radius: 6px !important;
  flex-grow: 1;
}

/* --- Mobile Specific Enhancements --- */
@media (max-width: 767px) {
  .headerbg-custom {
    padding-left: 15px;
  }

  .top-nav-group {
    flex-direction: column;
    gap: 10px;
  }

  .nav-btn {
    width: 100%;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white">
  <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
    <div class="col-12 bg-white headerbg-custom">
      <h3 class="h3">Invoices</h3>
      <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Billing</a></li>
          <li class="breadcrumb-item">Invoices</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="row mt-3">

  <div class="col-md-3">
    <h4 class="sidebar-title">
      <img src="/wallet.png" alt="Wallet Icon"> Billing
    </h4>
  </div>

  <div class="col-md-9" id="contens">

    <div class="top-nav-group">
      <a href="{{route('vender.subscription.index')}}" class="nav-btn">
        Subscriptions
      </a>
      <a href="{{route('vender.invoice.index')}}" class="nav-btn active">
        Invoices
      </a>
    </div>

    <div style="border: 2px solid black; border-radius: 6px; margin-bottom: 30px;">

      <div style="border-bottom: 2px solid black; padding: 10px 15px;">
        <h3 style="font-size: 20px; color: black; margin: 0;">Invoices</h3>
      </div>

      <div class="search-container">
        <input type="text" class="form-control search-input" id="myInputTextField" placeholder="Search">
        <a href="#">
          <i class="ft-filter" style="font-size: 30px; color: black;"></i>
        </a>
      </div>

      <div class="px-3 pb-3">
        <div class="table-responsive">
          <table class="table table-striped table-bordered zero-configuration w-100">
            <thead>
              <tr>
                <th>Invoice ID</th>
                <th>Subscription ID</th>
                <th>Product</th>
                <th>Plan</th>
                <th>Invoice Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($subscriptions as $account)
              <tr>
                <td>{{$account->number}}</td>
                <td>S-{{sprintf("%04d",$account['subscription']['id'])}}</td>
                <td>Service Provider App</td>
                <td>{{$account['inv_plan']['name']??''}}</td>
                <td>{{\Carbon\Carbon::parse($account['created_at'])->format('d/m/Y')}}</td>
                <td>{{number_format($account['amount_due']/100,2)}} </td>
                <td>{{Str::ucfirst($account['status'])}}</td>
                <td><a href="{{route('vender.invoice.detail',$account['id'])}}"><i class="ft-eye"></i></a></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Invoice ID</th>
                <th>Subscription ID</th>
                <th>Product</th>
                <th>Plan</th>
                <th>Invoice Date</th>
                <th>Amount Paid</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
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

  // Custom Search Input Binding
  $('#myInputTextField').keyup(function() {
    oTable.search($(this).val()).draw();
  });
});
</script>
@endsection