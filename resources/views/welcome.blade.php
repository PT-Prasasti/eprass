<x-app-layout>

    <div class="content">
        <div class="row gutters-tiny invisible" data-toggle="appear">
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="{{ route('crm.visit-schedule') }}">
                    <div class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-corporate-light">
                        <div class="shape-inner sign-right">
                            <div class="ribbon-box"><i class="fa fa-calendar text-white"></i></div>
                            <p class="mt-10 text-white" style="font-size: 60px; margin-bottom: -10px;">
                                <b>{{ $visit }}</b>
                            </p>
                            <p class="font-w600 text-white"><b>VISIT</b></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="{{ route('crm.inquiry') }}">
                    <div class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-dusk">
                        <div class="shape-inner sign-right">
                            <div class="ribbon-box"><i class="fa fa-edit text-white"></i></div>
                            <p class="mt-10 text-white" style="font-size: 60px; margin-bottom: -10px;">
                                <b>{{ $inquiry }}</b>
                            </p>
                            <p class="font-w600 text-white"><b>INQUIRY</b></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="../visit/index.php">
                    <div class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-primary">
                        <div class="shape-inner sign-right">
                            <div class="ribbon-box"><i class="fa fa-dollar text-white"></i></div>
                            <p class="mt-10 text-white" style="font-size: 60px; margin-bottom: -10px;">
                                <b>10</b>
                            </p>
                            <p class="font-w600 text-white"><b>QUOTATION</b></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="../visit/index.php">
                    <div class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-sea">
                        <div class="shape-inner sign-right">
                            <div class="ribbon-box"><i class="fa fa-folder-open text-white"></i></div>
                            <p class="mt-10 text-white" style="font-size: 60px; margin-bottom: -10px;">
                                <b>5</b>
                            </p>
                            <p class="font-w600 text-white"><b>PURCHASE ORDER</b></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="content row">
        <div class="col-xl-6">
            <div class="block">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-xl-12">
                            <!-- Calendar Container -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Visit Activity</h3>
                    <span id="total-visit"></span>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" onclick="visitReload()" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div id="visit-chart" style="height:335px"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Pipeline</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Bars Chart Container -->
                    <canvas class="js-chartjs-bars"></canvas>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.js"></script>
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script>
            var calendarEl = document.getElementById('calendar')
            var visitChart = document.getElementById('visit-chart')

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'Asia/Jakarta',
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'dayGridMonth',
                aspectRatio: 1.5,
                views: {
                    timeGridWeek: {
                        buttonText: 'week'
                    },
                    timeGridDay: {
                        buttonText: 'day'
                    },
                    listWeek: {
                        buttonText: 'list'
                    }
                },
                events: "{{ route('dashboard.event') }}"
            })

            var chartOptions = {
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.8,
                        align: "center",
                        lineWidth: 0,
                        fillColor: "#3498db",
                    }
                },
                xaxis: {
                    mode: "categories",
                    tickLength: 0
                },
                yaxis: {
                    show: true
                },
                grid: {
                    borderWidth:0, 
                    labelMargin:0, 
                    axisMargin:0, 
                    minBorderMargin:0
                }
            }
            
            calendar.render()

            $.get("{{ route('dashboard.visit') }}", function(response) {
                $('#total-visit').html('Total: '+response.total+' Visit')
                var data = [response.data]
                $.plot(visitChart, data, chartOptions)
            })

            function updateCalendar(events) 
            {
                calendar.destroy()
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'Asia/Jakarta',
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    initialView: 'dayGridMonth',
                    aspectRatio: 1.5,
                    views: {
                        timeGridWeek: {
                            buttonText: 'week'
                        },
                        timeGridDay: {
                            buttonText: 'day'
                        },
                        listWeek: {
                            buttonText: 'list'
                        }
                    },
                    events: events
                })
                calendar.render()
            }

            function updateChart(data) 
            {
                $.plot(visitChart, [data], chartOptions)
            }

            function visitReload()
            {
                $.get("{{ route('dashboard.visit') }}", function(response) {
                    $('#total-visit').html('Total: '+response.total+' Visit')
                    var data = [response.data]
                    $.plot(visitChart, data, chartOptions)
                })
            }
        </script>

        <script>
            var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                forceTLS: true
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', async function(event) {
                try {
                    const response = await fetch("{{ route('dashboard.data') }}");
                    const data = await response.json();
                    updateCalendar(data.event)
                    updateChart(data.visit)
                } catch (error) {
                    console.log(error);
                }
            });
        </script>

    </x-slot>

</x-app-layout>
