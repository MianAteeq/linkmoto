
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
        font: 14px/1.4 Georgia, serif;
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
            <p style="width: 50%;margin-top: 10px;font-size: 17px;text-align: left;float: left;">Powered by LinkMoto</p>
            <p style="width: 50%;margin-bottom: 10px;font-size: 16.5px;text-align: right;float: left;">
                www.linkmoto.co.uk</p>


        </div>
        <div style="width: 100%;clear: both;"></div>
        <div>
            <div class="top-addr">
                <div id="customer" style="overflow: hidden;margin: 10px;margin-top:25px;margin-bottom:0px;width: 50%;float: left;">

                    <h1 id="customer-title" style="font-size: 20px;font-weight: bold;line-height: 2.1;margin-bottom: 0">
                         @if($vender['profile']['organization_status']==="Limited Company")
                        @if($invoice['invoice']['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['invoice']['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['invoice']['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['invoice']['trading_name']['trading_name']['name']}}

                        @endif
                        @else

                        @if($invoice['invoice']['trading_name']['app_setting']['header_option']==1)
                        {{ ucfirst($vender['profile']['company_name']) }}
                        @elseif($invoice['invoice']['trading_name']['app_setting']['header_option']==2)

                        {{ ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['invoice']['trading_name']['trading_name']['name']}}
                        @else
                        {{$invoice['invoice']['trading_name']['trading_name']['name']}}

                        @endif

                        @endif
                        </h1>
                     <div class="add" style="display: flex;flex-direction: column;width: 100%;margin-top: -7px">
                        @php
    $addressLine1 = collect([
       $invoice['invoice']['trading_name']['app_setting']['address_line_1'] ?? null,
        $invoice['invoice']['trading_name']['app_setting']['address_line_2'] ?? null,
        $invoice['invoice']['trading_name']['app_setting']['address_line_3'] ?? null,
        $invoice['invoice']['trading_name']['app_setting']['address_line_4'] ?? null,
    ])->filter()->implode(', ');

    $addressLine2 = collect([
        $invoice['invoice']['trading_name']['app_setting']['city'] ?? null,
        $invoice['invoice']['trading_name']['app_setting']['postcode'] ?? null,
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

                        @if(!empty($invoice['invoice']['trading_name']['app_setting']['landline']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Tel: {{ $invoice['invoice']['trading_name']['app_setting']['landline']}}</p>
                       
                        
                        @endif
                        @if(!empty($invoice['invoice']['trading_name']['app_setting']['mobile']))
                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Mob: {{ $invoice['invoice']['trading_name']['app_setting']['mobile']}}</p>
                       
                        @endif
                        @if(!empty($invoice['invoice']['trading_name']['app_setting']['email']))

                        <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Email: {{ $invoice['invoice']['trading_name']['app_setting']['email'] }}
                        
                        @endif
                        
                        @if(!empty($invoice['invoice']['trading_name']['app_setting']['website']))
                        <p style="line-height: 1.8; font-size: 15px; margin:0; margin-top: -7px;">
                            {{ $invoice['invoice']['trading_name']['app_setting']['website'] }}
                        </p>
                        
                        
                        @endif
                        @if(!empty($vender['profile']['uk_vat_no']))
                       <p style="line-height: 1.8;font-size: 15px;margin:0;margin-top: -7px;">Registered VAT No: {{$vender['profile']['uk_vat_no'] }}</p>
                      
                      
                       @endif

                    </div>
                    <table id="meta" style="margin-top: 160px;width: 100%;">
                        <tr>
                            <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Invoice Reference
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">Invoice ID</td>
                            <td>
                               {{$invoice['invoice']['invoice_no']??''}}
                            </td>
                        </tr>




                    </table>

                </div>

                <div class="invoice-side" style="width: 50%;float: left;margin: 30px;margin-bottom:0px;">
                    <h2 style="float: right;padding-bottom: 10px;margin-right:30px; font-size:20px">PAYMENT RECEIPT</h2>

                    <table id="meta" style="margin-top: 40px;width: 100%;float: right;margin-right:20px;">
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">Payment ID
                            </td>
                            <td>
                                {{ $invoice['pay_no'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">DATE</td>
                            <td >
                               {{\Carbon\Carbon::parse($invoice['payment_date'])->format('d/m/Y') }} 
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">Time</td>
                            <td >
                               {{\Carbon\Carbon::parse($invoice['created_at'])->format('H:i:s') }}
                            </td>
                        </tr>



                    </table>


                </div>
            </div>
            <div style="width: 100%;clear: both;"></div>
            <table id="items" class="item-table"
                style="margin-top: 20px;width: 103%;margin-left:10px;border-bottom: 1px solid black !important;">
                <tr style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <th>Payment</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td style="color: black;border: none!important;padding:10px;">{{$invoice['payment_type']}}</td>
                    <td style="border: none!important;padding:10px;">{{$invoice['payment_method']}}</td>
                    <td style="border: none!important;padding:10px;">{{\Carbon\Carbon::parse($invoice['payment_date'])->format('D m Y') }}</td>
                    <td style="border: none!important;padding:10px;">£{{number_format($invoice['amount'],2)}}</td>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;padding-top:10px;padding-bottom:40px">
                    <td style="color: black;border: none!important;padding:10px; ">Payment Ref:</td>
                    <td style="border: none!important;padding:10px;">{{$invoice['payment_ref']}}</td>
                    <td style="border: none!important;padding:10px;"></td>
                    <td style="border: none!important;padding:10px;"></td>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td style="color: black;border: none!important;padding:10px;"></td>
                    <td style="border: none!important;padding:10px"></td>
                    <td style="border: none!important;padding:10px"></td>
                    <td style="border: none!important;padding:10px"></td>

                </tr>






            </table>


        </div>












    </div>


    <div style="width: 100%;clear: both;"></div>


     <div id="header" style="position: fixed;bottom: 0;width: 100%;margin: 10px;margin-top: 15px;">
        <p style="width: 100%;margin-top: 10px;font-size: 11px;text-align: left">
            @if($vender['profile']['organization_status']==="Limited Company")
            @if($invoice['invoice']['trading_name']['app_setting']['header_option']==1 || $invoice['invoice']['trading_name']['app_setting']['header_option']==2)
            {{ucfirst($vender['profile']['company_name']) }}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['invoice']['booking']['trading_name']['trading_name']['name']}}.
            @endif
            @else

            @if($invoice['invoice']['trading_name']['app_setting']['header_option']==1 || $invoice['invoice']['trading_name']['app_setting']['header_option']==2)
            {{-- {{ucfirst($vender['profile']['company_name']) }} --}}

            @else

            {{ucfirst($vender['profile']['company_name']) }} trading as {{$invoice['invoice']['booking']['trading_name']['trading_name']['name']}}.
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
