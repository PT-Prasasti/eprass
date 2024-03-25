<x-app-layout>
    <div class="content">
        <form action="{{ route('logistic.delivery_order.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <h4><b>{{ $transactionCode }}</b></h4>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="button" class="btn btn-success mr-5 mb-5" data-toggle="modal" data-target="#modal-slideup">
                        <i class="fa fa-plus mr-5"></i>Select Item
                    </button>
                    <button type="submit" class="btn btn-primary mr-5 mb-5">
                        <i class="fa fa-save mr-5"></i>Save Data
                    </button>
                </div>

                <div class="col-lg-12">
                    <div class="block">
                        <div class="block-content tab-content">
                            <div class="tab-pane active" role="tabpanel">
                                <div class="row" hidden>
                                    <input type="text" class="form-control" name="sales_order_id" value="" readonly sales_order_id>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" class="form-control" value="" readonly name="selected_sales_order">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Delivery Date</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" name="delivery_date" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Terms</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="terms" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Prepare By</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="prepare_name" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Shipping By</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="shipping_name" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Received By</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="received_name" required>
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
                                                        <input type="text" class="form-control" name="po_customer_id" readonly selected_po_customer_number>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Customer Name</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" readonly customer_name>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Customer Address</label>
                                                    <label class="col-lg-1 col-form-label text-right">:</label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control" rows="5" readonly customer_address></textarea>
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
                                <table class="table table-bordered table-vcenter js-datatable" style="font-size:13px" selected_sales_order_items>
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modal-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-slideup" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Select Item</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="col-12" for="po_customer">POC Number :</label>
                            <div class="col-md-12">
                                <select class="form-control" id="po_customer" name="selected_po_customer">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <h5>Product List</h5>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-vcenter" style="font-size:11px" sales_order_selected_items>
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Supplier</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal" set_sales_order>
                        <i class="fa fa-plus"></i> Add Data
                    </button>
                </div>
            </div>
        </div>
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
                                <br/>${row.sourcing_supplier.inquiry_product.description}
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
                                            <br/>${data.sourcing_supplier.inquiry_product.description}
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
