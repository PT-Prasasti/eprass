<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Visit Schedule</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <a type="button" href="{{ route('crm.visit-schedule.add') }}" class="btn btn-info min-width-125"><i class="fa fa-plus mr-2"></i>NEW VISIT</a>
            </div>
        </div>
        

        <div class="block block-rounded">
            <div class="block-content block-content-full" id="viewTable">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Sales</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Report</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('crm.visit-schedule.status') }}" method="POST" id="status-form">
                        @csrf
                        <input type="hidden" name="uuid">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Status Visit</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                <div class="form-group row">
                                    <label class="col-12">Status Visit</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="status">
                                            <option value="0" selected disabled>Please select</option>
                                            <option>Budgeting</option>
                                            <option>Freed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                <label class="col-12">Note</label>
                                <div class="col-12">
                                    <textarea class="form-control" name="note" rows="6"></textarea>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-alt-danger" data-dismiss="modal">
                                <i class="fa fa-trash"></i> Close
                            </button>
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-check"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <x-slot name="js">

    <script>
        $(document).ready(function() {
            dataTable()
        })

        function dataTable()
        {
            $('#viewTable').html(``)
            $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID Visit</th>
                            <th class="text-center">Customer - Company Name</th>
                            @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                            <th class="text-center">Sales</th>
                            @endif
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Report</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                </table>`)
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "paging": true,
                "order": [
                    [0, "asc"]
                ],
                ajax: {
                    "url": "{{ route('crm.visit-schedule.data') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "8%",
                        className: "text-center"
                    },
                    {
                        data: "id"
                    },
                    {
                        data: "customer"
                    },
                    @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                    {
                        data: "sales"
                    },
                    @endif
                    {
                        data: "date"
                    },
                    {
                        data: "time"
                    },
                    // {
                    //     data: "status",
                    //     className: "text-center",
                    //     render: function(data) {
                    //         var color = ``
                    //         if(data.status == 'LOADING') {
                    //             color = `warning`
                    //         } else if(data.status == 'FINISH') {
                    //             color = `success`
                    //         } else if(data.status == 'CANCEL') {
                    //             color = `danger`
                    //         } else {
                    //             color = `info`
                    //         }
                    //         return `<button type="button" onclick="status_data('${data.uuid}', '${data.status}')" data-toggle="modal" data-target="#modal-large" class="btn btn-sm btn-`+color+`" data-toggle="tooltip" style="width:110px;">
                    //                     ${data.status}
                    //                 </button>`
                    //     }
                    // },
                    {
                        data: "report",
                        className: "text-center",
                        render: function(data) {
                            return `<a type="button" href="visit-report/report/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Add Report">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>`
                        }
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `<a type="button" href="visit-schedule/edit/${data}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Visit">
                                        <i class="fa fa-pencil-square"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Visit">
                                        <i class="fa fa-trash-o"></i>
                                    </button>`
                        }
                    },
                ],
                "language": {
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        }

        function status_data(id, status)
        {
            $('#status-form input[name=uuid]').val(id)
            $('#status-form select[name=status]').find("option").each(function() {
                if($(this).val().toUpperCase() === status) {
                    $(this).prop("selected", true)
                    return false
                }
            })
        }

        function delete_data(id)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    const link = document.createElement('a');
                    link.href = 'visit-schedule/delete/'+id;
                    link.click();
                }
            })
        }
    </script>

    @if (Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}", 'Success')
    </script>    
    @endif

    @if (Session::has('delete'))
    <script>
        toastr.error("{{ Session::get('delete') }}", 'Success')
    </script>    
    @endif

    </x-slot>

</x-app-layout>

