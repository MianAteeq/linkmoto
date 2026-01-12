@extends('vender::layouts.master')

@section('css_custom')

<style>
    .footers{
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
 .tags {
     display: flex
;
    align-items: center;
    gap: 10px;
    float: right;
    margin-right: 32px;
    }
     .tag {
     background-color: #ff8c42;
    color: white;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 14px;
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

                    <li class="breadcrumb-item"><a style="color: black" href="{{route('vender.service.provider')}}">Service Provider</a>
                    </li>
                    <li class="breadcrumb-item"><a style="color: black" href="{{route('vender.service.provider.trading.unit')}}">Trade Units</a>
                    </li>
                    <li class="breadcrumb-item"><a style="color: black" href="{{route('vender.service.provider.trading.unit.view',$trading_unit['id'])}}"> {{$trading_unit['name']}}</a>
                    </li>
                    <li class="breadcrumb-item"><a style="color: black" href="{{route('vender.service.provider.trading.unit.view',$trading_unit['id'])}}"> Overview</a>
                    </li>
                    <li class="breadcrumb-item"> Trade unit information
                    </li>
                    <li class="breadcrumb-item"> App settings
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
        <div >
            <div style="float: left; width: 10%;">
                <img src="/trading_unit.png" style="width: 22px;margin-top: -5px;" >
            </div>
            <div style="float: left; width: 90%;">
                <span><span style="color:#ff6600">Trading Unit : </span> {{$trading_unit['name']}}</span>
            </div>

            <p style="border-bottom: 2px solid black;padding-top: 30px;margin-left: -12px;margin-right: -10px;"></p>



        </div>
        <div style="margin: 20px;margin-top: 23px;font-weight: 500;font-size: 15px;">
            <span> <span style="color:#ff6600"> Business Name</span> : @if($trading_unit['trading_template']==1)
                        {{auth()->user()->profile->company_name}}

                        @endif
                        @if($trading_unit['trading_template']==2)
                        {{auth()->user()->profile->company_name}} Trading as {{$trading_unit['trading_name']['name']}}

                        @endif
                        @if($trading_unit['trading_template']==3)
                        {{$trading_unit['trading_name']['name']??''}}

                        @endif</span>
        </div>
        <div style="margin: 20px;margin-top: 23px;font-weight: 500;font-size: 15px;">
            <span> <span style="color:#ff6600"> Online Status : </span> </span>
        </div>
        <div style="margin: 20px;margin-top: 13px;font-weight: 500;font-size: 15px;">
            <span>  Marketplace  : @isset($trading_unit['hub_setting']) {{$trading_unit['hub_setting']['is_marketplace']?'On':"Off"}}@else 'OFF' @endif </span> <br>
            <span>  Quotes  :    @isset($trading_unit['hub_setting']){{$trading_unit['hub_setting']['is_quote']?'On':"Off"}} @else 'Off' @endif</span> <br>
                        <span>  Bookings  :  @isset($trading_unit['hub_setting']) {{$trading_unit['hub_setting']['is_booking']?'On':"Off"}}  @else 'Off' @endif</span>
        </div>
        {{-- <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
            <span class="success">{{$trading_unit['status']}}</span>
        </div>
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
            <span class="success">{{$trading_unit['active_status']}}</span>
        </div> --}}
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;margin-bottom:0px">
            <span >Created: {{\Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at  {{\Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}</span>
        </div>
        <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;margin-bottom:0px">
            <span >Last updated: {{\Carbon\Carbon::parse($trading_unit['updated_at'])->format('d/m/Y') }} at  {{\Carbon\Carbon::parse($trading_unit['updated_at'])->format('h:i') }}</span>
        </div>

        </h4>
        <div class="footers" style="text-align: center;">

            @if($trading_unit['status']=="PENDING" || $trading_unit['status']=="INACTIVE")
            <a href="{{route('vender.service.provider.trading.unit.active',$trading_unit['id'])}}">  <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">ACTIVATE TRADE UNIT</button></a>
            @else
            <a href="{{route('vender.service.provider.trading.unit.in.active',$trading_unit['id'])}}">  <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">INACTIVATE TRADE UNIT</button></a>

            @endif
            @if($trading_unit['active_status']=="OFFLINE")
            <a href="{{route('vender.service.provider.trading.unit.Online',$trading_unit['id'])}}">  <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1"
               >SHOW ONLINE</button></a>

               @else
               <a href="{{route('vender.service.provider.trading.unit.offline',$trading_unit['id'])}}">  <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1"
                  >SHOW OFFLINE</button></a>

               @endif



       </div>

        </div>
    </div>
    <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">
        <div class="row ">
          <a href="{{route('vender.service.provider.trading.unit.view',$trading_unit['id'])}}"><h4 class="h3"  style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;"> Overview</h2></a>
          <a href="{{route('vender.service.provider.trading.unit.app.setting',$trading_unit['id'])}}"><h4 class="h3" style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 15px;"> App settings</h2></a>
            <a href="{{route('vender.service.provider.trading.unit.app.data',$trading_unit['id'])}}"> <h4 class="h3" style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;"> App data </h2> </a>


        </div>

        <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;margin-top: -6px;">




            <a id="headingCollapse1" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#collaptr_businesss_info" aria-expanded="false" aria-controls="collaptr_businesss_info">
                <div class="card-title lead ">Booking
                    <div class="tags">
                    <div class="tag">Service Provider</div>
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Booking start time</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                              {{$trading_unit['app_setting']['start_time']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Last booking time</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['end_time']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Booking time intervals</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['interval']??''}} minutes
                            </div>
                        </div>






                    </div>
                    <div class="footers" @if($is_provider=="off") style="display:none"  @endif>

                        <a href="{{route('vender.service.provider.trading.unit.booking.setting',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>


            <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#invoice_settings" aria-expanded="false" aria-controls="invoice_settings">
                <div class="card-title lead ">Invoice Document
                    <div class="tags">
                    <div class="tag">Service Provider</div>

                </div>
                </div>
            </a>
            <div id="invoice_settings" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Business Name Format</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if(auth()->user()->profile['organization_status']==="Limited Company")
                                @if($trading_unit['trading_template']==1)
                                Registered company name
                                @endif
                                @if($trading_unit['trading_template']==2)
                                Registered company name & trading name
                                @endif
                                @if($trading_unit['trading_template']==3)
                                Trading name
                                @endif

                                @else
                                @if($trading_unit['trading_template']==1)
                                Registered sole trader name
                                @endif
                                @if($trading_unit['trading_template']==2)
                                Registered sole trader name & trading name
                                @endif
                                @if($trading_unit['trading_template']==3)
                                Trading name
                                @endif

                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Business Name</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if($trading_unit['trading_template']==1)
                            {{ucfirst(auth()->user()->profile->company_name)}}

                            @endif
                            @if($trading_unit['trading_template']==2)
                            {{ucfirst(auth()->user()->profile->company_name)}} Trading as {{$trading_unit['trading_name']['name']}}

                            @endif
                            @if($trading_unit['trading_template']==3)
                            {{ucfirst($trading_unit['trading_name']['name'])??''}}

                            @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Address Line One </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['address_line_1']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Address Line Two</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['address_line_2']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Address Line Three</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['address_line_3']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Address Line Four</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['address_line_4']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">City / Town</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['city']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Postcode</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['postcode']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Landline</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['landline']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Mobile</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['mobile']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['email']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Website</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['website']??''}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">UK VAT Number</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p>{{auth()->user()->profile['uk_vat_no']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Bank Transfer Details *</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['bank_transfer']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        @if($trading_unit['app_setting']['bank_transfer']=="YES")
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0" style="padding-left: 15px;">Account Name</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['account_name']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0" style="padding-left: 15px;">Sort Code</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['sort_code']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0" style="padding-left: 15px;">Account Number</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['account_number']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0" style="padding-left: 15px;">Payment Reference</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['payment_reference']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0" style="padding-left: 15px;">Remittance Email Address</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <p> {{$trading_unit['app_setting']['remittance_email']??''}}</p>
                            </div>
                        </div>
                        <hr>
                        @endif

                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Footer – Register Company name</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['footer_business_name']??auth()->user()->profile['company_name']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Footer – Registered Office Address</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{-- {{$trading_unit['app_setting']['footer_office_address']??auth()->user()->profile['address_line_1'] ." ". auth()->user()->profile['address_line_2'] ." ". auth()->user()->profile['address_line_3'] ." ". auth()->user()->profile['address_line_4']}} --}}

                                {{auth()->user()['profile']['address_line_1']}} @if(auth()->user()['profile']['address_line_2']!=null) , @endif {{auth()->user()['profile']['address_line_2']}} , {{auth()->user()['profile']['city']}}  , {{auth()->user()['profile']['postcode']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Footer - Registered Company Jurisdiction</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['company_number']??auth()->user()->profile['company_jurisdiction']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Footer – Registered Company Number</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['company_number']??auth()->user()->profile['registration_no']}}
                            </div>
                        </div>







                    </div>
                    <div class="footers" @if($is_provider=="off") style="display:none"  @endif>

                        <a href="{{route('vender.service.provider.trading.unit.invoice.setting',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>

            <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;display:none;" data-toggle="collapse" href="#vat_settings" aria-expanded="false" aria-controls="vat_settings">
                <div class="card-title lead ">VAT settings</div>
            </a>
            <div id="vat_settings" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">VAT </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{auth()->user()['profile']['vat_register']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">VAT Booking </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                             {{$trading_unit['app_setting']['vat_booking']??'0'==1?"YES":'NO'}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">VAT Quote</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['vat_quote']??'0'==1?"YES":'NO'}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">VAT Jobs</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['app_setting']['vat_job']??'0'==1?"YES":'NO'}}
                            </div>
                        </div>








                    </div>
                    <div class="footers" @if($is_provider=="off") style="display:none"  @endif>

                        <a href="{{route('vender.service.provider.trading.unit.vat.setting',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            <a id="headingCollapse1" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#collaptr_Workstream_info" aria-expanded="false" aria-controls="collaptr_Workstream_info">
                <div class="card-title lead ">Workstream
                     <div class="tags">
                    <div class="tag">Service Provider</div>

                </div>
                </div>
            </a>
            <div id="collaptr_Workstream_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Workstream name</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- @foreach ($users as $user)

                                        @endforeach --}}


                                       @foreach ($workstreams as $contact)
                                       <tr>
                                           <td>{{$loop->iteration}}</td>
                                           <td>{{$contact['workstream_name']}}</td>
                                           <td>{{$contact['status'] }}</td>



                                           <td> <a href="{{route('vender.service.provider.trading.unit.view.work.stream',[$contact['id'],$trading_unit['id']])}}"><i class="ft-eye"></i></a></td>
                                       </tr>

                                       @endforeach



                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Workstream name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>








                    </div>
                    <div class="footers" >

                        <a href="{{route('vender.service.provider.trading.unit.add.work.stream',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">ADD</button></a>

                   </div>
                </div>
            </div>
             @isset($trading_unit['hub_setting'])
             <a id="headingCollapse1" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#online_status_info" aria-expanded="false" aria-controls="online_status_info">
                <div class="card-title lead ">Online statuses
                     <div class="tags">
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="online_status_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Marketplace</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                            @isset($trading_unit['hub_setting']) {{$trading_unit['hub_setting']['is_marketplace']?'On':"Off"}} @else 'Off' @endisset
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Quotes</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               @isset($trading_unit['hub_setting'])  {{$trading_unit['hub_setting']['is_quote']?'On':"Off"}}  @else 'Off' @endisset
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Bookings</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               @isset($trading_unit['hub_setting'])  {{$trading_unit['hub_setting']['is_booking']?'On':"Off"}}  @else 'Off' @endisset
                            </div>
                        </div>






                    </div>

                    <div class="footers"  @if($is_hub=="off") style="display: none"  @endif>

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.online.status',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            @endisset

             <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#opening_hours" aria-expanded="false" aria-controls="opening_hours">
                <div class="card-title lead ">Opening hours
                     <div class="tags">

                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            @isset($trading_unit['hub_setting'])
            <div id="opening_hours" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Monday </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               @if ($trading_unit['hub_setting']['is_monday']==1)
                               {{$trading_unit['hub_setting']['monday_start_time']}} - {{$trading_unit['hub_setting']['monday_end_time']}}
                               @else
                               Close
                               @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Tuesday </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_tuesday']==1)
                                {{$trading_unit['hub_setting']['tuesday_start_time']}} - {{$trading_unit['hub_setting']['tuesday_end_time']}}
                                @else

                                Closed
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Wednesday</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_wednesday']==1)
                                 {{$trading_unit['hub_setting']['wednesday_start_time']}} - {{$trading_unit['hub_setting']['wednesday_end_time']}}
                                 @else

                                 Closed
                                 @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Thursaday</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_thursday']==1)
                                 {{$trading_unit['hub_setting']['thursday_start_time']}} - {{$trading_unit['hub_setting']['thursday_end_time']}}

                                 @else

                                 Closed
                                 @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Friday</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_friday']==1)
                                 {{$trading_unit['hub_setting']['friday_start_time']}} - {{$trading_unit['hub_setting']['friday_end_time']}}

                                 @else

                                 Closed
                                 @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Saturday</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_saturday']==1)
                                 {{$trading_unit['hub_setting']['saturday_start_time']}} - {{$trading_unit['hub_setting']['saturday_end_time']}}

                                 @else

                                 Closed

                                 @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Sunday</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                @if ($trading_unit['hub_setting']['is_sunday']==1)
                                 {{$trading_unit['hub_setting']['sunday_start_time']}} - {{$trading_unit['hub_setting']['sunday_end_time']}}

                                 @else

                                 Closed

                                 @endif
                            </div>
                        </div>








                    </div>
                    <div class="footers" @if($is_hub=="off") style="display: none"  @endif>

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.opening.hour',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            @endisset
            @isset($trading_unit['hub_setting'])
             <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#social_media" aria-expanded="false" aria-controls="social_media">
                <div class="card-title lead ">Social media profiles
                     <div class="tags">

                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="social_media" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Website </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               {{$trading_unit['hub_setting']['website']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Facebook </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                            {{$trading_unit['hub_setting']['facebook']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Instagram</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['hub_setting']['instagram']}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Trust Pilot</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$trading_unit['hub_setting']['trust_pilot']}}
                            </div>
                        </div>








                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.social.media',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            @endisset
              <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#job_type" aria-expanded="false" aria-controls="job_type">
                <div class="card-title lead ">Job types
                     <div class="tags">
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="job_type" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Job Type </h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                               <div class="row">
                                @foreach ($trading_unit['job_types'] as $job_type)
                                <div class="col-md-3 mt-1">
                                    <span class="badge badge-primary-1">{{$job_type['job_type']['name']}}</span>
                                </div>
                                @endforeach


                               </div>
                            </div>
                        </div>









                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.job.type',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
             <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#product_offer" aria-expanded="false" aria-controls="product_offer">
                <div class="card-title lead ">Products
                     <div class="tags">
                    <div class="tag">Service Provider</div>
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="product_offer" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Job Coverage</th>
                                            <th>Price</th>
                                            <th>Price Type</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- @foreach ($users as $user)

                                        @endforeach --}}


                                       @foreach ($trading_unit['product_offers'] as $contact)
                                       <tr>

                                           <td>{{$contact['product_no']}}</td>
                                           <td>{{$contact['product_name']}}</td>
                                           <td>{{$contact['description']}}</td>
                                           <td>{{ $contact['job_coverage']['name'] }}</td>
                                           <td>{{ number_format($contact['price'],2) }}</td>
                                           <td>{{ $contact['price_type'] }}</td>
                                           <td>{{ $contact['status'] }}</td>



                                           <td> <a href="{{route('vender.service.provider.trading.unit.hub.setting.view.product.offer',[$contact['id'],$trading_unit['id']])}}"><i class="ft-eye"></i></a></td>
                                       </tr>

                                       @endforeach



                                    </tbody>
                                    <tfoot>
                                        <tr>
                                           <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Job Coverage</th>
                                            <th>Price</th>
                                            <th>Price Type</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>








                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.product.offer',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Add</button></a>

                   </div>
                </div>
            </div>
             <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#warrenty_job" aria-expanded="false" aria-controls="warrenty_job">
                <div class="card-title lead ">Warranty jobs
                     <div class="tags">

                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="warrenty_job" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Warranty Job </h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                               <div class="row">
                                @foreach ($trading_unit['warranty_jobs'] as $job_type)
                                <div class="col-md-3 mt-1">
                                    <span class="badge badge-success">{{$job_type['warranty_job']['name']}}</span>
                                </div>
                                @endforeach


                               </div>
                            </div>
                        </div>






                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.warranty.job',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
               <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#vehicle_specialist" aria-expanded="false" aria-controls="vehicle_specialist">
                <div class="card-title lead ">Vehicle specialist
                     <div class="tags">
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="vehicle_specialist" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Vehicle specialist </h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                               <div class="row">
                                @foreach ($trading_unit['vehicle_specialists'] as $job_type)
                                <div class="col-md-3 mt-1">
                                    <span class="badge badge-success">{{$job_type['vehicle_specialist']['name']}}</span>
                                </div>
                                @endforeach


                               </div>
                            </div>
                        </div>








                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.vehicle.specialist',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#accreditation" aria-expanded="false" aria-controls="accreditation">
                <div class="card-title lead ">Accreditation & schemes
                     <div class="tags">
                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="accreditation" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Accreditation & schemes </h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                               <div class="row">
                                @foreach ($trading_unit['accreditations'] as $job_type)
                                <div class="col-md-3 mt-1">
                                    <span class="badge badge-success">{{$job_type['accreditation']['name']}}</span>
                                </div>
                                @endforeach


                               </div>
                            </div>
                        </div>







                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.accreditation',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>
            <a id="headingCollapse2" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle="collapse" href="#payment_method" aria-expanded="false" aria-controls="payment_method">
                <div class="card-title lead ">Payment methods
                     <div class="tags">

                    <div class="tag">Hub</div>
                </div>
                </div>
            </a>
            <div id="payment_method" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
            style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
            class="collapse " aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Payment methods </h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                <div class="row">
                                    @foreach ($trading_unit['payment_methods'] as $job_type)
                                    <div class="col-md-3 mt-1">
                                        <span class="badge badge-success">{{$job_type['payment_method']['name']}}</span>
                                    </div>
                                    @endforeach


                                   </div>
                            </div>
                        </div>









                    </div>
                    <div class="footers">

                        <a href="{{route('vender.service.provider.trading.unit.hub.setting.payment.method',$trading_unit['id'])}}">  <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                           style="float: right;">Edit</button></a>

                   </div>
                </div>
            </div>












        </div>






    </div>
</div>


@endsection
