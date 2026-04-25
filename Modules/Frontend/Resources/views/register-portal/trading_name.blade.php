@extends('frontend::new-layouts.master')

@section('css')
    <style>
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
    </style>
@endsection

@section('content')
    <div class="content-body">

        <div class="row" style="border-bottom: 3px solid #949494; margin-bottom: 15px;">
            <div class="col-xl-12 col-12 px-1 px-md-2">
                <h3 class="h3" style="font-weight: 800; font-size: 18px; color: black; margin-bottom: 14px;">
                    Business registration application
                </h3>
            </div>
        </div>
        <div class="px-2 px-md-1">
            <div class="row" style="margin-top: 20px;">

                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div class="h-100" style="border-radius: 7px; border: 2px solid black;">
                        <h4 class="h3" style="padding: 10px;font-weight: 600;font-size: 17px; ">
                            <img src="/home.png" style="width: 22px;margin-top: -5px;"> Trading Name
                        </h4>
                        <p style="padding-left: 10px; padding-right: 10px;">Please let us know if you trade
                            using a different name to your
                            registered name. This is also
                            known as a ‘business name’.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-8 body-height">
                    <div id="contens" class="flex-column-container h-100"
                        style="border: 2px solid black; border-radius: 8px; overflow: hidden;">

                        <div class="link-body" style="padding: 10px; flex-grow: 1;">

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control">Does your business use any trading names?
                                    <span style="color: red">*</span> (?)</label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <div class="input-group">
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" name="is_trading_name" value="YES"
                                                @if ($user['profile']['is_trading_name'] == 'YES') checked @endif
                                                class="custom-control-input" id="Yes">
                                            <label class="custom-control-label" for="Yes">Yes</label>
                                        </div>
                                        <div class="d-inline-block custom-control custom-radio">
                                            <input type="radio" name="is_trading_name" value="NO"
                                                @if ($user['profile']['is_trading_name'] == 'NO') checked @endif
                                                class="custom-control-input" id="No">
                                            <label class="custom-control-label" for="No">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hide-form" @if ($user['profile']['is_trading_name'] == 'NO') style="display: none" @endif>
                                <form action="{{ route('vender.profile.trading.name') }}" method="POST"
                                    enctype="multipart/form-data" id="form">
                                    @csrf
                                    <input type="hidden" id="is_save_later" name="is_save_later" value="0">

                                    <div class="form-group" style="width:50%">
                                        <label for="name" style="width: 100%;">Trading names <span
                                                style="color: red">*</span>
                                            <a style="color: black" href="#collapsebusiness_vat" data-toggle="collapse"
                                                aria-expanded="false" aria-controls="collapsebusiness">(?)</a>
                                        </label>

                                        <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                                            <input type="text" id="name" style="flex: 1; min-width: 200px;"
                                                class="form-control" required placeholder="Trading names" name="name">
                                            <button type="submit"
                                                class="btn btn-primary btn-sm view-btn-black">ADD</button>
                                        </div>
                                    </div>
                                    <p class="text-danger file_proof" style="padding-left: 10px;width:100%;display: none">
                                        Proof of trading name is Required !
                                    </p>
                                </form>
                                <br>

                                <div id="append_data">
                                    @foreach ($user['trading_names'] as $name)
                                        <div class="form-group rm-{{ $name['id'] }} d-flex flex-wrap align-items-center justify-content-between mb-2"
                                            style="width: 51%">
                                            <p class="mb-0 mr-2" style="font-weight: 500;">{{ ucfirst($name['name']) }}</p>
                                            <button class="btn btn-primary btn-sm view-btn-black"
                                                onclick="deleteAlert(`{{ route('vender.profile.trading.delete', $name['id']) }}`,`{{ $name['id'] }}`)">
                                                DELETE</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="footers d-flex flex-wrap justify-content-center justify-content-md-end w-100 mt-auto"
                            id="footers" style="gap: 10px; padding: 15px; border-top: 2px solid rgba(0,0,0,0.1);">
                            @if ($user['profile']['edit_step'] == 0)
                                <a href="{{ route('vender.profile.back', $user['profile']['step']) }}"
                                    class="btn btn-dark round btn-min-width">
                                    PREVIOUS
                                </a>
                                <button onclick="saveforlater()" type="button" class="btn btn-dark round btn-min-width">
                                    SAVE AND EXIT
                                </button>
                                <button type="button" class="btn btn-dark round btn-min-width" onclick="movetoNEXT()">
                                    NEXT
                                </button>
                            @else
                                <button type="button" class="btn btn-dark round btn-min-width" onclick="movetoNEXT()">
                                    Update
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let count = @json(count($user['trading_names']) + 1);

        // JS Height manipulation removed for pure CSS responsiveness.

        $(document).ready(function() {
            let value = $('input[type=radio]:checked').val();
            if (value == 'YES') {
                $('.hide-form').show();
                $('.cname_info').show();
                $('.body-height_info').hide();
            } else {
                $('.hide-form').hide();
                $('.cname_info').hide();
            }
        });
    </script>

    <script>
        $('.form-btn').click(function() {
            $('input[type=file]').trigger('click');
        });
    </script>

    <script>
        function movetoNEXT() {
            let is_trading_name = $('input[type=radio][name=is_trading_name]:checked').val();
            $.ajax({
                url: `{{ route('vender.profile.trading.name.next') }}?is_trading_name=${is_trading_name}`,
                type: 'get',
                success: function(result) {
                    if (result.status) {
                        toastr.success('Trading Name Info Save Successfully', {
                            timeOut: 500000000,
                            closeButton: !0,
                            debug: !1,
                            newestOnTop: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                            preventDuplicates: !0,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                            tapToDismiss: !1
                        });
                        location.reload();
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $('.form-btns').val(fileName);
                $('.view-btn').show();
                $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
                $('.file_proof').hide();
            });
        });
    </script>

    <script>
        $("#form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let file = $('input[type=file]').val();
            if (file === "") {
                $('.file_proof').show();
                return false;
            } else {
                $('.file_proof').hide();
            }

            $.ajax({
                url: `{{ route('vender.profile.trading.name') }}`,
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data.status === false) {
                        toastr.error(data.error, {
                            timeOut: 5000,
                            closeButton: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                        });
                    } else {
                        toastr.success(data.message, {
                            timeOut: 5000,
                            closeButton: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                        });

                        // Refactored appended HTML to use flexible layout matching the loop above
                        let html = `
                        <div class="form-group rm-${data.name.id} d-flex flex-wrap align-items-center justify-content-between mb-2" style="width: 51%">
                            <p class="mb-0 mr-2" style="font-weight: 500;">${data.name.name}</p>
                            <button class="btn btn-primary btn-sm view-btn-black" onclick="deleteAlert('/vender/profile/trading/name/delete/${data.name.id}','${data.name.id}')"> DELETE</button>
                        </div>`;

                        $('#append_data').append(html);
                        $('form').trigger("reset");
                        $('.form-btns').val('Proof of trading name');
                        count = count + 1;
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

    <script>
        function deleteAlert(route, slug) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: route,
                        type: 'get',
                        success: function(result) {
                            if (result.status) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                $('.rm-' + slug).remove();
                            }
                        }
                    });
                }
            });
        }
    </script>

    <script>
        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {
                $('.hide-form').show();
                $('.cname_info').show();
                $('.body-height_info').hide();
            } else {
                $('.hide-form').hide();
                $('.cname_info').hide();
            }
        });
    </script>

    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            let is_trading_name = $('input[type=radio][name=is_trading_name]:checked').val();
            $.ajax({
                url: `{{ route('vender.profile.trading.name.next') }}?is_save_later=1`,
                type: 'get',
                success: function(result) {
                    if (result.status) {
                        toastr.success('Trading Name Info Save Successfully', {
                            timeOut: 500000000,
                            closeButton: !0,
                            debug: !1,
                            newestOnTop: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                            preventDuplicates: !0,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                            tapToDismiss: !1
                        });
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
