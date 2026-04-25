@extends('frontend::new-layouts.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            /* Updated to 100% for mobile responsiveness */
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 2px solid black;
            border-radius: 6px;
            border-color: black !important;
        }

        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;

        }

        /* Flexbox helper to push footer to bottom naturally */
        .flex-column-container {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            width: 60% !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body pb-1">

        <div class="row" style="border-bottom: 3px solid #949494; margin-bottom: 15px;">
            <div class="col-xl-12 col-12 px-1 px-md-2">
                <h3 class="h3" style="font-weight: 800; font-size: 18px; color: black; margin-bottom: 14px;">
                    Business registration application
                </h3>
            </div>
        </div>

        <div class="px-1 px-md-1">
            <div class="row" style="margin-top: 20px;">

                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div style="border-radius: 7px; border: 2px solid black;">
                        <h4 class="h3" style="padding: 10px; font-weight: 600; font-size: 17px;">
                            <img src="/home.png" style="width: 22px; margin-top: -5px;"> Subscription
                        </h4>
                    </div>
                </div>

                <div class="col-12 col-lg-8 body-height">
                    <form action="{{ route('vender.profile.plan.select') }}" method="POST" id="contens"
                        class="flex-column-container h-100"
                        style="border: 2px solid black; border-radius: 8px; overflow: hidden;">
                        @csrf
                        <input type="hidden" id="is_save_later" name="is_save_later" value="0">

                        <div class="link-body" style="padding: 10px; flex-grow: 1;">

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="product_name">Product <span
                                        style="color: red">*</span>
                                </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <select class="form-control" name="product_name" id="product_name">
                                        <option value="Service Provider App">Service Provider App</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="package_id">Plan <span
                                        style="color: red">*</span>
                                </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <select class="form-control js-example-basic-single" name="package_id" id="package_id">
                                        @foreach ($packages as $package)
                                            <option value="{{ $package['id'] }}"
                                                @if ($user['profile']['package_id'] == $package['id']) selected @endif>{{ $package['name'] }}
                                                @if ($package['price'] > 0)
                                                    - £ {{ $package['price'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="footers d-flex flex-wrap justify-content-center justify-content-md-end w-100 mt-auto"
                            style="gap: 10px; padding: 15px; border-top: 2px solid rgba(0,0,0,0.1);">
                            @if ($user['profile']['edit_step'] == 0)
                                <a href="{{ route('vender.profile.back', 8) }}" class="btn btn-dark round btn-min-width">
                                    PREVIOUS
                                </a>
                                <button type="button" onclick="saveforlater()" class="btn btn-dark round btn-min-width">
                                    SAVE AND EXIT
                                </button>
                                <button type="submit" class="btn btn-dark round btn-min-width">
                                    NEXT
                                </button>
                            @else
                                <button type="submit" class="btn btn-dark round btn-min-width">
                                    Update
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // JS Height calculation removed to allow natural container expansion.
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>
@endsection
