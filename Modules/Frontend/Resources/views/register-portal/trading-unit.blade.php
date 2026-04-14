@extends('frontend::new-layouts.master')

@section('css')
<style>
hr {
  margin-top: 0rem;
  margin-bottom: 0rem;
  border: 0;
  border-top: 2px solid rgba(0, 0, 0, 0.1);
}

/* Flexbox helper to push footer to bottom naturally */
.flex-column-container {
  display: flex;
  flex-direction: column;
  min-height: 100%;
}
</style>
@endsection

@section('content')
<div class="content-body">
  <div class="row" style="border-bottom: 3px solid #949494; margin-bottom: 15px;">
    <div class="col-xl-12 col-12">
      <h3 class="h3">Business registration application</h3>
    </div>
  </div>

  <div class="row" style="margin-top: 10px;">

    <div class="col-12 col-md-4 mb-4 mb-md-0">
      <div style="border-radius: 7px;border: 2px solid black;">
        <h4 class="h3" style="padding: 10px;font-weight: 600;font-size: 17px; ">
          <img src="/home.png" style="width: 22px;margin-top: -5px;"> Trading Unit
        </h4>
        <p style="padding-left: 10px; padding-right: 10px;">A trade unit is your retail outlet;
          the unit/branch/location where
          your products and services are
          provided and sold directly to
          your customers.
          <br><br>
          If you have more than one trade
          unit (i.e. multiple branches) then
          please provide answers related
          to any one of your trade unit for
          the purpose of this registration.
          Upon successful registration,
          you will be able to provide
          details for all your trade units.
        </p>

        <div class="footers">
          <h4 style="padding-left: 13px; color: black; font-weight: 600;">Help information: </h4>
          <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
            <div class="card accordion collapse-icon accordion-icon-rotate"
              style="box-shadow: none;margin-right: 10px;margin-left: 10px;">
              <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                href="#collapsebusiness_vat" aria-expanded="false" aria-controls="collapsebusiness_vat">
                <div class="card-title lead">How do you provide and offer your services? </div>
              </a>
              <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                aria-labelledby="business_VAT" class="collapse" style="">
                <div class="card-content">
                  <div class="card-body"></div>
                </div>
              </div>

              <a id="business_VAT_2" @if($user['profile']['operation_type']=="Mobile" ) style="display: none;" @endif
                class="card-header info collapsed site-address" data-toggle="collapse" href="#collapsebusiness_vat_2"
                aria-expanded="false" aria-controls="collapsebusiness_vat_2">
                <div class="card-title lead">Proof of trading at site address</div>
              </a>
              <div id="collapsebusiness_vat_2" data-parent="#accordionWrap1" role="tabpanel"
                aria-labelledby="business_VAT_2" class="collapse" style="">
                <div class="card-content">
                  <div class="card-body">
                    <p>Acceptable proof (any 1 of the following):</p>
                    <ul>
                      <li>Expense Invoice (i.e. parts purchases, tools purchase, etc) in your trading address, dated
                        within the last 1 month</li>
                      <li>Utility Bill in your trading address, dated within the last 3 months</li>
                      <li>Business rates bill or letter of your trading address</li>
                      <li>Lease or Rent agreement of your trading address</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-8 body-height" style="border: 2px solid black;border-radius: 8px;padding: inherit;">
      <form action="{{route('vender.profile.trading.unit')}}" method="POST" enctype="multipart/form-data" id="contens"
        class="flex-column-container">
        @csrf
        <input type="hidden" id="is_save_later" name="is_save_later" value="0">

        <div class="link-body" style="padding: 10px; flex-grow: 1;">

          <div class="form-group row">
            <label class="col-12 col-md-4 label-control">How do you provide and offer your services <span
                style="color: red">*</span> <a style="color: black" href="#collapsebusiness_vat" data-toggle="collapse"
                aria-expanded="false" aria-controls="collapsebusiness">(?)</a></label>
            <div class="col-12 col-md-8 mx-auto">
              <div class="input-group d-flex flex-wrap" style="gap: 15px;">
                <div class="custom-control custom-radio">
                  <input type="radio" name="operation_type" value="On-site" class="custom-control-input"
                    @if($user['profile']['operation_type']=="On-site" ) checked @endif id="On-site">
                  <label class="custom-control-label" for="On-site">On-site</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" name="operation_type" class="custom-control-input" value="Mobile"
                    @if($user['profile']['operation_type']=="Mobile" ) checked @endif id="Mobile">
                  <label class="custom-control-label" for="Mobile">Mobile</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" name="operation_type" class="custom-control-input" value="Both"
                    @if($user['profile']['operation_type']=="Both" ) checked @endif id="Both (On-site and Mobile)">
                  <label class="custom-control-label" for="Both (On-site and Mobile)">Both (On-site and Mobile)</label>
                </div>
              </div>
            </div>
          </div>

          <div class="site-address" @if($user['profile']['operation_type']=="Mobile" ) style="display: none" @endif>
            <div class="form-group row">
              <label class="col-12 col-md-4 label-control" for="address_line_1">Site address <span
                  style="color: red">*</span> (?)</label>
              <div class="col-12 col-md-8 mx-auto">
                <input type="tel" id="address_line_1" onkeyup="lookup(this);" class="form-control" name="address_line_1"
                  required value="{{ $user['site_address']['address_line_1']??'' }}" placeholder="Address line one *">
                <input type="tel" id="address_line_2" class="form-control mt-2" name="address_line_2" required
                  value="{{ $user['site_address']['address_line_2']??'' }}" placeholder="Address line two ">
                <input type="tel" id="address_line_3" class="form-control mt-2" name="address_line_3"
                  value="{{ $user['site_address']['address_line_3']??'' }}" placeholder="Address line three ">
                <input type="tel" id="address_line_4" class="form-control mt-2" name="address_line_4"
                  value="{{ $user['site_address']['address_line_4']??'' }}" placeholder="Address line four ">
                <input type="tel" id="city" class="form-control mt-2" onkeyup="lookup(this);" name="city" required
                  value="{{ $user['site_address']['city']??'' }}" placeholder="City / Town *">
                <input type="tel" id="postcode" class="form-control mt-2" onkeyup="lookup(this);" name="postcode"
                  required value="{{ $user['site_address']['postcode']??'' }}" placeholder="Postcode *">
                <p class="text-danger address" style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                  Address Field is Required !</p>
              </div>
            </div>

            <div class="form-group row">
              <input type="file" name="proof" class="d-none" accept="image/*,.doc, .docx,.pdf" id="">
              <label class="col-12 col-md-4 label-control" for="eventRegInput5">Proof of trading at site address <span
                  style="color: red">*</span> <a style="color: black" href="#collapsebusiness_vat_2"
                  data-toggle="collapse" aria-expanded="false" aria-controls="collapsebusiness">(?)</a></label>
              <div class="col-12 col-md-8 mx-auto">
                <input type="button" id="eventRegInput5" class="form-control form-btn mt-1 mt-md-0"
                  value="{{$user['site_address']['proof']??'Document Upload'}}" name="contact"
                  placeholder="Document Upload ">
                <button type="button" class="btn btn-primary btn-sm mt-2 view-btn" @if(($user['site_address'])==null)
                  style="display: none" @endif>
                  <a href="{{URL::to($user['site_address']['proof']??'')}}" id="view_file" target="_blank"
                    style="color: white">View</a>
                </button>
                <br><br>
                <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none">Proof of trading
                  is Required !</p>
              </div>
            </div>
          </div>

        </div>

        <div class="footers d-flex flex-wrap justify-content-end w-100 mt-auto" id="footers"
          style="gap: 10px; padding: 10px;">
          @if($user['profile']['edit_step']==0)
          <a href="{{route('vender.profile.back',$user['profile']['step'])}}">
            <button type="button" class="btn btn-dark round btn-min-width mb-1">PREVIOUS</button>
          </a>
          <button onclick="saveforlater()" type="button" class="btn btn-dark round btn-min-width mb-1">SAVE AND
            EXIT</button>
          <button type="button" class="btn btn-dark round btn-min-width mb-1"
            onclick="submitDetailsForm()">NEXT</button>
          @else
          <button type="button" class="btn btn-dark round btn-min-width mb-1"
            onclick="submitDetailsForm()">Update</button>
          @endif
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
// Removed dynamic JS height calculations. CSS handles scaling naturally.

$('input[type=radio]').change(function() {
  if (this.value === 'Mobile') {
    $('.site-address').hide();
  } else {
    $('.site-address').show();
  }
});
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

  if (id.indexOf("address") >= 0 || id.indexOf("city") >= 0 || id.indexOf("postcode") >= 0) {
    let address_line_1 = $('#address_line_1').val();
    let address_line_2 = $('#address_line_2').val();
    let city = $('#city').val();
    let postcode = $('#postcode').val();
    if (address_line_1 !== "" && address_line_2 !== "" && city !== "" && postcode !== "") {
      $(`.address`).hide();
    }
  }
}
</script>

<script>
$('.form-btn').click(function() {
  $('input[type=file]').trigger('click');
});
</script>

<script>
$(document).ready(function() {
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.form-btn').val(fileName);
    $('.view-btn').show();
    $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
    $('.file_proof').hide();
  });
});
</script>

<script>
function submitDetailsForm() {
  let organization_status = $('input[type=radio]:checked').val();
  let status = false;

  let address_line_1 = $('#address_line_1').val();
  let city = $('#city').val();
  let postcode = $('#postcode').val();

  if (organization_status !== "Mobile") {
    if (address_line_1 === "") {
      $('.address').show();
      $('#address_line_1').attr('style', 'border:2px solid red!important;margin-top: 5px ');
      return false;
    } else {
      $('#address_line_1').attr('style', 'border:2px solid black!important;margin-top: 5px ');
      status = true;
    }

    if (city === "") {
      $('.address').show();
      $('#city').attr('style', 'border:2px solid black!important;margin-top: 5px ');
      status = false;
      return false;
    } else {
      $('#city').attr('style', 'border:2px solid black!important;margin-top: 5px ');
      status = true;
    }

    if (postcode === "") {
      $('.address').show();
      $('#postcode').attr('style', 'border:2px solid black!important;margin-top: 5px ');
      status = false;
      return false;
    } else {
      $('#postcode').attr('style', 'border:2px solid black!important;margin-top: 5px ');
      status = true;
    }

    if (postcode !== "" && city !== "" && address_line_1 !== "") {
      $('.address').hide();
    }

    let file = $('input[type=file]').val();
    if (file === "" && @json($user['site_address']) == null) {
      $('.file_proof').show();
      status = false;
      return false;
    } else {
      status = true;
    }
  }

  $("form").submit();
}
</script>

<script>
function saveforlater() {
  $('#is_save_later').val(1);
  $("form").submit();
}
</script>
@endsection