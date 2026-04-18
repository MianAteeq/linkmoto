@extends('vender::layouts.master')

@section('css_custom')
<link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
<style>
/* --- DATATABLES OVERRIDES --- */
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
}

th {
  white-space: pre-line;
}

table.dataTable tfoot th,
table.dataTable tfoot td {
  padding: 10px 18px 6px 8px;
  border-top: 1px solid #111;
  font-size: 10px;
  color: black;
}

/* --- PROFESSIONAL ACCORDION STYLES --- */
.custom-accordion-item {
  margin-bottom: 15px;
}

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
  font-weight: 500;
  font-size: 1.15rem;
  transition: all 0.2s ease-in-out;
  text-decoration: none;
}

.custom-accordion-header:hover {
  text-decoration: none;
  background-color: #fcfcfc;
}

.custom-accordion-header.active {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  padding-bottom: 1.2rem;
}

.custom-accordion-header:before {
  content: "\e843";
  /* Feather icon */
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
  /* Hidden by default, toggled via JS */
  padding: 25px;
  border-radius: 0 0 7px 7px;
  background: #fcfcfc;
  border: 2px solid black;
  border-top: 1px solid #e0e0e0;
  color: #333;
}

/* Shows the content block if we apply the 'show' class manually */
.custom-collapse-content.show {
  display: block;
}

/* --- PROFESSIONAL SIDEBAR STYLES --- */
.sidebar-overview {
  border-radius: 7px;
  border: 2px solid black;
  background-color: #fcfdfe;
  padding-bottom: 20px;
  box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
}

.sidebar-header {
  border-radius: 5px 5px 0 0;
  padding: 15px 20px;
  font-weight: 600;
  font-size: 1.2rem;
  color: black;
  border-bottom: 1px solid #eaeaea;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 15px;
  background-color: white;
}

.sidebar-content {
  padding: 0 20px;
}

/* --- BADGES & BUTTONS --- */
.custom-badge {
  display: inline-block;
  padding: 0.5em 0.8em;
  font-size: 0.85rem;
  font-weight: 600;
  border-radius: 4px;
}

.badge-todo {
  background-color: #e9ecef;
  color: #495057;
}

.badge-pending {
  background-color: #ffeeba;
  color: #856404;
}

.badge-verified {
  background-color: #d4edda;
  color: #155724;
}

.badge-rejected {
  background-color: #f8d7da;
  color: #721c24;
}

.btn-view-doc {
  background-color: #111;
  color: #fff;
  padding: 6px 16px;
  border-radius: 5px;
  font-size: 0.85rem;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-view-doc:hover {
  background-color: #333;
  color: white;
}

/* --- INFO ROW STYLES --- */
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

.info-label {
  font-weight: 600;
  color: #111;
  margin: 0;
}

.info-value {
  color: #555;
}

/* --- RESPONSIVE ADJUSTMENTS --- */
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

  .custom-accordion-header {
    font-size: 1.05rem;
  }

  .info-label {
    margin-bottom: 0.25rem !important;
  }

  .info-value {
    margin-bottom: 1rem;
  }

  .btn-view-doc {
    float: none !important;
    display: inline-block;
    margin-top: 8px;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white shadow-sm mb-4">
  <div class="container-fluid" style="border-bottom: 3px solid #949494;">
    <div class="row px-md-4 py-3 align-items-center">
      <div class="col-12 bg-white">
        <h3 class="h3 font-weight-bold mb-2">Business Information</h3>
        <div class="breadcrumb-wrapper">
          <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-muted">Business</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vender.business.detail') }}" class="text-dark">Detail</a>
            </li>
            <li class="breadcrumb-item active text-muted">Business information</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-md-4">
  <div class="row align-items-stretch">

    <div class="col-xl-3 col-lg-12 mb-4 d-flex">
      <div class="sidebar-overview w-100 mb-0 d-flex flex-column">
        <div class="sidebar-header">
          <img src="/home.png" style="width: 22px;" alt="Home">
          <span>Business Information</span>
        </div>
        <div class="sidebar-content flex-grow-1">
          @php
          $status = $user['profile']['business_info'];
          $badgeClass = 'badge-todo';

          switch ($status) {
          case 'Todo': $badgeClass = 'badge-todo'; break;
          case 'Pending': $badgeClass = 'badge-pending'; break;
          case 'Verified': $badgeClass = 'badge-verified'; break;
          case 'Rejected': $badgeClass = 'badge-rejected'; break;
          }
          @endphp

          <div class="mb-3">
            <strong class="d-block mb-2"
              style="font-size: 1.05rem;">{{ $user['profile']['organization_status'] }}</strong>
            <span class="custom-badge {{ $badgeClass }}">{{ $status }}</span>
          </div>

          <hr style="border-color: #eaeaea;">

          <p class="mb-1" style="font-size: 0.9rem; color: #666;">
            <strong>Created:</strong><br>
            {{ $user['profile']->created_at->format('d M Y, H:i') }}
          </p>
          <p class="mb-0" style="font-size: 0.9rem; color: #666;">
            <strong>Last updated:</strong><br>
            {{ $user['profile']->updated_at->format('d M Y, H:i') }}
          </p>
        </div>
      </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4 d-flex">
      <div class="accordion-wrapper w-100 d-flex flex-column">

        <div class="custom-accordion-item d-flex flex-column flex-grow-1 mb-0">
          <a href="javascript:void(0);" class="custom-accordion-header active" onclick="toggleCollapse(this)"
            data-target="#collaptr_businesss_info">
            Business Information
          </a>

          <div id="collaptr_businesss_info" class="custom-collapse-content show flex-grow-1 d-flex flex-column">

            <div class="flex-grow-1">
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">ID</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">BSN{{ sprintf('%07d', $user['id']) }}</div>
                </div>
              </div>

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Business setup</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">{{ $user['profile']['organization_status'] }}</div>
                </div>
              </div>

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">
                    Registered @if(in_array($user['profile']['organization_status'], ['Limited Liability Partnership
                    (LLP)', 'Limited Company (Ltd)'])) company @endif name
                  </h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">{{ $user['profile']['company_name'] }}</div>
                </div>
              </div>

              @if(in_array($user['profile']['organization_status'], ['Limited Liability Partnership (LLP)', 'Limited
              Company (Ltd)']))
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Registered company number</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">{{ $user['profile']['registration_no'] }}</div>
                </div>
              </div>
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Registered company jurisdiction</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">{{ $user['profile']['company_jurisdiction'] }}</div>
                </div>
              </div>
              @endif

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">
                    Registered @if(in_array($user['profile']['organization_status'], ['Limited Liability Partnership
                    (LLP)', 'Limited Company (Ltd)'])) company @endif address
                  </h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">
                    {{ $user['profile']['address_line_1'] }}
                    @if($user['profile']['address_line_2']) , {{ $user['profile']['address_line_2'] }} @endif
                    , {{ $user['profile']['city'] }} , {{ $user['profile']['postcode'] }}
                  </div>
                </div>
              </div>

              @if ($user['profile']['organization_status'] == 'Sole Trader / Self Employed')
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Companies House Proof</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value d-flex justify-content-between align-items-center flex-wrap">
                    <span>{{ $user['profile']['document_proof_name'] }}</span>
                    <a class="btn-view-doc" target="_blank"
                      href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                  </div>
                </div>
              </div>
              @endif

              @if(in_array($user['profile']['organization_status'], ['General Partnership', 'Sole Trader /
              Self-Employed']))
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Proof of business registration</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">
                    @if ($user['profile']['document_proof_name'] != null)
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <span>{{ $user['profile']['document_proof_name'] }}</span>
                      <a class="btn-view-doc" target="_blank"
                        href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                    </div>
                    @else
                    <span style="color: #d9534f; font-weight: 500;">Proof documentation upload required</span>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Proof of trading activity</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">
                    @if ($user['profile']['trading_activity'] != null)
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <span>{{ $user['profile']['document_proof_name'] }}</span>
                      <a class="btn-view-doc" target="_blank"
                        href="{{ URL::to($user['profile']['trading_activity']) }}">View</a>
                    </div>
                    @else
                    <span style="color: #d9534f; font-weight: 500;">Proof documentation upload required</span>
                    @endif
                  </div>
                </div>
              </div>
              @endif

              @if(in_array($user['profile']['organization_status'], ['Limited Liability Partnership (LLP)', 'Limited
              Company (Ltd)']))
              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Proof of business registration</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">Registered company number supplied. Proof not required.</div>
                </div>
              </div>

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Proof of trading activity</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">
                    @if ($user['profile']['trading_activity'] != null)
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <span>Proof.{{ Str::after($user['profile']['trading_activity'], '.') }}</span>
                      <a class="btn-view-doc" target="_blank"
                        href="{{ URL::to($user['profile']['trading_activity']) }}">View</a>
                    </div>
                    @else
                    <span style="color: #d9534f; font-weight: 500;">Proof documentation upload required</span>
                    @endif
                  </div>
                </div>
              </div>
              @endif

              <div class="row info-row align-items-center">
                <div class="col-sm-4">
                  <h6 class="info-label">Verification Status</h6>
                </div>
                <div class="col-sm-8">
                  <div class="info-value">{{ $user['profile']['business_info'] }}</div>
                </div>
              </div>
            </div>

            @if ($user['profile']['business_info'] == 'Todo' || $user['profile']['business_info'] == 'Rejected')
            <div class="mt-4 pt-3 text-right mt-auto" style="border-top: 2px solid #111;">
              <a href="{{ route('vender.business.information.edit') }}" class="btn btn-dark px-4 py-2"
                style="border-radius: 5px; background-color: #111;">Edit</a>
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
// DataTables init logic
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
    // Close it
    content.classList.remove('show');
    content.style.display = 'none';
    element.classList.remove('active');
  } else {
    // Open it
    content.classList.add('show');
    content.style.display = 'block';
    element.classList.add('active');
  }
}
</script>
@endsection