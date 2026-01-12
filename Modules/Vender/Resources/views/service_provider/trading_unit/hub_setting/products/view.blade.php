@extends('vender::layouts.master')

@section('css_custom')
<link href="/modules/admin/app-assets/vendors/css/forms/selects/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 55% !important;
}
.select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 2px solid black;
    border-radius: 6px;
    border-color: black !important;
}




</style>

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
.btn-dark {
    border-color: black !important;
    background-color: black !important;
    color: #FFFFFF;
}
.round {
    border-radius: 0.5rem;
}
form .form-control {
    border: 2px solid #000000;
    color: #000000;
}
p{
    color: black;
}
.form-control:focus {
    color: #000000;
    background-color: #fff;
    border-color: #000000;
    outline: 0;
    box-shadow: none;
}
.form-control{
    width: 55%;
}
#headingCollapse1:before {
    position: absolute;
    top: 48%;
    right: 20px;
    margin-top: -8px;
    font-family: 'feather';
    content: "\e845"!important;
    transition: all 300ms linear 0s;
}
.select2-container--default{
    /* border: 2px solid #000000; */
    color: #000000;
}
.select2-dropdown{
    width: 414px!important;
    min-width: 315.516px!important;
    position: relative;
}
.select2-container--default .select2-selection--single {
    height: 40px !important;
    padding: 5px;
    border-color: black !important;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 2px solid black !important;
    border-radius: 4px;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 2px solid black !important;
    border-radius: 4px;
}
.tag-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      width: 54%;
    }

    .tag {
     background-color: #f58220;
    color: white;
    padding: 9px 11px;
    border-radius: 13px;
    display: inline-flex
;
    align-items: center;
    font-size: 14px;
    }

    .tag .close {
      margin-left: 8px;
      font-weight: bold;
      cursor: pointer;
      color:white;
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
                    <li class="breadcrumb-item"> <a href="{{route('vender.service.provider.trading.unit.hub.setting',$trading_unit['id'])}}" style="color: black">Hub profile settings</a>
                    </li>
                    <li class="breadcrumb-item"> View Product
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
        <div style="border-radius: 7px;border: 2px solid black;height: 44px;  ">
            <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
        <div>
            <div style="float: left; width: 10%;">
                <img src="/gear-black.png" style="width: 38px;margin-top: -5px;" >
            </div>
            <div style="float: left; width: 90%;">
                <span>Product</span>
            </div>



        </div>


        </h4>


        </div>
    </div>
    <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">
        <div class="row ">
            <a href="{{redirect()->back()->getTargetUrl()}}"><h4 class="h3"  style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: white;margin-left: 15px;background-color:black"> < Back</h2></a>

        </div>

        <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;margin-top: -6px;">




            <a id="headingCollapse1" href="{{redirect()->back()->getTargetUrl()}}" class="card-header info mt-2" style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" data-toggle=""  aria-expanded="false" >
                <div class="card-title lead collapsed">Product Information
                    <div class="tags" style="float: right;margin-right: 40px;">
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
            class="collapse show" aria-expanded="false">
                <div class="card-content">
                    <form action="{{route('vender.service.provider.trading.unit.hub.setting.product.offer.update')}}" id="contens" method="POST" enctype="multipart/form-data" id="contens"> @csrf
                        <div class="link-body"  style="padding: 10px">
                            <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">ID</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$product['product_no']}}
                            </div>
                        </div>
                        <hr>
                            <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Product Name</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$product['product_name']}}
                            </div>
                        </div>
                        <hr>
                            <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Job Type</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               @foreach ($jobstypes as $job_type)
                                {{$job_type['name']}},

                               @endforeach
                            </div>
                        </div>
                        <hr>
                             <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Job Request Description</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                 @foreach ($jobstypes as $job_type)
                                {{$job_type['name']}},

                               @endforeach <br/>
                                {{$product['description']}}
                            </div>
                        </div>
                        
                        <hr>
                             <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Job Coverage</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{$product['job_coverage']['name']}}
                            </div>
                        </div>
                       
                        <hr>
                             <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Price Type</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{($product['price_type'])}}
                            </div>
                        </div>
                         <hr>
                             <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Price (£)</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                               @if($product['price_type']=="POA") POA @else {{number_format($product['price'], 2, '.', '')}} @endif
                            </div>
                        </div>
                       
                        <hr>
                             <div class="row mt-1">
                            <div class="col-sm-5">
                                <h6 class="mb-0">Status</h6>
                            </div>
                            <div class="col-sm-7 text-secondary">
                                {{($product['status'])}}
                            </div>
                        </div>



                        </div>
                        <div class="footers">

                            <a href="{{route('vender.service.provider.trading.unit.hub.setting.edit.product.offer',[$product['id'],$trading_unit['id']])}}"><button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Edit</button></a>



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
        let array=['product_name','price','job_coverage_id','price_type','job_type_id','description','what_include'];

        let status=false;
        array.some((item)=>{
            let name = $(`#${item}`).val();
            console.log(name,item);

            if(name===""){



                $(`#${item}`).attr('style','border:2px solid red!important;');




                return false;

                }
                else
                {


                $(`#${item}`).attr('style','border:2px solid black!important;');


                }
        });

        array.some((item)=>{
            let name = $(`#${item}`).val();
            console.log(name,item);

            if(name===""){


                $(`#${item}`).attr('style','border:2px solid red!important;');

                status=false;


                return true;

                }
                else
                {

                $(`#${item}`).attr('style','border:2px solid black!important;');
                status=true;

                }
        });



        // return;


       if(status==true){
        $("form").submit();
       }






    }
</script>

<script>
    async  function lookup(arg){
       var id = arg.getAttribute('id');
       var value = arg.value;


       let trading_name = $(`#${id}`).val();
       if(id!=="address_line_2" && id!=="city" && id!=="postcode"){
               if (trading_name === "") {


               $(`#${id}`).attr("style", "border:2px solid red!important;");
               status = false;

           } else {
               $(`#${id}`).attr("style", "border:2px solid black!important;");
               $(`.${id}`).hide();
           }
       }
       else{
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
<script src="/modules/admin/app-assets/vendors/js/forms/select/select2.full.min.js"></script>



<script>
    $(".select2-placeholder-multiple").select2({
      dropdownAutoWidth: true,
      width: '100%',
      placeholder: "Select Option Please",
    });



</script>


<script>
    let services=@json($services);
    var job_types=@json($jobstypes);
   function getSelectVal(sel)
   {
    console.table();
    let service_find=services.data.filter((item)=>item.id==sel.value);
    let job_type_find=job_types.filter((item)=>item.id==sel.value);
    if(job_type_find.length==0){
        job_types.push(service_find[0]);
    }
    let html=`<div class='tag-container mt-2'>`;

let text='';

    job_types.forEach((item)=>{
        html+=`<div class="tag">${item.name} <span class="close" onclick="removeTag(${item.id})">X</span></div>`;
         text+=`${item.name} ,`;
    });
    html+=`</div>`;

    $('#content_job_type').html(html);
     $('#description').text(text);

    const ids = job_types.map(user => user.id);
    $('#service_id').val(JSON.stringify(ids));



}

function removeTag(id){
    let job_type_find=job_types.filter((item)=>item.id==id);
    job_types=job_types.filter((item)=>item.id!=id);
let html=`<div class='tag-container mt-2'>`;
  job_types.forEach((item)=>{
        html+=`<div class="tag">${item.name} <span class="close" onclick="removeTag(${item.id})">X</span></div>`;
    });
    html+=`</div>`;

    $('#content_job_type').html(html);
     const ids = job_types.map(user => user.id);
    $('#service_id').val(JSON.stringify(ids));
}

</script>
<script>
    var job_types_includes=@json(json_decode($product['what_include']));
   function getSelectValInclude(sel)
   {
    console.table();
    let service_find=services.data.filter((item)=>item.id==sel.value);
    let job_type_find=job_types_includes.filter((item)=>item.id==sel.value);
    if(job_type_find.length==0){
        job_types_includes.push(service_find[0]);
    }
    let html=`<div class='tag-container mt-2'>`;



    job_types_includes.forEach((item)=>{
        html+=`<div class="tag">${item.name} <span class="close" onclick="removeTagInclude(${item.id})">X</span></div>`;
    });
    html+=`</div>`;

    $('#content_what_included').html(html);
     const ids = job_types_includes.map(user => user.id);
    $('#what_include_id').val(JSON.stringify(ids));



}

function removeTagInclude(id){
    let job_type_find=job_types_includes.filter((item)=>item.id==id);
    job_types_includes=job_types_includes.filter((item)=>item.id!=id);
let html=`<div class='tag-container mt-2'>`;
  job_types_includes.forEach((item)=>{
        html+=`<div class="tag">${item.name} <span class="close" onclick="removeTagInclude(${item.id})">X</span></div>`;
    });
    html+=`</div>`;

    $('#content_what_included').html(html);
    const ids = job_types_includes.map(user => user.id);
    $('#what_include_id').val(JSON.stringify(ids));
}

</script>




@endsection
