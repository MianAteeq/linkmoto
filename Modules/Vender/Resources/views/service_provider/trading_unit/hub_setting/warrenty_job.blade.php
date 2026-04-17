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

.form-control {
  border: 2px solid black !important;
  height: calc(1em + 1.4rem + 0px);
  border-radius: 7px;
  width: 60%;
}

.form-btn {
  text-align: left;
  color: #babfcc;
  width: 37%;
  padding: 7px;
  padding-left: 14px;
  float: left;
}

.view-btn {
  float: left;
  margin-top: 0px;
  padding: 9px;
  margin-left: 10px;
  background-color: #ff822f !important;
  border-color: #ff822f !important;
}

body {
  color: black;
}

.view-btn-black {
  margin-top: 0px;
  padding: 9px;
  margin-left: 10px;
  background-color: black !important;
  border-color: black !important;
}

.form-control:focus {
  color: #4e5154;
  background-color: #fff;
  border-color: black;
  outline: 0;
  box-shadow: none;
}

body.vertical-layout.vertical-menu.menu-expanded .main-menu {
  width: 274px;
  transition: 300ms ease all;
  backface-visibility: hidden;
}

body.vertical-layout.vertical-menu.menu-expanded .content,
body.vertical-layout.vertical-menu.menu-expanded .footer {
  margin-left: 274px;
}

input:focus:required:invalid {
  border: 2px solid red;
}

input:required:valid {
  border: 2px solid black;
}

.footers {
  position: absolute;
  bottom: 14px !important;
  left: unset !important;
  border-top: 2px solid black;
  padding-top: 10px !important;
  width: 96.5% !important;
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

/* --- NEW RESPONSIVE ENHANCEMENTS --- */

/* 1. Stop JS from freezing height & fix absolute positioning of footer inside form */
form#contens {
  height: auto !important;
  min-height: 200px;
  padding-bottom: 70px;
  /* Space for absolute footer */
  position: relative;
}

.form-group.row {
  margin-left: 0;
  margin-right: 0;
}

/* 2. Tablet check layout */
@media (max-width: 991px) and (min-width: 768px) {
  .form-group.row .col-md-3 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}

/* 3. Mobile layout */
@media (max-width: 767px) {

  /* Sidebar spacing */
  .col-md-3 {
    margin-bottom: 25px;
  }

  /* Checkbox grid alignment */
  .form-group.row .col-md-3 {
    flex: 0 0 100%;
    max-width: 100%;
    margin-bottom: 10px;
  }

  /* Remove absolute positioning on mobile to prevent overlapping */
  form#contens {
    padding-bottom: 20px;
  }

  .footers {
    position: relative !important;
    width: 100% !important;
    bottom: 0 !important;
    display: flex;
    flex-direction: column-reverse;
    /* Save above Cancel */
    padding: 15px !important;
  }

  .footers .btn {
    width: 100% !important;
    float: none !important;
    margin-bottom: 10px !important;
  }

  .footers a {
    width: 100%;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white">
  <div class="row" style="border-bottom: 3px solid #949494;">
    <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
      <h3 class="h3">Trade unit information</h3>
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Products</a>
          </li>
          <li class="breadcrumb-item"><a style="color: black" href="{{route('vender.service.provider')}}">Service
              Provider</a>
          </li>
          <li class="breadcrumb-item"><a style="color: black"
              href="{{route('vender.service.provider.trading.unit')}}">Trade Units</a>
          </li>
          <li class="breadcrumb-item"><a style="color: black"
              href="{{route('vender.service.provider.trading.unit.view',$trading_unit['id'])}}">
              {{$trading_unit['name']}}</a>
          </li>
          <li class="breadcrumb-item"> <a
              href="{{route('vender.service.provider.trading.unit.hub.setting',$trading_unit['id'])}}"
              style="color: black">Hub profile settings</a>
          </li>
          <li class="breadcrumb-item"> Edit Warranty Job
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
    <div style="border-radius: 7px;border: 2px solid black;  ">
      <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
        <div>
          <div style="float: left; width: 10%;">
            <img src="/trading_unit.png" style="width: 22px;margin-top: -5px;">
          </div>
          <div style="float: left; width: 90%;">
            <span>Trading Unit : {{$trading_unit['name']}}</span>
          </div>



        </div>
        <div style="margin: 20px;margin-top: 53px;font-weight: 500;font-size: 13px;">
          <span>Trading Name : {{$trading_unit['trading_name']['name']??''}}</span>
        </div>
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
          <span class="success">{{$trading_unit['status']}}</span>
        </div>
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
          <span class="success">{{$trading_unit['active_status']}}</span>
        </div>
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;margin-bottom:0px">
          <span>Created: {{\Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
            {{\Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}</span>
        </div>

      </h4>
      <div class="footers" style="text-align: center;">

        @if($trading_unit['status']=="PENDING" || $trading_unit['status']=="INACTIVE")
        <a href="{{route('vender.service.provider.trading.unit.active',$trading_unit['id'])}}"> <button type="button"
            style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">ACTIVATE TRADE UNIT</button></a>
        @else
        <a href="{{route('vender.service.provider.trading.unit.in.active',$trading_unit['id'])}}"> <button type="button"
            style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">INACTIVATE TRADE UNIT</button></a>

        @endif
        @if($trading_unit['active_status']=="OFFLINE")
        <a href="{{route('vender.service.provider.trading.unit.Online',$trading_unit['id'])}}"> <button type="button"
            style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">SHOW ONLINE</button></a>

        @else
        <a href="{{route('vender.service.provider.trading.unit.offline',$trading_unit['id'])}}"> <button type="button"
            style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">SHOW OFFLINE</button></a>

        @endif



      </div>

    </div>
  </div>
  <div class="col-md-9" id="contens"
    style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">
    <div class="row ">
      <a href="{{route('vender.service.provider.trading.unit.view',$trading_unit['id'])}}">
        <h4 class="h3"
          style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;">
          Overview</h2>
      </a>
      <a href="{{route('vender.service.provider.trading.unit.app.setting',$trading_unit['id'])}}">
        <h4 class="h3"
          style="border-radius: 7px; border: 2px solid  #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color:  #ff6600;margin-left: 15px;">
          App settings</h2>
      </a>
      <a href="{{route('vender.service.provider.trading.unit.app.data',$trading_unit['id'])}}">
        <h4 class="h3"
          style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;">
          App data </h2>
      </a>
      {{-- <a href="{{route('vender.service.provider.trading.unit.hub.setting',$trading_unit['id'])}}"> <h4 class="h3"
        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 15px;">
        Hub profile settings </h2> </a> --}}


    </div>

    <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;margin-top: -6px;">

      <a id="headingCollapse1" href="{{redirect()->back()->getTargetUrl()}}" class="card-header info mt-2"
        style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
        data-toggle="" aria-expanded="false">
        <div class="card-title lead collapsed">Edit Warranty Job</div>
      </a>
      <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info" style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;" class="collapse show" aria-expanded="false">
        <div class="card-content">
          <form action="{{route('vender.service.provider.trading.unit.hub.setting.warranty.job.submit')}}" id="contens"
            method="POST" enctype="multipart/form-data"> @csrf
            <div class="link-body" style="padding: 10px">

              <input type="hidden" name="id" value="{{$trading_unit['id']}}">

              <div class="form-group row">
                @foreach ($job_types as $job_type)
                <div class="col-md-3">
                  <fieldset class="checkboxsas">
                    <label>
                      <input type="checkbox" name="warrenty_id[]" value="{{$job_type['id']}}">
                      {{$job_type['name']}}
                    </label>
                  </fieldset>
                </div>

                @endforeach

              </div>
            </div>
            <div class="footers">

              <button type="button" onclick="submitDetailsForm()" class="btn btn-dark round btn-min-width mr-1 mb-1"
                style="float: right;">Save</button>
              <a href="{{redirect()->back()->getTargetUrl()}}"><button type="button"
                  class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Cancel</button></a>

            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script')
<script>
function submitDetailsForm() {
  let array = ['address_line_1', 'address_line_2', 'city', 'postcode', 'email', 'mobile'];

  let status = false;
  array.some((item) => {
    let name = $(`#${item}`).val();
    console.log(name, item);

    if (name === "") {


      $(`#${item}`).attr('style', 'border:2px solid red!important;');




      return false;

    } else {

      $(`#${item}`).attr('style', 'border:2px solid black!important;');


    }
  });
  array.some((item) => {
    let name = $(`#${item}`).val();
    console.log(name, item);

    if (name === "") {


      $(`#${item}`).attr('style', 'border:2px solid red!important;');

      status = false;


      return true;

    } else {

      $(`#${item}`).attr('style', 'border:2px solid black!important;');
      status = true;

    }
  });



  // return;


  if (status == true) {
    $("form").submit();
  }






}
</script>

<script>
async function lookup(arg) {
  var id = arg.getAttribute('id');
  var value = arg.value;


  let trading_name = $(`#${id}`).val();
  if (id !== "address_line_2" && id !== "city" && id !== "postcode") {
    if (trading_name === "") {


      $(`#${id}`).attr("style", "border:2px solid red!important;");
      status = false;

    } else {
      $(`#${id}`).attr("style", "border:2px solid black!important;");
      $(`.${id}`).hide();
    }
  } else {
    if (trading_name === "") {


      $(`#${id}`).attr("style", "border:2px solid red!important;margin-top: 5px ");
      status = false;

    } else {
      $(`#${id}`).attr("style", "border:2px solid black!important;margin-top: 5px;");
      $(`.${id}`).hide();
    }
  }














}
</script>
@endsection