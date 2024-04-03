<x-app-layout>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Report</b></h4>
            </div>
            <div class="col-md-6 text-right">
                @if (auth()->user()->hasRole('sales'))
                <a type="button" href="{{ route('crm.visit-report.add') }}" class="btn btn-info min-width-125"><i class="fa fa-plus mr-2"></i>NEW REPORT</a>
                @endif
            </div>
        </div>
        

        <div class="block block-rounded">
            <div class="block-content block-content-full" id="viewTable">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">ID VISIT</th>
                            <th class="text-center">Customer - Company Name</th>
                            <th class="text-center">Date</th>
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
                                    <select class="form-control" name="">
                                        <option value="0" selected disabled>Please select</option>
                                        <option>Loading</option>
                                        <option>Finish</option>
                                        <option>Cancel</option>
                                        <option>Reschedule</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label class="col-12">Note</label>
                            <div class="col-12">
                                <textarea class="form-control" name="" rows="6"></textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-danger" data-dismiss="modal">
                            <i class="fa fa-trash"></i> Close
                        </button>
                        <button type="button" class="btn btn-alt-primary" data-dismiss="modal">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
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
                            <th class="text-center">ID VISIT</th>
                            <th class="text-center">Customer - Company Name</th>
                            @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                            <th class="text-center">Sales</th>
                            @endif
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
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
                    "url": "{{ route('crm.visit-report.data')}}",
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
                        className: "text-center",
                        data: "id"
                    },
                    {
                        className: "text-center",
                        data: "customer"
                    },
                    @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                    {
                        className: "text-center",
                        data: "sales"
                    },
                    @endif
                    {
                        className: "text-center",
                        data: "date"
                    },
                    {
                        data: "status",
                        className: "text-center"
                    },
                    {
                        data: "uuid",
                        className: "text-center",
                        render: function(data) {
                            return `
                                    @if (auth()->user()->hasRole('admin_sales') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                                    <a type="button" href="visit-report/view/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Report">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('sales'))
                                    <a type="button" href="visit-report/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Report">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                    <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Visit Report">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif
                                    `
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
                    link.href = 'visit-report/delete/'+id;
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

