<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h4><b>List PO Tracking</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <div class="push">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Waiting
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    SO Ready
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Waiting Approval
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Done
                                </a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary">Supplier</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter js-dataTable-simple" style="font-size:13px">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">DD to Customer</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-ellipsis-h"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1.</td>
                            <td class="text-center">0002/PO/PRASASTI/X/2023</td>
                            <td class="">PT. SPV</td>
                            <td class="">-</td>
                            <td class="text-center">01 Desember 2023</td>
                            <td class="text-center"><span class="badge badge-danger">Waiting for Approvale</span></td>
                            <td class="text-center">
                                <a type="button" href="form_view.php" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Report">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>