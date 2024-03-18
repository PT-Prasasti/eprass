<x-app-layout>
    <div class="content">
        <form action="{{ route('logistic.delivery_order.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <h4><b>{{ $do->transaction_code }}</b></h4>
                </div>
                <div class="col-lg-6 text-right">
                    <a type="button" href="{{ route('logistic.delivery_order.print', $do->id) }}" target="_blank" class="btn btn-warning mr-5 mb-5 text-white">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>

                <div class="col-lg-12">
                    <div class="block">
                        <div class="block-content tab-content">
                            <div class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" class="form-control" value="" readonly name="selected_sales_order">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Delivery Date</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" name="delivery_date" value="{{ $do->delivery_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Terms</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="terms" value="{{ $do->terms }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PO Number</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="po_customer_id" readonly value="{{ $do->po_customer_id }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Customer Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" readonly value="{{ $do->poc->quotation->sales_order->inquiry->visit->customer->name }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Customer Address</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control" rows="5" readonly>{{ $do->poc->quotation->sales_order->inquiry->visit->customer->address }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Product List</h5>
                                    </div>
                                </div>
                                <table class="table table-bordered table-vcenter js-datatable" style="font-size:13px">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">No.</th>
                                            <th class="">Item Name</th>
                                            <th class="text-center" width="10%">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($do->delivery_schedule_items as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="">
                                                {{ $item->selected_sourcing_supplier->sourcing_supplier->item_name }}
                                                <br>{{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->description }}
                                                <br>{{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->size }}
                                                <br>{{ $item->selected_sourcing_supplier->sourcing_supplier->inquiry_product->remark }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->selected_sourcing_supplier->sourcing_supplier->qty }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="js">
        <script>
            $(`[name="selected_po_customer"]`).select2({
                placeholder: "Select from the list"
                , width: '100%'
                , ajax: {
                    url: `{{ route('logistic.delivery_order.search_po_customer') }}`
                    , dataType: 'json'
                    , language: "id"
                    , type: 'GET'
                    , delay: 450
                    , data: function(params) {
                        return {
                            term: params.term
                        };
                    }
                    , processResults: function(res) {
                        console.log(res);
                        return {
                            results: $.map(res, function(object) {
                                return {
                                    id: object.kode_khusus
                                    , text: object.kode_khusus
                                    , data: object,
                                    // disabled: object.status != 'Done' || object.purchase_order_customer,
                                }
                            })
                        };
                    }
                    , cache: true
                }
                , escapeMarkup: function(markup) {
                    return markup;
                }
            , });

            $(document).on('select2:selecting', `[name="selected_po_customer"]`, function(e) {
                const data = e.params.args.data.data;
                // console.log(data);
                handleSetSalesOrder(data);
            });

            const salesOrderSelectedItemTable = $('[sales_order_selected_items]').DataTable({
                order: [
                    [1, 'asc']
                ]
                , columns: [{
                        searchable: false
                        , orderable: false
                        , className: 'align-top text-center'
                        , render: function(data, type, row, meta) {
                            console.log(row);
                            return meta.row + 1;
                        }
                    }
                    , {
                        data: 'sourcing_supplier.company'
                        , className: 'align-top'
                    , }
                    , {
                        data: 'item_name'
                        , className: 'align-top'
                        , render: function(data, type, row, meta) {
                            return `
                            ${row.sourcing_supplier.item_name}
                                <br/>${row.sourcing_supplier.description}
                                <br/>${row.sourcing_supplier.inquiry_product.size}
                                <br/>${row.sourcing_supplier.inquiry_product.remark}
                            `;
                        }
                    , }
                    , {
                        data: 'sourcing_supplier.qty'
                        , className: 'align-top text-right'
                    , }
                    , {
                        searchable: false
                        , orderable: false
                        , className: 'align-top text-center'
                        , render: function(data, type, row, meta) {
                            return `
                            <label class="css-control css-control-info css-checkbox">
                                <input type="checkbox" name="sales_order_selected_item[${row.uuid}]" class="css-control-input">
                                <span class="css-control-indicator"></span>
                            </label>
                            `;
                        }
                    }
                , ]
                , fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                }
                , fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.id);
                }
            , });

            const handleSetSalesOrder = (data) => {
                salesOrderSelectedItemTable.clear().draw();
                salesOrderSelectedItemTable.rows.add(data.quotation.sales_order.sourcing.selected_sourcing_suppliers ?? []).draw(true);

                $(`[name="selected_sales_order"]`).val(data.quotation.sales_order.id);
                $(`[selected_po_customer_number]`).val(data.kode_khusus);
                $(`[customer_name]`).val(data.quotation.sales_order.inquiry.visit.customer.name);
                $(`[customer_address]`).val(data.quotation.sales_order.inquiry.visit.customer.address);
            }

            $(document).on('click', `[set_sales_order]`, function() {
                var selectedSalesOrderItemsElement = $(`[selected_sales_order_items] > tbody`);
                if ($(`[sales_order_id]`).val() !== $(`[name="selected_sales_order"]`).val()) {
                    selectedSalesOrderItemsElement.html('');
                    selectedSalesOrderItemsElement = $(`[selected_sales_order_items] > tbody`);
                }

                $(`[sales_order_id]`).val($(`[name="selected_sales_order"]`).val());
                console.log($(`[sales_order_id]`).val());
                $(`[sales_order_number]`).val($(`[selected_sales_order_number]`).val());
                $(`[sales_order_subject]`).val($(`[selected_sales_order_subject]`).val());

                var selectedSalesOrderItems = [];
                if (selectedSalesOrderItemsElement.children().length > 0) {
                    selectedSalesOrderItemsElement.children().map((index, row) => {
                        selectedSalesOrderItems.push($(row).data('id'));
                    });
                }

                if (salesOrderSelectedItemTable.rows().data().length > 0) {
                    var iteration = selectedSalesOrderItems.length;
                    salesOrderSelectedItemTable.rows().data().map((data, index) => {
                        if ($(`[name="sales_order_selected_item[${data.uuid}]"]`).is(":checked")) {
                            if (!selectedSalesOrderItems.includes(data.uuid)) {
                                selectedSalesOrderItemsElement.append(`
                                    <tr data-id="${data.uuid}">
                                        <td class="align-top text-center pt-3" iteration style="width: 50px;">
                                            <p>${iteration+=1}</p>
                                        </td>
                                        <td class="align-top pt-3 pb-3"  style="min-width: 250px;">
                                           ${data.sourcing_supplier.item_name}
                                            <br/>${data.sourcing_supplier.description}
                                            <br/>${data.sourcing_supplier.inquiry_product.size}
                                            <br/>${data.sourcing_supplier.inquiry_product.remark}
                                        </td>
                                        <td class="align-top pt-3 pr-4 text-center" style="width: 100px;">
                                            ${data.sourcing_supplier.qty}
                                            <input type="hidden" class="form-control text-right" name="item[${data.uuid}][quantity]" value="${data.sourcing_supplier.qty}" autocomplete="one-time-code" required="" number_format>
                                        </td>
                                    </tr>
                                `);
                            }
                        } else {
                            $(`[data-id="${data.uuid}"]`).remove()
                        }
                    });
                }

                $(`[iteration]`).map((index, row) => {
                    $(row).html(index + 1)
                });
            });

        </script>
    </x-slot>
</x-app-layout>
