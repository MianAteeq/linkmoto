@extends('frontend::new-layouts.master')

@section('css')
<style>
hr {
  margin-top: 0rem;
  margin-bottom: 0rem;
  border: 0;
  border-top: 2px solid rgba(0, 0, 0, 0.1);
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
          <img src="/home.png" style="width: 22px;margin-top: -5px;"> Bank details
        </h4>
        <p style="padding-left: 10px; padding-right: 10px;">Please provide bank details for
          the purpose of receiving
          payments from Motonos (i.e.
          when receiving refund
          payments)
          <br>
          Account name must be same as
          registered business name or
          trading name.
        </p>

        <div class="footers">
          <h4 style="padding-left: 13px; color: black; font-weight: 600;">
            Help information:
          </h4>
          <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
            <div class="card accordion collapse-icon accordion-icon-rotate"
              style="box-shadow: none;margin-right: 10px;margin-left: 10px;">
              <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                href="#collapsebusiness_vat" aria-expanded="false" aria-controls="collapsebusiness_vat">
                <div class="card-title lead" style="width: 100%;">Proof of bank details (?)
                </div>
              </a>
              <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                aria-labelledby="business_VAT" class="collapse" style="">
                <div class="card-content">
                  <div class="card-body">
                    <p>Acceptable proof (any 1 of the following):</p>
                    <ul>
                      <li>Bank statement, dated within
                        last 3 months. Account name
                        must be same as registered
                        business name or trading name</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-8" style="border: 2px solid black;border-radius: 8px; padding: 15px;" id="contens">
      <form action="{{ route('vender.profile.bank.account') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="is_save_later" name="is_save_later" value="0">
        <div class="link-body" style="padding: 10px">

          <div class="form-group row">
            <label class="col-12 col-md-4 label-control" for="account_name">Account name <span
                style="color: red">*</span> </label>
            <div class="col-12 col-md-8 mx-auto">
              <input type="tel" id="account_name" class="form-control" value="{{ $user['profile']['account_name'] }}"
                onkeyup="lookup(this);" name="account_name" placeholder="Account name">
              <p class="text-danger account_name"
                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                Required !</p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-12 col-md-4 label-control" for="sort_code">Sort code <span style="color: red">*</span>
            </label>
            <div class="col-12 col-md-8 mx-auto">
              <input type="tel" id="sort_code" class="form-control" value="{{ $user['profile']['sort_code'] }}"
                onkeyup="lookup(this);" name="sort_code" placeholder="Sort code ">
              <p class="text-danger sort_code" style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                This Field is
                Required !</p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-12 col-md-4 label-control" for="account_number">Account number <span
                style="color: red">*</span> </label>
            <div class="col-12 col-md-8 mx-auto">
              <input type="tel" id="account_number" class="form-control"
                value="{{ $user['profile']['account_number'] }}" onkeyup="lookup(this);" name="account_number"
                placeholder="Account number">
              <p class="text-danger account_number"
                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                Required !</p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-12 col-md-4 label-control" for="bank_proof">Proof of bank details <span
                style="color: red">*</span> <a style="color: black" href="#collapsebusiness_vat" data-toggle="collapse"
                aria-expanded="false" aria-controls="collapsec_c_address">(?)</a></label>
            <div class="col-12 col-md-8 mx-auto">
              <input type="file" name="bank_proof" accept="image/*,.doc, .docx,.pdf" class="d-none" id="">
              <input type="button" id="form-btn" class="form-control form-btn"
                value="{{ $user['profile']['bank_proof_name'] ?? 'Document Upload' }}" name="contact"
                placeholder="Document Upload ">
              <button type="button" class="btn btn-primary btn-sm mt-2 view-btn" @if
                ($user['profile']['bank_proof']==null) style="display: none" @endif> <a
                  href="{{ URL::to($user['profile']['proof_of_main_contact'] ?? '') }}" id="view_file" target="_blank"
                  style="color: white">View</a></button>
              <br>
              <br>
              <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none">
                Proof of bank details is Required !</p>
            </div>
          </div>

        </div>

        <div class="footers d-flex flex-wrap justify-content-end w-100" style="gap: 10px; padding: 10px;">
          @if ($user['profile']['edit_step'] == 0)
          <a href="{{ route('vender.profile.back', 4) }}"> <button type="button"
              class="btn btn-dark round btn-min-width mb-1">PREVIOUS</button></a>
          <button type="button" onclick="saveforlater()" class="btn btn-dark round btn-min-width mb-1">SAVE AND
            EXIT</button>
          <button type="button" onclick="submitDetailsForm()"
            class="btn btn-dark round btn-min-width mb-1">NEXT</button>
          @else
          <button type="button" onclick="submitDetailsForm()"
            class="btn btn-dark round btn-min-width mb-1">UPDATE</button>
          @endif
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

@section('js')
<script>
// JS Height calculation removed. CSS handles container expansions dynamically now!

$('#form-btn').click(function() {
  $('input[type=file]').trigger('click');
});

$(document).ready(function() {
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.form-btn').val(fileName);

    $('.view-btn').show();
    $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
    $('.file_proof').hide();
  });
});

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

function submitDetailsForm() {
  let array = ['account_name', 'sort_code', 'account_number'];
  let status = false;

  array.some((item) => {
    let name = $(`#${item}`).val();

    if (name === "") {
      $(`.${item}`).show();
      $(`#${item}`).attr('style', 'border:2px solid red!important');
      return false;
    } else {
      $(`.${item}`).hide();
      $(`#${item}`).attr('style', 'border:2px solid black!important');
    }
  });

  array.some((item) => {
    let name = $(`#${item}`).val();
    console.log(name, "sbb")

    if (name === "") {
      status = false;
      return true;
    } else {
      $(`.${item}`).hide();
      $(`#${item}`).attr('style', 'border:2px solid black!important');
      status = true;
    }
  });

  console.log(1)

  if (status === false) {
    return false;
  }

  let file = $('input[type=file]').val();
  if (file === "" && @json($user['profile']['bank_proof']) == null) {
    $('.file_proof').show();
    status = false;
    return false;
  } else {
    status = true;
  }

  if (status === true) {
    $("form").submit();
  }
}

function saveforlater() {
  $('#is_save_later').val(1);
  $("form").submit();
}
</script>
@endsection
