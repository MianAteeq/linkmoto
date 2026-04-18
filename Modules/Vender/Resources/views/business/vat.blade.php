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

/* --- ORIGINAL BADGE & BUTTON STYLES RESTORED --- */
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

/* --- FIXED ACCORDION BEHAVIOR (No theme changes) --- */
.custom-accordion-header {
  display: flex;
  align-items: center;
  min-height: 60px;
  border: 2px solid black;
  border-radius: 7px;
  padding: 1.2rem 1rem;
  padding-right: 50px !important;
  color: black !important;
  background-color: white;
  cursor: pointer;
  position: relative;
  text-decoration: none;
}

.custom-accordion-header:hover {
  text-decoration: none;
}

.custom-accordion-header.active {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  padding-bottom: 1.2rem;
}

.custom-accordion-header:before {
  content: "\e843";
  font-family: 'feather';
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%) rotate(270deg);
  transition: transform 0.3s ease;
  font-size: 22px;
}

.custom-accordion-header.active:before {
  transform: translateY(-50%) rotate(90deg);
}

.custom-collapse-content {
  display: none;
  padding: 15px;
  border-radius: 0 0 7px 7px;
  background: white;
  border: 2px solid black;
  border-top: 1px solid #e0e0e0;
  color: black;
}

.custom-collapse-content.show {
  display: block;
}

/* --- RESPONSIVE STRUCTURE STYLES --- */
.sidebar-overview {
  border-radius: 7px;
  border: 2px solid black;
  background-color: white;
}

.info-row {
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #eaeaea;
}

.info-row:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

@media (min-width: 768px) and (max-width: 1199px) {
  .sidebar-overview {
    max-width: 100%;
    margin-bottom: 30px;
  }
}

@media (max-width: 767px) {
  .content-header .row {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }

  .info-label {
    margin-bottom: 0.25rem !important;
  }

  .info-value {
    margin-bottom: 1rem;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white">
  <div class="row" style="border-bottom: 3px solid #949494;">
    <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
      <h3 class="h3">VAT</h3>
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Business</a></li>
          <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.business.detail') }}">Detail</a>
          </li>
          <li class="breadcrumb-item">VAT</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-md-4 mt-3">
  <div class="row align-items-stretch">

    <div class="col-xl-3 col-lg-12 mb-4 d-flex">
      <div class="sidebar-overview w-100 mb-0 d-flex flex-column">
        <h4 class="h3"
          style="font-weight: 600; font-size: 17px;padding: 1.36rem 0.5rem;border-bottom:2px solid; margin: 0;">
          <img src="/home.png" style="width: 22px;margin-top: -5px;"> VAT
        </h4>

        <div class="flex-grow-1 d-flex flex-column" style="padding: 15px 10px; color: black;">

          @php
          $status = $user['profile']['vat_info'];
          // Original Badge Logic Restored
          switch ($status) {
          case 'Todo':
          $badgeClass = 'badge badge-secondary';
          break;
          case 'Pending':
          $badgeClass = 'badge badge-primary text-dark';
          break;
          case 'Verified':
          $badgeClass = 'badge badge-success';
          break;
          case 'Rejected':
          $badgeClass = 'badge badge-danger';
          break;
          default:
          $badgeClass = 'badge badge-light text-dark';
          break;
          }
          @endphp

          <div>
            <span class="{{ $badgeClass }}" style="margin-top:10px">
              {{ $status }}
            </span>
          </div>

          <div style="margin-top: 20px; line-height: 1.5rem;">
            Created on: {{ $user['profile']->created_at->format('d M Y, H:i') }} <br>
            Last updated: {{ $user['profile']->updated_at->format('d M Y, H:i') }}
          </div>

          @if ($status == 'Rejected')
          <p
            style="border-top:2px solid;padding-left: 10px;padding-top: 10px; padding-right: 10px; line-height: 1.5rem; color: black; margin-top: 20px;">
            <strong>Rejected reason</strong>: Incorrect VAT number - could not be verified. Please provide valid VAT
            number.
          </p>
          @endif

        </div>
      </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4 d-flex">
      <div class="accordion-wrapper w-100 d-flex flex-column" style="box-shadow: none;">

        <div class="custom-accordion-item d-flex flex-column flex-grow-1 mb-0">
          <a href="javascript:void(0);" class="custom-accordion-header active" onclick="toggleCollapse(this)"
            data-target="#collaptr_businesss_info">
            <div class="card-title lead mb-0" style="color: black !important;">VAT</div>
          </a>

          <div id="collaptr_businesss_info" class="custom-collapse-content show flex-grow-1 d-flex flex-column">

            <div class="flex-grow-1">
              <div class="row info-row align-items-center">
                <div class="col-sm-5">
                  <h6 class="mb-0" style="color: black;">UK VAT Registered</h6>
                </div>
                <div class="col-sm-7 text-secondary" style="color: black !important;">
                  {{ $user['profile']['vat_register'] }}</div>
              </div>

              @if ($user['profile']['vat_register'] == 'YES')
              <div class="row info-row align-items-center">
                <div class="col-sm-5">
                  <h6 class="mb-0" style="color: black;">UK VAT Number</h6>
                </div>
                <div class="col-sm-7 text-secondary" style="color: black !important;">
                  {{ $user['profile']['uk_vat_no'] }}</div>
              </div>
              @endif

              <div class="row info-row align-items-center" style="border-bottom: none;">
                <div class="col-sm-5">
                  <h6 class="mb-0" style="color: black;">Status</h6>
                </div>
                <div class="col-sm-7 text-secondary" style="color: black !important;">{{ $user['profile']['vat_info'] }}
                </div>
              </div>
            </div>

            @if ($user['profile']['vat_info'] != 'Pending')
            <div class="card-footer mt-auto" style="background: transparent;">
              <div style="text-align: right">
                <a href="{{ route('vender.business.vat.update') }}"
                  style="background-color: black !important; border-color: black !important;" class="btn btn-primary">
                  Edit</a>
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

<script>
if ($('.zero-configuration').length > 0) {
  oTable = $('.zero-configuration').DataTable({
    "bPaginate": $('.zero-configuration tbody tr').length > 10,
    "iDisplayLength": 10,
    "bAutoWidth": false,
    "ordering": false,
  });
  $('#myInputTextField').keyup(function() {
    oTable.search($(this).val()).draw();
  });
}

// Custom Accordion Toggle Logic
function toggleCollapse(element) {
  const targetId = element.getAttribute('data-target');
  const content = document.querySelector(targetId);

  const isVisible = content.classList.contains('show') || content.style.display === 'block';

  if (isVisible) {
    content.classList.remove('show');
    content.style.display = 'none';
    element.classList.remove('active');
  } else {
    content.classList.add('show');
    content.style.display = 'block';
    element.classList.add('active');
  }
}
</script>
@endsection