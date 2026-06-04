@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* Arrow Icon for the User groups button */
        #headingCollapse1 {
            position: relative;
            display: block;
        }

        #headingCollapse1:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e843";
            /* Feather right arrow */
            transition: all 300ms linear 0s;
        }

        /* Tablet & Mobile Specific Enhancements (Covers iPads/Tablets at exactly 768px up to 991px) */
        @media (max-width: 991px) {

            /* Sidebar spacing */
            .col-lg-3 {
                margin-bottom: 25px;
            }

            /* Stack top navigation links cleanly */
            .nav-buttons {
                display: flex;
                flex-direction: column;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100%;
            }

            .nav-buttons a,
            .nav-buttons>h4 {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }

            .nav-buttons a h4,
            .nav-buttons>h4 {
                margin-left: 0 !important;
                margin-right: 0 !important;
                text-align: center;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">App settings</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a></li>
                       <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.trading.unit') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">App settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-12 mb-3">
            <h4 class="h3 d-flex align-items-center"
                style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600; font-size: 17px; margin-top: 0;">
                <img src="/business_manager.png" style="width: 22px; margin-right: 8px;"> Service Provider
            </h4>
        </div>

        <div class="col-lg-9 col-12" id="contens"
            style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">

            <div class="row d-flex align-items-center mb-2 flex-wrap nav-buttons" style="margin-left: 0;">
                <a href="{{ route('vender.service.provider.trading.unit') }}">
                    <h4 class="h3 mb-0"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black; margin-right: 15px;">
                        Trade units
                    </h4>
                </a>
                <a href="{{ route('vender.service.provider.app.setting') }}">
                    <h4 class="h3 mb-0"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600; margin-right: 15px;">
                        App settings
                    </h4>
                </a>
                <a href="{{ route('vender.service.provider.app.data') }}">
                    <h4 class="h3 mb-0"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black; margin-right: 15px;">
                        App data
                    </h4>
                </a>
            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">
                <a id="headingCollapse1" href="{{ route('vender.service.provider.user.group') }}"
                    class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;margin-top: 1px !important;">
                    <div class="card-title lead collapsed mb-0">User groups</div>
                </a>
            </div>

        </div>
    </div>
@endsection
