<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List Forwarder</b></h4>
            </div>
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full" id="viewTable">
                <!-- <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Forwarder Name</th>
                            <th class="text-center">Telephone</th>
                            <th class="text-center">PIC Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1.</td>
                            <td class="">FM Global</td>
                            <td class="text-center">021-45612377</td>
                            <td class="">Agus Salim Indra</td>
                            <td class="text-center">081345945221</td>
                            <td class="text-center">
                                <a type="button" href="form_add.php" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Report">
                                    <i class="fa fa-file-text-o"></i>
                                </a> |
                                <a type="button" href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Report">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>

    </div>
    <x-slot name="js">

        <script>
            $(document).ready(function() {
                dataTable()
            })

            function dataTable() {
                $('#viewTable').html(``)
                $('#viewTable').html(`<table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px" id="dataTable">
                <thead>
                    <tr>
                    <th class="text-center">No.</th>
                            <th class="text-center">Forwarder Name</th>
                            <th class="text-center">Telephone</th>
                            <th class="text-center">PIC Name</th>
                            <th class="text-center">Phone</th>
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
                        "url": "{{ route('data-master.exim.data') }}",
                        "type": "POST",
                        "data": {
                            "_token": "{{ csrf_token() }}"
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: "8%",
                            className: "text-center"
                        },
                        {
                            data: "forwarder_name",
                            className: "text-center"
                        },
                        {
                            data: "forwarder_telephone",
                            className: "text-center"
                        },
                        {
                            data: "pic_name",
                            className: "text-center"
                        },
                        {
                            data: "pic_phone",
                            className: "text-center"
                        },
                        {
                            data: "uuid",
                            className: "text-center",
                            render: function(data) {
                                return `<a type="button" href="customer/edit/${data}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Customer">
                                    <i class="fa fa-user"></i>
                                </a>
                                <button type="button" onclick="delete_data('${data}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Customer">
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

            function delete_data(id) {
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
                        link.href = 'customer/delete/' + id;
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