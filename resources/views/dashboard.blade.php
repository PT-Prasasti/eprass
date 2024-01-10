<x-app-layout>

    <div class="content">
        <div class="row gutters-tiny invisible" data-toggle="appear">
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="{{ route('crm.visit-schedule') }}">
                    <div
                        class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-corporate-light">
                        <div class="shape-inner sign-right">
                            <div style="margin-left:100px">
                                <div class="ribbon-box"><i class="fa fa-calendar text-white"></i></div>
                                @if (auth()->user()->hasRole('sales') ||
                                        auth()->user()->hasRole('superadmin'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b id="visit-count">{{ $visit }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>VISIT</b></p>
                                @endif
                                @if (auth()->user()->hasRole('admin_sales'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b id="visit-count">{{ $inquiry }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>INQUIRY</b></p>
                                @endif
                                @if (auth()->user()->hasRole('hod') || auth()->user()->hasRole('manager'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b id="visit-count">{{ $inquiry }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>INQUIRY</b></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="{{ route('crm.inquiry') }}">
                    <div
                        class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-dusk">
                        <div class="shape-inner sign-right">
                            <div style="margin-left:100px">
                                <div class="ribbon-box"><i class="fa fa-edit text-white"></i></div>
                                @if (auth()->user()->hasRole('sales') ||
                                        auth()->user()->hasRole('superadmin'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b>{{ $inquiry }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>INQUIRY</b></p>
                                @endif
                                @if (auth()->user()->hasRole('admin_sales'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b>{{ $sales }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>SALES ORDER</b></p>
                                @endif
                                @if (auth()->user()->hasRole('hod') || auth()->user()->hasRole('manager'))
                                    <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                        <b>{{ $sales }}</b>
                                    </p>
                                    <p class="font-w600 text-white"><b>SALES ORDER</b></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="#">
                    <div
                        class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-primary">
                        <div class="shape-inner sign-right">
                            <div style="margin-left:100px">
                                <div class="ribbon-box"><i class="fa fa-dollar text-white"></i></div>
                                <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                    <b>{{ $quotationCount }}</b>
                                </p>
                                <p class="font-w600 text-white"><b>QUOTATION</b></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4 col-md-4 col-xl-3">
                <a class="text-center" href="#">
                    <div
                        class="shape-outer sign-right rounded ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-sea">
                        <div class="shape-inner sign-right">
                            <div style="margin-left:100px">
                                <div class="ribbon-box"><i class="fa fa-folder-open text-white"></i></div>
                                <p class="mt-10 text-white" style="font-size: 30px; margin-bottom: -10px;">
                                    <b>{{ $purchaseOrderCustomerCount }}</b>
                                </p>
                                <p class="font-w600 text-white"><b>PURCHASE ORDER</b></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if (auth()->user()->hasRole('hod') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('admin_sales'))
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
                <div class="block block-themed block-mode-loading-inverse block-transparent bg-image w-100"
                    style="background-image: url('assets/bg.png'); background-size: 200%; background-repeat:no-repeat; background-position:center;">
                    <div class="block-header bg-white-op">
                        <div class="d-flex align-items-center">
                            <button type="button" onclick="pipelineChange('month')" id="pipeline-month"
                                class="btn btn-link" disabled>
                                <i class="si si-arrow-left"></i>
                            </button>
                            <h3 class="block-title" id="pipeline-title">Pipeline
                                {{ Carbon\Carbon::now()->format('M Y') }}</h3>
                            <button type="button" onclick="pipelineChange('year')" id="pipeline-year"
                                class="btn btn-link">
                                <i class="si si-arrow-right"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="block-options">
                                <button type="button" class="btn-block-option" onclick="pipelineReload()"
                                    data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="pipeline-chart" style="height: 465px;" data-value="month"></canvas>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="content row">
            <div class="col-xl-12">
                <div class="block block-themed block-mode-loading-inverse block-transparent bg-image w-100"
                    style="background-image: url('assets/bg.png'); background-size: 100%; background-repeat:no-repeat; background-position:center;">
                    <div class="block-header bg-white-op">
                        <div class="d-flex align-items-center">
                            <button type="button" onclick="crmChange('month')" id="crm-month" class="btn btn-link"
                                disabled>
                                <i class="si si-arrow-left"></i>
                            </button>
                            <h3 class="block-title" id="crm-title">Pipeline {{ Carbon\Carbon::now()->format('M Y') }}
                            </h3>
                            <button type="button" onclick="crmChange('year')" id="crm-year" class="btn btn-link">
                                <i class="si si-arrow-right"></i>
                            </button>
                        </div>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" onclick="crmReload()"
                                data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-center">
                        <!-- Bars Chart Container -->
                        <canvas id="crm-chart" style="height: 250px;" data-value="month"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="block">
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-xl-12" style="font-size:10px">
                                <!-- Calendar Container -->
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="block block-themed block-mode-loading-inverse block-transparent bg-image w-100"
                    style="background-image: url('assets/bgp3.png'); background-size: 200%; background-repeat:no-repeat; background-position:center;">
                    <div class="block-header bg-white-op">
                        <div class="d-flex align-items-center">
                            <button type="button" onclick="visitChange('month')" id="visit-month"
                                class="btn btn-link" disabled>
                                <i class="si si-arrow-left"></i>
                            </button>
                            <h3 class="block-title" id="visit-title">Visit Activity
                                {{ Carbon\Carbon::now()->format('M Y') }}</h3>
                            <button type="button" onclick="visitChange('year')" id="visit-year"
                                class="btn btn-link">
                                <i class="si si-arrow-right"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center">
                            <span id="total-visit"></span>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" onclick="visitReload()"
                                    data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="visit-chart" style="height: 465px;" data-value="month"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

    

    @if (auth()->user()->hasRole('admin_sales'))
        <x-slot name="js">
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                let myPipelineChart

                $.get("{{ route('dashboard.data-admin-sales') }}?pipeline=month", function(response) {
                    initCalendar(response.event)
                    initPipelineChart(response.pipeline)
                })

                function initCalendar(events) {
                    var calendarEl = document.getElementById('calendar')
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        height: 526,
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
                        events: events,
                        eventClick: function(info) {
                            var eventUuid = info.event.extendedProps.uuid
                            var reportUrl = "{{ route('transaction.sales-order.edit', ['id' => ':id']) }}"
                            reportUrl = reportUrl.replace(':id', eventUuid)
                            window.location = reportUrl
                        }
                    })
                    calendar.destroy()
                    calendar.render()
                }

                function initPipelineChart(visit) {
                    let delayed;
                    const pipelineChart = document.getElementById('pipeline-chart').getContext('2d')
                    const data = visit
                    const months = data.map(item => item.month)
                    const inquiries = data.map(item => item.inquiry)
                    const sales = data.map(item => item.so)
                    const options = {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                    label: 'Inquiry',
                                    data: inquiries,
                                    backgroundColor: 'rgb(255, 255, 0)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Sales',
                                    data: sales,
                                    backgroundColor: 'rgb(255, 51, 0)',
                                    borderWidth: 1
                                },
                            ]
                        },
                        options: {
                            animation: {
                                onComplete: () => {
                                    delayed = true;
                                },
                                delay: (context) => {
                                    let delay = 0;
                                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                    }
                                    return delay;
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMin: 1, // Set minimum value
                                    suggestedMax: 100, // Set maximum value
                                    ticks: {
                                        stepSize: 25
                                    }
                                }
                            },
                            maintainAspectRatio: false,
                        }
                    }
                    if (myPipelineChart) {
                        myPipelineChart.destroy()
                    }

                    myPipelineChart = new Chart(pipelineChart, options)
                }

                function pipelineChange(value) {
                    if (value == 'month') {
                        var url = "{{ route('dashboard.pipeline-admin-sales-month') }}"
                        document.getElementById('pipeline-month').disabled = true
                        document.getElementById('pipeline-year').disabled = false
                        document.getElementById('pipeline-title').innerHTML = "Pipeline {{ Carbon\Carbon::now()->format('M Y') }}"
                    } else {
                        var url = "{{ route('dashboard.pipeline-admin-sales-year') }}"
                        document.getElementById('pipeline-month').disabled = false
                        document.getElementById('pipeline-year').disabled = true
                        document.getElementById('pipeline-title').innerHTML = "Pipeline {{ Carbon\Carbon::now()->format('Y') }}"
                    }
                    document.getElementById('pipeline-chart').dataset.value = value
                    $.get(url, function(response) {
                        initPipelineChart(response)
                    })
                }

                function pipelineReload() {
                    var pipeline = document.getElementById('pipeline-chart').dataset.value
                    if (pipeline == 'month') {
                        var url = "{{ route('dashboard.pipeline-admin-sales-month') }}"
                    } else {
                        var url = "{{ route('dashboard.pipeline-admin-sales-year') }}"
                    }
                    $.get(url, function(response) {
                        initPipelineChart(response)
                    })
                }
            </script>
            <script>
                var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    forceTLS: true
                });

                var currentEventData = null;
                var currentPipeline = document.getElementById('pipeline-chart').dataset.value;
                var channel = pusher.subscribe('my-channel');
                channel.bind('my-event', async function(event) {
                    try {
                        var newPipeline = document.getElementById('pipeline-chart').dataset.value;
                        if (newPipeline !== currentPipeline) {
                            currentPipeline = newPipeline;

                            const response = await fetch("{{ route('dashboard.data-admin-sales') }}?pipeline=" +
                                currentVisit);
                            const data = await response.json();
                            if (!isEqual(data, currentEventData)) {
                                currentEventData = data;
                                initCalendar(currentEventData.event);
                                initPipelineChart(data.pipeline);
                            }
                        }
                    } catch (error) {
                        console.log(error);
                    }
                });

                function isEqual(obj1, obj2) {
                    return JSON.stringify(obj1) === JSON.stringify(obj2);
                }
            </script>
        </x-slot>
    @else
        <x-slot name="js">
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                let myVisitChart
                let myCrmChart

                $.get("{{ route('dashboard.data') }}?visit=month&crm=month", function(response) {
                    initCalendar(response.event)
                    initVisitChart(response.visit)
                    initCrmChart(response.crm)
                })

                function initCalendar(events) {
                    var calendarEl = document.getElementById('calendar')
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        height: 526,
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
                        events: events,
                        eventClick: function(info) {
                            var eventUuid = info.event.extendedProps.uuid
                            var reportUrl = "{{ route('crm.visit-report.report', ['id' => ':id']) }}"
                            reportUrl = reportUrl.replace(':id', eventUuid)
                            window.location = reportUrl
                        }
                    })
                    calendar.destroy()
                    calendar.render()
                }

                function initVisitChart(visit) {
                    let delayed;
                    const visitChart = document.getElementById('visit-chart').getContext('2d')
                    $('#visit-count').html(visit.total)
                    $('#total-visit').html('Total: ' + visit.total + ' Visit')
                    const data = visit.data
                    const months = data.map(item => item.month)
                    const phoneData = data.map(item => item.phone)
                    const emailData = data.map(item => item.email)
                    const onsiteData = data.map(item => item.onsite)
                    const options = {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                    label: 'Phone',
                                    data: phoneData,
                                    backgroundColor: 'rgb(255, 255, 0)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Email',
                                    data: emailData,
                                    backgroundColor: 'rgb(255, 51, 0)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Onsite',
                                    data: onsiteData,
                                    backgroundColor: 'rgb(51, 51, 77)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            animation: {
                                onComplete: () => {
                                    delayed = true;
                                },
                                delay: (context) => {
                                    let delay = 0;
                                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                    }
                                    return delay;
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMin: 1, // Set minimum value
                                    suggestedMax: 100, // Set maximum value
                                    ticks: {
                                        stepSize: 25
                                    }
                                }
                            },
                            maintainAspectRatio: false,
                        }
                    }
                    if (myVisitChart) {
                        myVisitChart.destroy()
                    }

                    myVisitChart = new Chart(visitChart, options)
                }

                function initCrmChart(data) {
                    let delayed;
                    const crmChart = document.getElementById('crm-chart').getContext('2d')
                    const months = data.map(item => item.month)
                    const visitData = data.map(item => item.visit)
                    const inqData = data.map(item => item.inquiry)
                    const quotationData = data.map(item => item.quotation)
                    const purchaseOrderCustomerData = data.map(item => item.purchase_order_customer)
                    const options = {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                    label: 'Visit',
                                    data: visitData,
                                    backgroundColor: 'rgb(0, 230, 0)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Inquiry',
                                    data: inqData,
                                    backgroundColor: 'rgb(0, 82, 204)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Quotation',
                                    data: quotationData,
                                    backgroundColor: 'rgb(255, 255, 0)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Purchase Order',
                                    data: purchaseOrderCustomerData,
                                    backgroundColor: 'rgb(255, 51, 0)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            animation: {
                                onComplete: () => {
                                    delayed = true;
                                },
                                delay: (context) => {
                                    let delay = 0;
                                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                    }
                                    return delay;
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMin: 1, // Set minimum value
                                    suggestedMax: 100, // Set maximum value
                                    ticks: {
                                        stepSize: 25
                                    }
                                }
                            },
                            maintainAspectRatio: false,
                        }
                    }
                    if (myCrmChart) {
                        myCrmChart.destroy()
                    }

                    myCrmChart = new Chart(crmChart, options)
                }

                function visitChange(value) {
                    if (value == 'month') {
                        var url = "{{ route('dashboard.visit-month') }}"
                        document.getElementById('visit-month').disabled = true
                        document.getElementById('visit-year').disabled = false
                        document.getElementById('visit-title').innerHTML =
                            "Visit Activity {{ Carbon\Carbon::now()->format('M Y') }}"
                    } else {
                        var url = "{{ route('dashboard.visit-year') }}"
                        document.getElementById('visit-month').disabled = false
                        document.getElementById('visit-year').disabled = true
                        document.getElementById('visit-title').innerHTML = "Visit Activity {{ Carbon\Carbon::now()->format('Y') }}"
                    }
                    document.getElementById('visit-chart').dataset.value = value
                    $.get(url, function(response) {
                        initVisitChart(response)
                    })
                }

                function crmChange(value) {
                    if (value == 'month') {
                        var url = "{{ route('dashboard.crm-month') }}"
                        document.getElementById('crm-month').disabled = true
                        document.getElementById('crm-year').disabled = false
                        document.getElementById('crm-title').innerHTML = "CRM Activity {{ Carbon\Carbon::now()->format('M Y') }}"
                    } else {
                        var url = "{{ route('dashboard.crm-year') }}"
                        document.getElementById('crm-month').disabled = false
                        document.getElementById('crm-year').disabled = true
                        document.getElementById('crm-title').innerHTML = "CRM Activity {{ Carbon\Carbon::now()->format('Y') }}"
                    }
                    document.getElementById('crm-chart').dataset.value = value
                    $.get(url, function(response) {
                        initCrmChart(response)
                    })
                }

                function visitReload() {
                    var visit = document.getElementById('visit-chart').dataset.value
                    if (visit == 'month') {
                        var url = "{{ route('dashboard.visit-month') }}"
                    } else {
                        var url = "{{ route('dashboard.visit-year') }}"
                    }
                    $.get(url, function(response) {
                        initVisitChart(response)
                    })
                }

                function crmReload() {
                    var crm = document.getElementById('crm-chart').dataset.value
                    if (crm == 'month') {
                        var url = "{{ route('dashboard.crm-month') }}"
                    } else {
                        var url = "{{ route('dashboard.crm-year') }}"
                    }
                    $.get(url, function(response) {
                        initCrmChart(response)
                    })
                }
            </script>
            <script>
                var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    forceTLS: true
                });

                var currentEventData = null;
                var currentVisit = document.getElementById('visit-chart').dataset.value;
                var channel = pusher.subscribe('my-channel');
                channel.bind('my-event', async function(event) {
                    try {
                        var newVisit = document.getElementById('visit-chart').dataset.value;
                        if (newVisit !== currentVisit) {
                            currentVisit = newVisit;

                            const response = await fetch("{{ route('dashboard.data') }}?visit=" + currentVisit);
                            const data = await response.json();
                            if (!isEqual(data, currentEventData)) {
                                currentEventData = data;
                                initCalendar(currentEventData.event);
                                initVisitChart(data.visit);
                                initCrmChart(data.crm);
                            }
                        }
                    } catch (error) {
                        console.log(error);
                    }
                });

                function isEqual(obj1, obj2) {
                    return JSON.stringify(obj1) === JSON.stringify(obj2);
                }
            </script>
        </x-slot>
    @endif

</x-app-layout>
