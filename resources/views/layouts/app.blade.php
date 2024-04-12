<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <meta name="description" content="{{ config('app.name', 'Laravel') }}">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta property="og:title" content="E-PRASS">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/simplemde/simplemde.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzonejs/dist/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">

    <style>
        .select2-container .select2-selection--single {
            height: 34px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px;
        }

    </style>
</head>
<body>

    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-fullrow">
        @include('layouts.navigation')

        @include('layouts.header')

        <main id="main-container">

            {{ $slot }}

        </main>

        @include('layouts.footer')

    </div>


    <script src="{{ asset('assets/js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_pages_dashboard.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplemde/simplemde.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/masked-inputs/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/masked-inputs/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzonejs/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.stack.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_charts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        jQuery(function() {
            Codebase.helpers('easy-pie-chart');
        });

    </script>

    <script>
        jQuery(function() {
            Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
        });

    </script>

    <script>
        jQuery(function() {
            Codebase.helpers(['summernote', 'ckeditor', 'simplemde']);
        });

    </script>

    <script>
        async function fetchNotifications() {
            try {
                const response = await fetch("{{ route('notification.get-notification') }}");
                const data = await response.json();

                $('#notif-numbers').html(data.number_of_notifications);
                $('#notif-list').html('');

                if (data.notification_list.length > 0) {
                    let element = '';
                    data.notification_list.forEach(value => {
                        element += `<li>
                                        <a class="d-flex align-items-center text-body-color-dark media mb-15" href="/notification/${value.uuid}/mark-as-read">
                                            <div class="ml-5 mr-15">
                                                <i class="fa fa-fw fa-circle ${value.read ? 'text-white' : 'text-primary'} small-icon"></i>
                                            </div>
                                            <div class="media-body pr-10">
                                                <p class="mb-0">${value.message}</p>
                                                <div class="text-muted font-size-sm font-italic">${value.time}</div>
                                            </div>
                                        </a>
                                    </li>`;
                    });
                    $('#notif-list').html(element);
                    console.log(data);
                } else {
                    const noNotificationMessage = `<li>
                                                     <p class="d-flex justify-content-center">Belum ada notifikasi</p>
                                                   </li>`;
                    $('#notif-list').html(noNotificationMessage);
                    $('#view-all-notification').addClass('d-none');
                }
            } catch (error) {
                console.log(error);
            }
        }

        fetchNotifications();

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('{{ config('
            broadcasting.connections.pusher.key ') }}', {
                cluster: '{{ config('
                broadcasting.connections.pusher.options.cluster ') }}'
                , forceTLS: true
            });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', async function(event) {
            try {
                const response = await fetch("{{ route('notification.get-notification') }}");
                const data = await response.json();

                if (data.notification_list.length > 0) {
                    $('#notif-numbers').html(data.number_of_notifications);
                    $('#notif-list').html('');

                    let element = '';
                    data.notification_list.forEach(value => {
                        element += `<li>
                                        <a class="d-flex align-items-center text-body-color-dark media mb-15" href="/notification/${value.uuid}/mark-as-read">
                                            <div class="ml-5 mr-15">
                                                <i class="fa fa-fw fa-circle ${value.read ? 'text-white' : 'text-primary'} small-icon"></i>
                                            </div>
                                            <div class="media-body pr-10">
                                                <p class="mb-0">${value.message}</p>
                                                <div class="text-muted font-size-sm font-italic">${value.time}</div>
                                            </div>
                                        </a>
                                    </li>`;
                    });

                    $('#notif-list').html(element);
                }
            } catch (error) {
                console.log(error);
            }
        });

    </script>
    @if (auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod') || auth()->user()->hasRole('hrd'))
    <script>
        $.get("{{ route('helper.count-new-inquiry') }}", function(data) {
            console.log("helper data", data);
            if (data.data.jumlah > 0) {
                $("#inquiry-nav").append(`&nbsp;<i class="badge badge-danger">` + data.data.jumlah + `<i>`)
            }

        })

        $.get("{{ route('helper.count-new-sourcing-item') }}", function(data) {
            console.log("new sourcing", data);
            if (data.data.jumlah > 0) {
                $("#sourcing-item-nav").append(`&nbsp;<i class="badge badge-danger">` + data.data.jumlah + `<i>`)
            }
        })

        $.get("{{ route('helper.count-app-po-supplier') }}", function(data) {
            console.log("new po supplier", data);
            if (data.data.jumlah > 0) {
                $("#po-supplier-nav").append(`&nbsp;<i class="badge badge-danger">` + data.data.jumlah + `<i>`)
            }
        })

        let role = "{{ auth()->user()->roles()->pluck('name')[0] }}";
        $.ajax({
            url: "{{ route('helper.count-app-payment-req') }}"
            , type: "POST"
            , data: {
                _token: "{{ csrf_token() }}",
                userRole: role // Send the user role data as a property within the data object
            }
            , success: function(data) {
                console.log("new payment req", data);
                if (data.data && data.data.jumlah > 0) { // Check for nested data structure and jumlah property
                    $("#payment-req-nav").append(`&nbsp;<i class="badge badge-danger">` + data.data.jumlah + `<i>`);
                } else {
                    console.log("No new payment requests found."); // Handle successful response with no new requests
                }
            }
            , error: function(xhr, status, error) {
                console.error(xhr.responseJSON.message)
            }
        });

        // $.ajax({
        //     url: "{{ route('helper.count-new-sourcing-item') }}"
        //     , type: "GET"
        //     , success: function(response) {
        //         console.log(response.status, response.data)
        //     }
        //     , error: function(xhr, status, error) {
        //         console.error(xhr.responseJSON.message)
        //     }
        // })

    </script>
    @endif

    @if (isset($js))
    {{ $js }}
    @endif

</body>
</html>
