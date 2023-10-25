<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('transaction.sourcing-item.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <h4><b>Selected Suppliyer</b></h4>
            </div>
            
        </div>

        
        <div class="row">
            
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="5" class="bg-secondary text-white">
                                        Inquery Description
                                    </th>
                                    <th colspan="7" class="bg-secondary text-white">
                                        Selected Supliyer Product
                                    </th>
                                </tr>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Material Description</th>
                                    <th>Size</th>
                                    <th>Remark</th>
                                    <th>Qrt</th>
                                    <th>Suppliyer Name</th>
                                    <th>Item Description</th>
                                    <th>Qty</th>
                                    <th>Curency</th>
                                    <th>Unit Price</th>
                                    <th>Production Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($res as $v)
                                <tr>
                                    <td>{{ $v['inquery_item_name'] }} </td>
                                    <td>{{ $v['inquery_material_description'] }} </td>
                                    <td>{{ $v['inquery_size'] }} </td>
                                    <td>{{ $v['inquery_remark'] }} </td>
                                    <td>{{ $v['inquery_qty'] }} </td>
                                    <td>{{ $v['suppliyer_name'] }} </td>
                                    <td>{{ $v['suppliyer_item_desc'] }} </td>
                                    <td>{{ $v['suppliyer_qty'] }} </td>
                                    <td>{{ $v['suppliyer_currency'] }} </td>
                                    <td>{{ $v['suppliyer_qty'] }} </td>
                                    <td>{{ $v['suppliyer_unit_price'] }} </td>
                                    <td>{{ $v['suppliyer_production_time'] }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </form>

    </div>

    <x-slot name="js">
        
    </x-slot>

</x-app-layout>