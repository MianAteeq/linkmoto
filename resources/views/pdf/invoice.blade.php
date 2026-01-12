@php
            $zerovat=$item_array->filter(function ($value, $key) {
            return $value['vat_rate'] == 0;});
            $twentyVat=$item_array->filter(function ($value, $key) { return $value['vat_rate'] == 20;});
            $sevenVat=$item_array->filter(function ($value, $key) { return $value['vat_rate'] == 7;});

            $records=[];
            foreach ($zerovat as $key => $zero_vat) {
            $exists=collect($records)->filter(function ($f_zero, $key) use($zero_vat) { return $f_zero['vat_rate'] ==
            $zero_vat->vat_rate;});

            if(count($exists)==0){
            array_push($records,$zero_vat);
            }else {
            foreach ($exists as $key => $exist) {

            $exist->sub_total_ex_vat+=$zero_vat->sub_total_ex_vat;
            $exist->discount+=$zero_vat->discount;
            $exist->subtotal+=$zero_vat->subtotal;
            $exist->vat_price+=$zero_vat->vat_price;
            $exist->total_price+=$zero_vat->total_price;
            # code...
            }
            }


            }
            foreach ($twentyVat as $key => $twenty_Vat) {
            $exists=collect($records)->filter(function ($vat_f, $key) use($twenty_Vat) { return $vat_f['vat_rate'] ==
            $twenty_Vat->vat_rate;});

            if(count($exists)==0){
            array_push($records,$twenty_Vat);
            }else {
            foreach ($exists as $key => $exist) {

            $exist->sub_total_ex_vat+=$twenty_Vat->sub_total_ex_vat;
            $exist->discount+=$twenty_Vat->discount;
            $exist->subtotal+=$twenty_Vat->subtotal;
            $exist->vat_price+=$twenty_Vat->vat_price;
            $exist->total_price+=$twenty_Vat->total_price;
            }
            }


            }

            // return $sevenVat;
            foreach ($sevenVat as $key => $s_vat) {
            $exists=collect($records)->filter(function ($s_f, $key) use($s_vat) { return $s_f['vat_rate'] ==
            $s_vat->vat_rate;});

            if(count($exists)==0){
            // return 1;
            array_push($records,$s_vat);
            }else {

            foreach ($exists as $key => $exist) {

            $exist->sub_total_ex_vat+=$s_vat->sub_total_ex_vat;
            $exist->discount+=$s_vat->discount;
            $exist->subtotal+=$s_vat->subtotal;
            $exist->vat_price+=$s_vat->vat_price;
            $exist->total_price+=$s_vat->total_price;
            }


            }


            }
            @endphp
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Editable Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    {{--
    <link rel='stylesheet' type='text/css' href='css/style.css' /> --}}
    <link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>

</head>
<style>
    body {
        font: 14px/1.4 Arial, Helvetica, sans-serif;
    }

    table td,
    table th {
        border: 1px solid black;
        padding: 5px;
        /* padding-bottom: 1px;
        padding-top: 1px; */

    }
    .td{
        padding-bottom: 1px;
        padding-top: 1px;
    }
    .th{
        font-weight: normal;
    }


    .item-table th {
        border: 1px solid black !important;
        border-right: none !important;
        border-left: none !important;
    }

    .item-table tr {
        border: 1px solid black !important;
    }

    #items tr {
        border: none !important;
    }

    #items th {
        background: #d9d9d9;
        color: black;
    }

    /* #items td.total-line {
    border-right: 0;

    }
    #items td.total-value {
    border-left: 0;
    padding: 10px;
    } */

    .footer {
        /* margin: 100px 0px; */
        width: 100%;
        /* display: flex; */
        /* justify-content: flex-start; */

        margin: 30px 0px;
    }

    /* .main{
    margin-bottom: 330px;
    } */

    .main {
        margin-bottom: 100px;
    }
</style>


<body>

    <div id="page-wrap" style="width: 100%;margin: 0 auto; position: relative;">

        <div id="header">
            <p style="width: 50%;margin-top: 10px;font-size: 16px;text-align: left;float: left;margin-left: 12px;"></p>
            <p style="width: 50%;margin-bottom: 10px;font-size: 16px;text-align: right;float: left;margin-top: 10px;margin-left: 17px;"> Powered by LinkMoto (www.linkmoto.co.uk)</p>


        </div>
        <div style="width: 100%;clear: both;"></div>
        <div>
            <div class="top-addr">
                <div id="customer" style="overflow: hidden;margin: 10px;margin-bottom:0px;width: 50%;float: left;">

                    <h1 id="customer-title" style="font-size: 15px;font-weight: bold;line-height: 2.1;margin-bottom: 0">

                        @if($vender['profile']['organization_status']==="Limited Company")
                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif
                        @else

                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif

                        @endif
                        {{-- H & H MOTORS --}}
                    </h1>
                    <div class="add" style="display: flex;flex-direction: column;width: 100%;margin-top: -7px">
                        @php
    $addressLine1 = collect([
        $invoice['trading_name']['app_setting']['address_line_1'] ?? null,
        $invoice['trading_name']['app_setting']['address_line_2'] ?? null,
        $invoice['trading_name']['app_setting']['address_line_3'] ?? null,
        $invoice['trading_name']['app_setting']['address_line_4'] ?? null,
    ])->filter()->implode(', ');

    $addressLine2 = collect([
        $invoice['trading_name']['app_setting']['city'] ?? null,
        $invoice['trading_name']['app_setting']['postcode'] ?? null,
    ])->filter()->implode(' ');
@endphp

@if($addressLine1)
<p style="line-height:1.8;font-size:15px;margin:0;">
    {{ $addressLine1 }}
</p>
@endif

@if($addressLine2)
<p style="line-height:1.8;font-size:15px;margin:0;">
    {{ $addressLine2 }}
</p>
@endif

                        @if(!empty($invoice['trading_name']['app_setting']['landline']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Tel: {{ $invoice['trading_name']['app_setting']['landline']}}</p>
                       
                        
                        @endif
                        @if(!empty($invoice['trading_name']['app_setting']['mobile']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Mob: {{ $invoice['trading_name']['app_setting']['mobile']}}</p>
                       
                        @endif
                        @if(!empty($invoice['trading_name']['app_setting']['email']))

                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Email: {{ $invoice['trading_name']['app_setting']['email'] }}
                        
                        @endif
                        
                        @if(!empty($invoice['trading_name']['app_setting']['website']))
                        <p style="line-height: 1.8; font-size: 15px; margin:0; margin-top: -7px;">
                            {{ $invoice['trading_name']['app_setting']['website'] }}
                        </p>
                        
                        
                        @endif
                        @if(!empty($vender['profile']['uk_vat_no']))
                       <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Registered VAT No: {{$vender['profile']['uk_vat_no'] }}</p>
                      
                      
                       @endif

                    </div>
                    @php
                    $landline = $invoice['trading_name']['app_setting']['landline'] ?? '';
                    $mobile   = $invoice['trading_name']['app_setting']['mobile'] ?? '';
                    $email    = $invoice['trading_name']['app_setting']['email'] ?? '';
                    $website  = $invoice['trading_name']['app_setting']['website'] ?? '';
                    $vat_no   = $vender['profile']['uk_vat_no'] ?? '';
                
                    // Count how many fields have data
                    $filledCount = collect([$landline, $mobile, $email, $website, $vat_no])
                                    ->filter(fn($val) => !empty($val))
                                    ->count();
                
                    // Default margin
                    $marginTop = '194px';
                    if($invoice['bank_transfer_detail']=="YES"){
                    $marginTop = '-3px';
                        
                          $margin_top = '100px';
                        }
                    
                
                    if ($filledCount === 1) {
                        $marginTop = '170px'; // only one field
                        if($invoice['bank_transfer_detail']=="YES"){
                         $marginTop = '-10px';
                          $margin_top = '100px';
                        }
                    } elseif ($filledCount === 2) {
                        $marginTop = '150px'; // two fields
                        if($invoice['bank_transfer_detail']=="YES"){
                         $marginTop = '-10px';
                         $margin_top = '80px';
                        }
                    } elseif ($filledCount === 3) {
                        $marginTop = '130px'; // three fields
                        if($invoice['bank_transfer_detail']=="YES"){
                          $marginTop = '-10px';
                         $margin_top = '60px';
                        }
                    } elseif ($filledCount === 4) {
                        $marginTop = '110px'; // four fields
                        if($invoice['bank_transfer_detail']=="YES"){
                         $marginTop = '-10px';
                         $margin_top = '40px';
                        }
                    } elseif ($filledCount === 5) {
                        $marginTop = '90px'; // all fields
                        if($invoice['bank_transfer_detail']=="YES"){
                          $marginTop = '-10px';
                         $margin_top = '20px';
                        }
                    }
                @endphp
                
                    @if($invoice['bank_transfer_detail']=="YES")
                    <div style="font-size: 12px; line-height: 1.6;margin-top:{{$margin_top}};margin-bottom:15px;">
                        <p style="margin:0; padding:0;margin-top: -5px;"><strong>Payment by Bank Transfer</strong></p>
                        <p style="margin:0; padding:0;margin-top: -5px;"><strong>Account Name:</strong> {{$invoice['trading_name']['app_setting']['account_name']}}</p>
                        <p style="margin:0; padding:0;margin-top: -5px;">
                            <strong>Sort code:</strong> {{$invoice['trading_name']['app_setting']['sort_code']}}
                            &nbsp; | &nbsp; 
                            <strong>Account Number:</strong> {{$invoice['trading_name']['app_setting']['account_number']}}
                        </p>
                        @if($invoice['trading_name']['app_setting']['payment_reference']=="Invoice Number")
                        <p style="margin:0; padding:0;margin-top: -5px;">
                            <strong>Payment Reference:</strong> {{ $invoice['invoice_no'] }}
                        </p>
                       
                        
                        @endif
                         @if(!empty($invoice['trading_name']['app_setting']['remittance_email']))
                        <p style="margin:0; padding:0;margin-top: -5px;">
                            <strong>Remittance Email:</strong> {{$invoice['trading_name']['app_setting']['remittance_email']}}
                        </p>
                       
                        @endif
                    </div>
                    @endif
                    

                    
                   @if(!empty($landline) || !empty($mobile) || !empty($email) || !empty($website) || !empty($vat_no))
                   @if($invoice['bank_transfer_detail']=="YES")
                            <p style="margin:0; padding:0;padding-bottom:10px;margin-top: {{ $marginTop }};">Unit Price Rate: H (Hourly), F (Fixed)</p>
                            @else
                            <p style="margin-top: {{ $marginTop }};">Unit Price Rate: H (Hourly), F (Fixed)</p>
                        @endif
                        @else
                         @if($invoice['bank_transfer_detail']=="YES")
                            <p style="margin:0; padding:0;padding-bottom:10px;margin-top: {{ $marginTop }};">Unit Price Rate: H (Hourly), F (Fixed)</p>
                            @else
                            <p style="margin-top: {{ $marginTop }};">Unit Price Rate: H (Hourly), F (Fixed)</p>
                        @endif
                        
                        
                        @endif
                    
                   
                    <table id="meta" @if(!empty($invoice['trading_name']['app_setting']['landline'])) style="width: 100%;margin-top: 0px" @else  style="width: 100%;margin-top: 0px"  @endif>
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Vehicle Details
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;" class="meta-head td">VRM</td>
                            <td class="td">
                                {{ $invoice['booking']['vehicle']['vrm'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 100px!important;" class="meta-head td">Make & Model </td>
                            <td class="td">
                                {{
                                    $invoice['booking']['vehicle']['vehicle_make']['name']??'' }}   {{
                                    $invoice['booking']['vehicle']['vehicle_model']['name']??'' }}
                            </td>
                        </tr>

                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">ENGINE</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['engine_size']['eng_size']??'' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">COLOUR</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['color']['color']??'' }}</div>
                            </td>
                        </tr> --}}

                    </table>

                </div>

                <div class="invoice-side" style="width: 50%;float: left;margin: 30px;margin-bottom:0px;margin-top: 25px;">
                    <h2 style="float: right;padding-bottom: 5px;margin-right:30px;font-size:20px;font-weight: bold;">INVOICE</h2>

                    <table id="meta" style="margin-top: 25px;width: 100%;float: right;margin-right:20px;">
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;font-size:15px;width: 80px;" class="meta-head td">Invoice ID
                            </td>
                            <td class="td">
                                {{ $invoice['invoice_no'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Invoice Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Supply Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Due Date</td>
                            <td style="text-align: left;" class="td">
                                Due upon receipt
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black" class="meta-head td">Page</td>
                            <td style="text-align: left;" class="td">
                                1 of @if (count($third_array)>0) 3 @elseif (count($second_array)>0) 2 @else 1 @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">AMOUNT DUE
                            </td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">£{{ number_format($invoice['total'],2) }}
                                </div>
                            </td>
                        </tr> --}}

                    </table>

                    <table id="meta" style="margin-top:150px;width: 100%;float: right;margin-right:20px; ">
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Customer Details
                            </th>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;width: 80px!important;" class="meta-head td" >Full Name
                            </td>
                            <td class="td">
                                {{ $invoice['name'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Company
                            </td>
                            <td class="td">
                                {{ $invoice['company'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Mobile</td>
                            <td class="td">
                                {{ $invoice['mobile_no'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Landline
                            </td>
                            <td class="td">
                                {{ $invoice['landline_no'] }}
                            </td>
                        </tr>
                        <tr style="border-bottom: 0!important;">
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Address
                            </td>
                            <td style="border-bottom : hidden!important;">
                                <div class="due">{{($invoice['address_line_1'])}} @if($invoice['address_line_2']!=null) , @endif {{ $invoice['address_line_2']}} </div>
                            </td>
                        </tr>
                        <tr>
                            @php
                            if($invoice['city']!=null || $invoice['postal_code']!=null){
                            $paddingBottom='20px';
                            }else{
                            $paddingBottom='40px';
                            }
                            
                            @endphp
                            <td colspan="2" style="text-align: left; width: 100;padding-bottom: {{$paddingBottom}};padding-top: 10px;" class="meta-head">
                                <div class="due">  {{ $invoice['address_line_3']}} @if($invoice['address_line_3']!=null) , @endif {{$invoice['city'] }} @if($invoice['city']!=null) , @endif {{$invoice['postal_code']}}</div>
                            </td>

                        </tr>





                    </table>
                </div>
            </div>
            <div style="width: 100%;clear: both;"></div>
            <table id="items" class="item-table"
                style="margin-top: 10px;margin-left: 10px;width: 102.5%;border-bottom: 1px solid black !important;">
                <tr style="border-left:1px solid black !important;border-right: 1px solid black !important;border-spacing:10px 10px;">
                    <th class="th" style="width: 210px;">Item/Description</th>
                    <th class="th">Job <br> Coverage</th>
                    <th class="th">Unit Price</th>
                    <th class="th">Qty</th>
                    <th class="th">Discount</th>
                    <th class="th">Subtotal Ex <br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT</th>
                    <th class="th">VAT <br> Rate</th>
                    <th class="th">VAT </th>
                    <th class="th" style="text-align: right">Total</th>
                </tr>

              <tbody style="">
                @foreach ($first_array as $keys=> $first_item)
                {{-- @dd($first_item) --}}
                <tr class="item-row"
                @php
                    if($first_item['unit_price_rate']=="Hourly"){

                        $item_type='H';
                    }
                    else{

                        $item_type='F';
                    }

                @endphp
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 8px!important">
                          @foreach($first_item->job_types as $i => $record) {{ $record->job_type->name }} @if($i + 1 < count($first_item->job_types)), @endif @endforeach @if(!empty($first_item->product)), {{ \Illuminate\Support\Str::limit($first_item->product, 50) }} @endif

                      
                    </p> </td>
                    <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important">{{ $first_item['price_type']['name']??'N.A' }}</p></td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{number_format($first_item['unit_price'],2)}} ({{$item_type}}) </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;">{{ $first_item['qty'] }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{ number_format($first_item['discount'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">£{{ number_format($first_item['exlusive_vat'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">{{ number_format($first_item['vat_rate'],2) }}% </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;margin-right: 5px!important">£{{ number_format($first_item['vat_price'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;">£{{ number_format($first_item['totalPrice'],2) }} </p> </td>
                </tr>


                @endforeach
                @for ($i=count($first_array);$i<10;$i++)
                <tr class="item-row"
                style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
                <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p></td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
                <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            </tr>




                @endfor

              </tbody>




            </table>


        </div>


        @if (count($item_array)<11)
        <div class="main" style="width:100%;margin-top:10px;">

            <div class="tleft" style="width: 70%;float: left;margin-left: 10px;">

               <table id="items" style="width: 100%; border: 1px solid black;">
                    <tr>
                        <th colspan="6" style="text-align:left;">VAT Summary</th>
                    </tr>
                    <tr class="item-row" style="border-left:1px solid black !important;border-right: 1px solid black !important;border-bottom: 1px solid black !important;">
                        <th class="th" style="border: none!important;text-align: right">VAT Rate</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">Discount</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">VAT </th>
                        <th class="th" style="border: none;text-align: right">Total</th>
                    </tr>
                   @foreach ($records as $record)
    @php
        // Net amount = Total - VAT - Discount
        $netAmount = ($record['total_price'] - $record['vat_price']) + $record['discount'];
    @endphp
    <tr class="item-row">
        <!-- VAT Rate -->
        <td style="border: none!important; text-align: right;">
            {{ number_format($record['vat_rate'], 2) }}%
        </td>

        <!-- Gross before VAT (including discount reversal if needed) -->
        <td style="border: none!important; text-align: right;">
            £{{ number_format($netAmount, 2) }}
        </td>

        <!-- Discount -->
        <td style="border: none!important; text-align: right;">
            £{{ number_format($record['discount'], 2) }}
        </td>

        <!-- Net Amount (after discount, before VAT) -->
        <td style="border: none!important; text-align: right;">
            £{{ number_format($netAmount-$record['discount'], 2) }}
        </td>

        <!-- VAT -->
        <td style="color: black; border: none!important; text-align: right;">
            £{{ number_format($record['vat_price'], 2) }}
        </td>

        <!-- Total -->
        <td style="border: none!important; text-align: right;">
            £{{ number_format($record['total_price'], 2) }}
        </td>
    </tr>
@endforeach

                    
                    @if(count($records)==1)


                    @for ($i=0; $i<=0; $i++)
                    <tr class="item-row">
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:0px;paddding-bottom:0px; height: 0px;"></td>
                    </tr>
                    @endfor
                    @else
                    
                    @for ($i=1; $i<=1; $i++)
                    <tr class="item-row">
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                        <td style="border: none!important; text-align: right; padding-right: 20px; padding-top:4px;paddding-bottom:0px; height: 0px;"></td>
                    </tr>
                    @endfor
                    
                    @endif



                </table>


            </div>
            <div class="tright" style="width: 30%;float: right;;margin-right:-40px">
                @php
    $paid = 0;
    foreach ($invoice['payments'] as $payment) {
        if (in_array($payment->payment_type, ['Refund'])) {
            $paid += $payment->amount; // subtract refunds or credit notes
        } else {
            $paid += $payment->amount; // normal payments
        }
    }
@endphp

                <table id="items" style="border:none !important;width: 200px;">
                    <tr style="">
                        <th colspan="6" style="text-align:center;">Total (£)</th>
                    </tr>
                    <tr style="border-bottom: hidden!important">
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Total Due
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="subtotal">£{{ number_format($invoice['total'],2) }}</div>
                        </td>
                    </tr>
                    <tr style="border-bottom: hidden!important">

                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Paid</td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="total">£{{number_format($paid,2) }} </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Balance
                        </td>

                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="paid">£{{ number_format(($invoice['total']-$paid),2) }}</div>
                        </td>
                    </tr>




                </table>
                <table id="items" style="border:none !important;width: 200px;margin-top: 10px">
                    {{-- <tr style="">
                        <th colspan="6" style="text-align:center;">Total(£)</th>
                    </tr> --}}
                    <tr>
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: left;padding-left: 70px;">Status
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right;">
                            <div id="subtotal">
                            @if($invoice['status']=="REJECTED")
                            Void
                            @else
                            {{ $invoice['status'] }}
                            @endif
                            </div>
                        </td>
                    </tr>





                </table>

            </div>
        </div>
        @else
        <div class="main" style="width:100%;margin-top:10px;">

            <p style="margin-top: 40px;margin-left: 20px">Continued ....</p>
        </div>

        @endif









    </div>
    <div style="width: 100%;clear: both;"></div>


    <div id="header" style="position: fixed;bottom: 0;width: 100%;margin: 10px;margin-top: 15px;">
        <p style="width: 100%;margin-top: 10px;font-size: 11px;text-align: left">
            @if($vender['profile']['organization_status']==="Limited Company")
            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{ucfirst($vender['profile']['company_name']) }}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif
            @else

            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{-- {{ucfirst($vender['profile']['company_name']) }} --}}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif


            @endif
            {{-- Motodoc Ltd trading as H & H Motors. --}}
             </p>
        <p style="width: 100%;margin-bottom: 30px;margin-top: -18px;font-size: 11px;text-align: left">Registered office:  {{$vender['profile']['address_line_1']}}, @isset($vender['profile']['address_line_2']) {{$vender['profile']['address_line_2']}}, @endisset {{$vender['profile']['city']}}  {{$vender['profile']['postcode']}}. Registered in {{$vender['profile']['company_jurisdiction']}} no:  {{$vender['profile']['registration_no'] }}.
             {{-- {{ $vender['profile']['area'] }}.
            Registered in {{$vender['profile']['company_jurisdiction']}} no: {{ $vender['profile']['uk_vat_no'] }} --}}
             <p style="margin-top:-45px;margin-right: -20px; font-size: 11px;float: right;text-align: right!important"> v20241002</p></p>


    </div>

</body>

</html>
@if(count($second_array)>0)
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Editable Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    {{--
    <link rel='stylesheet' type='text/css' href='css/style.css' /> --}}
    <link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>

</head>
<style>
    body {
        font: 14px/1.4 Arial, Helvetica, sans-serif;
    }

    table td,
    table th {
        border: 1px solid black;
        padding: 5px;


    }
    .td{

    }

    .item-table th {
        border: 1px solid black !important;
        border-right: none !important;
        border-left: none !important;
    }

    .item-table tr {
        border: 1px solid black !important;
    }

    #items tr {
        border: none !important;
    }

    #items th {
        background: #d9d9d9;
        color: black;
    }

    /* #items td.total-line {
    border-right: 0;

    }
    #items td.total-value {
    border-left: 0;
    padding: 10px;
    } */

    .footer {
        /* margin: 100px 0px; */
        width: 100%;
        /* display: flex; */
        /* justify-content: flex-start; */

        margin: 30px 0px;
    }

    /* .main{
    margin-bottom: 330px;
    } */

    .main {
        margin-bottom: 100px;
    }
</style>


<body>

    <div id="page-wrap" style="width: 100%;margin: 0 auto; position: relative;">

        <div id="header">
            <p style="width: 50%;margin-top: 10px;font-size: 16px;text-align: left;float: left;margin-left: 12px;"></p>
            <p style="width: 50%;margin-bottom: 10px;font-size: 16px;text-align: right;float: left;margin-top: 10px;margin-left: 17px;">Powered by LinkMoto (www.linkmoto.co.uk) </p>


        </div>
        <div style="width: 100%;clear: both;"></div>
        <div>
            <div class="top-addr">
                <div id="customer" style="overflow: hidden;margin: 10px;margin-bottom:0px;width: 50%;float: left;">

                    <h1 id="customer-title" style="font-size: 17px;font-weight: bold;line-height: 2.1;margin-bottom: 0">

                        @if($vender['profile']['organization_status']==="Limited Company")
                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif
                        @else

                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif

                        @endif
                        {{-- H & H MOTORS --}}
                    </h1>
                    <div class="add" style="display: flex;flex-direction: column;width: 100%;margin-top: -7px">
                        <p style="line-height: 1.8;font-size: 15px;margin:0"> {{$invoice['trading_name']['app_setting']['address_line_1']}} @if($invoice['trading_name']['app_setting']['address_line_2']!=null) , @endif  {{$invoice['trading_name']['app_setting']['address_line_2']}} @if($invoice['trading_name']['app_setting']['address_line_3']!=null) , @endif  {{$invoice['trading_name']['app_setting']['address_line_3']}} <br> {{$invoice['trading_name']['app_setting']['address_line_4']}}

                            </p>
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px">{{$invoice['trading_name']['app_setting']['city']}}  {{$invoice['trading_name']['app_setting']['postcode']}}</p>
                       @if(!empty($invoice['trading_name']['app_setting']['landline']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Tel: {{ $invoice['trading_name']['app_setting']['landline']}}</p>
                        @endif
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Mob: {{ $invoice['trading_name']['app_setting']['mobile']}}</p>

                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Email: {{ $invoice['trading_name']['app_setting']['email'] }}
                        </p>
                        @php
                            $marginTop = (empty($vender['profile']['uk_vat_no']) && empty($invoice['trading_name']['app_setting']['website']))
                                ? '21px'
                                : '-7px';
                        @endphp
                        
                        <p style="line-height: 1.8; font-size: 15px; margin:0; margin-top: {{ $marginTop }};">
                            {{ $invoice['trading_name']['app_setting']['website'] }}
                        </p>
                        @if(!empty($vender['profile']['uk_vat_no']))
                       <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Registered VAT No: {{$vender['profile']['uk_vat_no'] }}</p>
                       @endif

                    </div>
                    <p style="margin-top:100px">Unit Price Rate: H (Hourly), F (Fixed)</p>
                     <table id="meta" @if(!empty($invoice['trading_name']['app_setting']['landline'])) style="width: 100%;margin-top: -20px" @else  style="width: 100%;margin-top: 0px"  @endif>
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Vehicle Details
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;" class="meta-head td">VRM</td>
                            <td class="td">
                                {{ $invoice['booking']['vehicle']['vrm'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 100px!important;" class="meta-head td">Make & Model </td>
                            <td class="td">
                                {{
                                    $invoice['booking']['vehicle']['vehicle_make']['name']??'' }}   {{
                                    $invoice['booking']['vehicle']['vehicle_model']['name']??'' }}
                            </td>
                        </tr>

                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">ENGINE</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['engine_size']['eng_size']??'' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">COLOUR</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['color']['color']??'' }}</div>
                            </td>
                        </tr> --}}

                    </table>

                </div>

                <div class="invoice-side" style="width: 50%;float: left;margin: 30px;margin-bottom:0px;margin-top: 25px;">
                    <h2 style="float: right;padding-bottom: 5px;margin-right:30px;font-size:20px;font-weight: bold;">INVOICE</h2>

                    <table id="meta" style="margin-top: 25px;width: 100%;float: right;margin-right:20px;">
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;font-size:15px;width: 80px;" class="meta-head td">Invoice ID
                            </td>
                            <td class="td">
                                {{ $invoice['invoice_no'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Invoice Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Supply Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Due Date</td>
                            <td style="text-align: left;" class="td">
                                Due upon receipt
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black" class="meta-head td">Page</td>
                            <td style="text-align: left;" class="td">
                                1 of @if (count($third_array)>0) 3 @elseif (count($second_array)>0) 2 @else 1 @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">AMOUNT DUE
                            </td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">£{{ number_format($invoice['total'],2) }}
                                </div>
                            </td>
                        </tr> --}}

                    </table>

                    <table id="meta" style="margin-top:120px;width: 100%;float: right;margin-right:20px; ">

                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Customer Details
                            </th>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;width: 80px!important;" class="meta-head td" >Full Name
                            </td>
                            <td class="td">
                                {{ $invoice['name'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Company
                            </td>
                            <td class="td">
                                {{ $invoice['company'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Mobile</td>
                            <td class="td">
                                {{ $invoice['mobile_no'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Landline
                            </td>
                            <td class="td">
                                {{ $invoice['landline_no'] }}
                            </td>
                        </tr>
                        <tr style="border-bottom: 0!important;">
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Address
                            </td>
                            <td style="border-bottom : hidden!important;">
                                <div class="due">{{($invoice['address_line_1'])}} @if($invoice['address_line_2']!=null) , @endif {{ $invoice['address_line_2']}} </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left; width: 100;padding-bottom: 40px;padding-top: 10px;" class="meta-head">
                                <div class="due">  {{ $invoice['address_line_3']}} @if($invoice['address_line_3']!=null) , @endif {{$invoice['city'] }} @if($invoice['city']!=null) , @endif {{$invoice['postal_code']
                            }}</div>
                            </td>

                        </tr>





                    </table>
                </div>
            </div>
            <div style="width: 100%;clear: both;"></div>
            <table id="items" class="item-table"
            style="margin-top: 10px;margin-left: 10px;width: 102.5%;border-bottom: 1px solid black !important;">
            <tr style="border-left:1px solid black !important;border-right: 1px solid black !important;border-spacing:10px 10px;">
                <th class="th" style="width: 210px;">Item/Description</th>
                <th class="th">Job <br> Coverage</th>
                <th class="th">Unit Price</th>
                <th class="th">Qty</th>
                <th class="th">Discount</th>
                <th class="th">Subtotal Ex <br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT</th>
                <th class="th">VAT <br> Rate</th>
                <th class="th">VAT </th>
                <th class="th" style="text-align: right">Total</th>
            </tr>

          <tbody style="">
            @foreach ($second_array as $item)
           <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important">{{ substr($item['product'],0,100) }}</p> </td>
                    <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important">{{ $item['price_type']['name']??'N.A' }}</p></td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{number_format($item['unit_price'],2)}} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;">{{ $item['qty'] }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{ number_format($item['discount'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">£{{ number_format($item['exlusive_vat'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">{{ number_format($item['vat_rate'],2) }}% </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;margin-right: 5px!important">£{{ number_format($item['vat_price'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;">£{{ number_format($item['totalPrice'],2) }} </p> </td>
                </tr>


            @endforeach

            @for ($i=count($second_array);$i<10;$i++)
            <tr class="item-row"
            style="border-left:1px solid black !important;border-right: 1px solid black !important;">
            <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
            <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p></td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
        </tr>




            @endfor

          </tbody>




        </table>




        </div>



        @if (count($item_array)<=20)
        <div class="main" style="width:100%;margin-top:10px;">

            <div class="tleft" style="width: 70%;float: left;margin-left: 10px">

               <table id="items" style="width: 100%; border: 1px solid black;">
                    <tr>
                        <th colspan="6" style="text-align:left;">VAT Summary</th>
                    </tr>
                    <tr class="item-row" style="border-left:1px solid black !important;border-right: 1px solid black !important;border-bottom: 1px solid black !important;">
                        <th class="th" style="border: none!important;text-align: right">VAT Rate</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">Discount</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">VAT </th>
                        <th class="th" style="border: none;text-align: right">Total</th>
                    </tr>
                    @foreach ($records as $record)
                    <tr class="item-row">
                        <td style="border: none!important;text-align: right;">{{ number_format($record['vat_rate'],2) }}%</td>
                        <td style="border: none!important;text-align: right;">£{{
                            number_format(($record['total_price']-$record['vat_price']),2) }}</td>
                        <td style="border: none!important;text-align: right;">£{{ number_format($record['discount'],2) }}</td>
                        <td style="border: none!important;text-align: right;">£{{
                            number_format((($record['total_price']-$record['vat_price'])-(($record['discount']))),2)
                            }}</td>
                        <td style="color: black;border: none!important;text-align: right;">£{{ number_format($record['vat_price'],2) }}
                        </td>

                        <td style="border: none!important;text-align: right;">£{{number_format($record['total_price'],2) }}</td>

                    </tr>


                    @endforeach

                    @for ($i=count($records);$i<=2;$i++)
                    <tr class="item-row">
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="color: black;border: none!important;text-align: right;padding-right: 20px;">
                        </td>

                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>

                    </tr>


                    @endfor



                </table>


            </div>
            <div class="tright" style="width: 30%;float: right;;margin-right:-40px">
                @php
    $paid = 0;
    foreach ($invoice['payments'] as $payment) {
        if (in_array($payment->payment_type, ['Refund'])) {
            $paid += $payment->amount; // subtract refunds or credit notes
        } else {
            $paid += $payment->amount; // normal payments
        }
    }
@endphp

                <table id="items" style="border:none !important;width: 200px;">
                    <tr style="">
                        <th colspan="6" style="text-align:center;">Total (£)</th>
                    </tr>
                    <tr style="border-bottom: hidden!important">
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Total Due
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="subtotal">£{{ number_format($invoice['total'],2) }}</div>
                        </td>
                    </tr>
                    <tr style="border-bottom: hidden!important">

                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Paid</td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="total">£{{number_format($paid,2) }} </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Balance
                        </td>

                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="paid">£{{ number_format(($invoice['total']-$paid),2) }}</div>
                        </td>
                    </tr>




                </table>
                <table id="items" style="border:none !important;width: 200px;margin-top: 10px">
                    {{-- <tr style="">
                        <th colspan="6" style="text-align:center;">Total(£)</th>
                    </tr> --}}
                    <tr>
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: left;padding-left: 70px;">Status
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right;">
                            <div id="subtotal"> @if($invoice['status']=="REJECTED")
                            Void
                            @else
                            {{ $invoice['status'] }}
                            @endif
                            </div>
                        </td>
                    </tr>





                </table>

            </div>
        </div>
        @else

        <div class="main" style="width:100%;margin-top:10px;">

            <p style="margin-top: 40px;margin-left: 20px">Continued ....</p>
        </div>
        @endif






    </div>
    <div style="width: 100%;clear: both;"></div>


    <div id="header" style="position: fixed;bottom: 0;width: 100%;margin: 10px;margin-top: 15px;">
        <p style="width: 100%;margin-top: 10px;font-size: 11px;text-align: left">
            @if($vender['profile']['organization_status']==="Limited Company")
            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{ucfirst($vender['profile']['company_name']) }}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif
            @else

            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{-- {{ucfirst($vender['profile']['company_name']) }} --}}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif


            @endif
            {{-- Motodoc Ltd trading as H & H Motors. --}}
             </p>
        <p style="width: 100%;margin-bottom: 30px;margin-top: -18px;font-size: 11px;text-align: left">Registered office:  {{$vender['profile']['address_line_1']}}, @isset($vender['profile']['address_line_2']) {{$vender['profile']['address_line_2']}}, @endisset {{$vender['profile']['city']}}  {{$vender['profile']['postcode']}}. Registered in England and Wales no:  {{$vender['profile']['registration_no'] }}.
             {{-- {{ $vender['profile']['area'] }}.
            Registered in
            {{$vender['profile']['company_jurisdiction']}} no: {{ $vender['profile']['uk_vat_no'] }} --}}
             <p style="margin-top:-45px;margin-right: -20px; font-size: 11px;float: right;text-align: right!important"> v20241002</p></p>


    </div>


</body>

</html>
@endif
@if(count($third_array)>0)
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Editable Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    {{--
    <link rel='stylesheet' type='text/css' href='css/style.css' /> --}}
    <link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>

</head>
<style>
    body {
        font: 14px/1.4 Arial, Helvetica, sans-serif;
    }

    table td,
    table th {
        border: 1px solid black;
        padding: 5px;
        padding-bottom: 1px;
        padding-top: 1px;

    }

    .item-table th {
        border: 1px solid black !important;
        border-right: none !important;
        border-left: none !important;
    }

    .item-table tr {
        border: 1px solid black !important;
    }

    #items tr {
        border: none !important;
    }

    #items th {
        background: #d9d9d9;
        color: black;
    }

    /* #items td.total-line {
    border-right: 0;

    }
    #items td.total-value {
    border-left: 0;
    padding: 10px;
    } */

    .footer {
        /* margin: 100px 0px; */
        width: 100%;
        /* display: flex; */
        /* justify-content: flex-start; */

        margin: 30px 0px;
    }

    /* .main{
    margin-bottom: 330px;
    } */

    .main {
        margin-bottom: 100px;
    }
</style>


<body>

    <div id="page-wrap" style="width: 100%;margin: 0 auto; position: relative;">

        <div id="header">
            <p style="width: 50%;margin-top: 10px;font-size: 16px;text-align: left;float: left;margin-left: 12px;"></p>
            <p style="width: 50%;margin-bottom: 10px;font-size: 16px;text-align: right;float: left;margin-top: 10px;margin-left: 17px;">Powered by LinkMoto (www.linkmoto.co.uk)</p>


        </div>
        <div style="width: 100%;clear: both;"></div>
        <div>
            <div class="top-addr">
                <div id="customer" style="overflow: hidden;margin: 10px;margin-bottom:0px;width: 50%;float: left;">

                    <h1 id="customer-title" style="font-size: 17px;font-weight: bold;line-height: 2.1;margin-bottom: 0">

                        @if($vender['profile']['organization_status']==="Limited Company")
                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif
                        @else

                        @if($invoice['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['trading_name']['trading_name']['name']}}

                        @endif

                        @endif
                        {{-- H & H MOTORS --}}
                    </h1>
                    <div class="add" style="display: flex;flex-direction: column;width: 100%;margin-top: -7px">
                        <p style="line-height: 1.8;font-size: 15px;margin:0"> {{$invoice['trading_name']['app_setting']['address_line_1']}} @if($invoice['trading_name']['app_setting']['address_line_2']!=null) , @endif {{$invoice['trading_name']['app_setting']['address_line_2']}} @if($invoice['trading_name']['app_setting']['address_line_3']!=null) , @endif {{$invoice['trading_name']['app_setting']['address_line_3']}} <br> {{$invoice['trading_name']['app_setting']['address_line_4']}}

                            </p>
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px">{{$invoice['trading_name']['app_setting']['city']}}  {{$invoice['trading_name']['app_setting']['postcode']}}</p>
                        @if(!empty($invoice['trading_name']['app_setting']['landline']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Tel: {{ $invoice['trading_name']['app_setting']['landline']}}</p>
                        @endif
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Mob: {{ $invoice['trading_name']['app_setting']['mobile']}}</p>

                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Email: {{ $invoice['trading_name']['app_setting']['email'] }}
                        </p>
                      @php
                            $marginTop = (empty($vender['profile']['uk_vat_no']) && empty($invoice['trading_name']['app_setting']['website']))
                                ? '21px'
                                : '-7px';
                        @endphp
                        
                        <p style="line-height: 1.8; font-size: 15px; margin:0; margin-top: {{ $marginTop }};">
                            {{ $invoice['trading_name']['app_setting']['website'] }}
                        </p>
                        @if(!empty($vender['profile']['uk_vat_no']))
                       <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Registered VAT No: {{$vender['profile']['uk_vat_no'] }}</p>
                       @endif

                    </div>
                    <p style="margin-top:100px">Unit Price Rate: H (Hourly), F (Fixed)</p>
                     <table id="meta" @if(!empty($invoice['trading_name']['app_setting']['landline'])) style="width: 100%;margin-top: -20px" @else  style="width: 100%;margin-top: 0px"  @endif>
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Vehicle Details
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;" class="meta-head td">VRM</td>
                            <td class="td">
                                {{ $invoice['booking']['vehicle']['vrm'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 100px!important;" class="meta-head td">Make & Model </td>
                            <td class="td">
                                {{
                                    $invoice['booking']['vehicle']['vehicle_make']['name']??'' }}   {{
                                    $invoice['booking']['vehicle']['vehicle_model']['name']??'' }}
                            </td>
                        </tr>

                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">ENGINE</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['engine_size']['eng_size']??'' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">COLOUR</td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">{{
                                    $invoice['booking']['vehicle']['color']['color']??'' }}</div>
                            </td>
                        </tr> --}}

                    </table>

                </div>

                <div class="invoice-side" style="width: 50%;float: left;margin: 30px;margin-bottom:0px;margin-top: 25px;">
                    <h2 style="float: right;padding-bottom: 5px;margin-right:30px;font-size:20px;font-weight: bold;">INVOICE</h2>

                    <table id="meta" style="margin-top: 25px;width: 100%;float: right;margin-right:20px;">
                        <tr>
                            <td style="text-align: right;background: #d9d9d9;color: black;font-size:15px;width: 80px;" class="meta-head td">Invoice ID
                            </td>
                            <td class="td">
                                {{ $invoice['invoice_no'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Invoice Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Supply Date</td>
                            <td style="text-align: left;" class="td">
                                {{\Carbon\Carbon::parse($invoice['invoice_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black;width: 80px;" class="meta-head td">Due Date</td>
                            <td style="text-align: left;" class="td">
                                Due upon receipt
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: right;background: #d9d9d9;color: black" class="meta-head td">Page</td>
                            <td style="text-align: left;" class="td">
                                1 of @if (count($third_array)>0) 3 @elseif (count($second_array)>0) 2 @else 1 @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">AMOUNT DUE
                            </td>
                            <td style="text-align: right;">
                                <div style="text-align: left;" class="due">£{{ number_format($invoice['total'],2) }}
                                </div>
                            </td>
                        </tr> --}}

                    </table>

                    <table id="meta" style="margin-top:120px;width: 100%;float: right;margin-right:20px; ">
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Customer Details
                            </th>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;width: 80px!important;" class="meta-head td" >Full Name
                            </td>
                            <td class="td">
                                {{ $invoice['name'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Company
                            </td>
                            <td class="td">
                                {{ $invoice['company'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head td">Mobile</td>
                            <td class="td">
                                {{ $invoice['mobile_no'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Landline
                            </td>
                            <td class="td">
                                {{ $invoice['landline_no'] }}
                            </td>
                        </tr>
                        <tr style="border-bottom: 0!important;">
                            <td style="background: #f2f2f2;text-align: right;color: black;" class="meta-head">Address
                            </td>
                            <td style="border-bottom : hidden!important;">
                                <div class="due">{{($invoice['address_line_1'])}} @if($invoice['address_line_2']!=null) , @endif {{ $invoice['address_line_2']}} </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left; width: 100;padding-bottom: 40px;padding-top: 10px;" class="meta-head">
                                <div class="due">  {{ $invoice['address_line_3']}} @if($invoice['address_line_3']!=null) , @endif {{$invoice['city'] }} @if($invoice['city']!=null) , @endif {{$invoice['postal_code']
                            }}</div>
                            </td>

                        </tr>





                    </table>
                </div>
            </div>
            <div style="width: 100%;clear: both;"></div>
            <table id="items" class="item-table"
            style="margin-top: 10px;margin-left: 10px;width: 102.5%;border-bottom: 1px solid black !important;">
            <tr style="border-left:1px solid black !important;border-right: 1px solid black !important;border-spacing:10px 10px;">
                <th class="th" style="width: 210px;">Item/Description</th>
                <th class="th">Job <br> Coverage</th>
                <th class="th">Unit Price</th>
                <th class="th">Qty</th>
                <th class="th">Discount</th>
                <th class="th">Subtotal Ex <br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT</th>
                <th class="th">VAT <br> Rate</th>
                <th class="th">VAT </th>
                <th class="th" style="text-align: right">Total</th>
            </tr>

          <tbody style="">
            @foreach ($third_array as $item)
           <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important">{{ substr($item['product'],0,100) }}</p> </td>
                    <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important">{{ $item['price_type']['name']??'N.A' }}</p></td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{number_format($item['unit_price'],2)}} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;">{{ $item['qty'] }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 5px!important">£{{ number_format($item['discount'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">£{{ number_format($item['exlusive_vat'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;margin-right: 10px!important">{{ number_format($item['vat_rate'],2) }}% </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;padding-right: 10px;margin-right: 5px!important">£{{ number_format($item['vat_price'],2) }} </p> </td>
                    <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;">£{{ number_format($item['totalPrice'],2) }} </p> </td>
                </tr>


            @endforeach
            @for ($i=count($third_array);$i<10;$i++)
            <tr class="item-row"
            style="border-left:1px solid black !important;border-right: 1px solid black !important;">
            <td class="td" style="color: black;border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
            <td class="td" style="border: none!important;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p></td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A</p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
            <td class="td" style="border: none!important;text-align: right;font-size: 12px;"><p style="margin:0px!important;margin-top:10px!important;font-size: 10px!important;color:white">N/A </p> </td>
        </tr>




            @endfor

          </tbody>




        </table>


        </div>


        @if (count($third_array)>0)
        <div class="main" style="width:100%;margin-top:10px;">

            <div class="tleft" style="width: 70%;float: left;margin-left: 10px">

                <table id="items" style="width: 100%; border: 1px solid black;">
                    <tr>
                        <th colspan="6" style="text-align:left;">VAT Summary</th>
                    </tr>
                    <tr class="item-row" style="border-left:1px solid black !important;border-right: 1px solid black !important;border-bottom: 1px solid black !important;">
                        <th class="th" style="border: none!important;text-align: right">VAT Rate</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">Discount</th>
                        <th class="th" style="border: none;text-align: right">Subtotal</th>
                        <th class="th" style="border: none;text-align: right">VAT </th>
                        <th class="th" style="border: none;text-align: right">Total</th>
                    </tr>
                    @foreach ($records as $record)
                    <tr class="item-row">
                        <td style="border: none!important;text-align: right;">{{ number_format($record['vat_rate'],2) }}%</td>
                        <td style="border: none!important;text-align: right;">£{{
                            number_format(($record['total_price']-$record['vat_price']),2) }}</td>
                        <td style="border: none!important;text-align: right;">£{{ number_format($record['discount'],2) }}</td>
                        <td style="border: none!important;text-align: right;">£{{
                            number_format((($record['total_price']-$record['vat_price'])-(($record['discount']))),2)
                            }}</td>
                        <td style="color: black;border: none!important;text-align: right;">£{{ number_format($record['vat_price'],2) }}
                        </td>

                        <td style="border: none!important;text-align: right;">£{{number_format($record['total_price'],2) }}</td>

                    </tr>


                    @endforeach

                    @for ($i=count($records);$i<=25;$i++)
                    <tr class="item-row">
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>
                        <td style="color: black;border: none!important;text-align: right;padding-right: 20px;">
                        </td>

                        <td style="border: none!important;text-align: right;padding-right: 20px;"></td>

                    </tr>


                    @endfor



                </table>


            </div>
            <div class="tright" style="width: 30%;float: right;;margin-right:-40px">
                @php
    $paid = 0;
    foreach ($invoice['payments'] as $payment) {
        if (in_array($payment->payment_type, ['Refund'])) {
            $paid += $payment->amount; // subtract refunds or credit notes
        } else {
            $paid += $payment->amount; // normal payments
        }
    }
@endphp

                <table id="items" style="border:none !important;width: 200px;">
                    <tr style="">
                        <th colspan="6" style="text-align:center;">Total (£)</th>
                    </tr>
                    <tr style="border-bottom: hidden!important">
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Total Due
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="subtotal">£{{ number_format($invoice['total'],2) }}</div>
                        </td>
                    </tr>
                    <tr style="border-bottom: hidden!important">

                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Paid</td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="total">£{{number_format($paid,2) }} </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td colspan="2" class="blank"> </td> -->
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: right">Balance
                        </td>

                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right">
                            <div id="paid">£{{ number_format(($invoice['total']-$paid),2) }}</div>
                        </td>
                    </tr>




                </table>
                <table id="items" style="border:none !important;width: 200px;margin-top: 10px">
                    {{-- <tr style="">
                        <th colspan="6" style="text-align:center;">Total(£)</th>
                    </tr> --}}
                    <tr>
                        {{-- <td colspan="2" class="blank"> </td> --}}
                        <td colspan="3" class="total-line td" style="color:black;border-right: 0!important;text-align: left;padding-left: 70px;">Status
                        </td>
                        <td colspan="3" class="total-value td" style="width: 100%;border-left: 0!important;text-align: right;">
                            <div id="subtotal"> @if($invoice['status']=="REJECTED")
                            Void
                            @else
                            {{ $invoice['status'] }}
                            @endif</div>
                        </td>
                    </tr>





                </table>

            </div>
        </div>
        @endif









    </div>
    <div style="width: 100%;clear: both;"></div>


    <div id="header" style="position: fixed;bottom: 0;width: 100%;margin: 10px;margin-top: 15px;">
        <p style="width: 100%;margin-top: 10px;font-size: 11px;text-align: left">
            @if($vender['profile']['organization_status']==="Limited Company")
            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{ucfirst($vender['profile']['company_name']) }}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif
            @else

            @if($invoice['trading_name']['app_setting']['header_option']==1 || $invoice['trading_name']['app_setting']['header_option']==2)
            {{-- {{ucfirst($vender['profile']['company_name']) }} --}}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['booking']['trading_name']['trading_name']['name']}}.
            @endif


            @endif
            {{-- Motodoc Ltd trading as H & H Motors. --}}
             </p>
        <p style="width: 100%;margin-bottom: 30px;margin-top: -18px;font-size: 11px;text-align: left">Registered office:  {{$vender['profile']['address_line_1']}}, @isset($vender['profile']['address_line_2']) {{$vender['profile']['address_line_2']}}, @endisset {{$vender['profile']['city']}}  {{$vender['profile']['postcode']}}. Registered in {{$vender['profile']['company_jurisdiction']}} no:  {{$vender['profile']['registration_no'] }}.
             {{-- {{ $vender['profile']['area'] }}.
            Registered in
            {{$vender['profile']['company_jurisdiction']}} no: {{ $vender['profile']['uk_vat_no'] }} --}}
             <p style="margin-top:-45px;margin-right: -20px; font-size: 11px;float: right;text-align: right!important"> v20241002</p></p>


    </div>
</body>

</html>
@endif

