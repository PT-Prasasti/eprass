<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-primary text-white" id="save-tracking">
                    <i class="fa fa-save"></i> Save Data
                </button>
            </div>

            <div class="col-lg-12">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#btabs-static-home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pickup">Pick Up Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#document">Document</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#forwarder">Selected Forwarder</a>
                        </li>
                    </ul>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                            <div class="row">
                                <input type="hidden" id="idPoSuplier" readonly>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PO Number</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="selected_po_supplier" name="selected_po_supplier">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Customer Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="customer_name" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Due Date to CS</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="due_date" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Subject</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="subject" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Supplier Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="supplier_name" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Supplier Telephone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="supplier_telephone" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="pic_name" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Email - Phone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="pic_email" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="pic_phone" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Product List :</h5>
                                </div>
                            </div>
                            <table class="table table-bordered table-vcenter " style="font-size:13px" sales_order_selected_items>
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Delevery Time</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="pickup" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="last-name-column">Name</label>
                                                <input type="text" class="form-control" id="name" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Email</label>
                                                <input type="text" class="form-control" id="email" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" required="">
                                            </div>
                                            <div clasa="form-group">
                                                <label for="last-name-column">Pick Up Address</label>
                                                <textarea class="form-control" id="pickup_adress" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <div class="form-group row">
                                                <label class="col-12">Document Pick Up Information :</label>
                                                <!-- <div class="col-12">
                                                    <p>1.<a href="#"> Packing List.pdf</a></p>
                                                    <p>2.<a href="#"> Packing List Detail.pdf</a></p>
                                                </div> -->
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="document" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f1">INQUIRY</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f2">SALES ORDER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f3">SOURCING ITEM</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PO CUSTOMER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PO SUPPLIER</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <label class="custom-control-label" for="f4">PURCHASING DOCUMENT</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="forwarder" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="row">
                                        <div class="col-md-12 mb-2" style="margin-left: -15px">
                                            <button class="btn btn-info text-white" id="btn-add-row-mg">
                                                <i class="fa fa-plus"></i> Add Forwarder
                                            </button>
                                        </div>
                                        <div class="col-md-4 card row-mg" style="background-color: #efefef;" id="row-mg">
                                            <div class="supliyer-information supliyer-jmIr70 supliyer-0">
                                                <div class="row m-0">
                                                    <div class="col-12">
                                                        <div>
                                                            <small>Forwarder Name</small>
                                                            <select name="" class="form-control supliyer-form row-input forwarder_name" id="forwarder_name" name="forwarder_id[]">
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <small>Price</small>
                                                            <input type="number" placeholder="0" name="price[]" class="form-control text-right row-input" value="">
                                                        </div>
                                                        <div>
                                                            <small>Track</small>
                                                            <select name="track[]" class="form-control row-input">
                                                                <option value="">-Select Track-</option>
                                                                <option value="See Freight">See Freight</option>
                                                                <option value="Air Freigh">Air Freight</option>
                                                            </select>
                                                        </div>
                                                        <div class="">
                                                            <small>Description</small>
                                                            <textarea name="description[]" cols="30" rows="4" placeholder="Description" class="form-control row-input"></textarea>
                                                        </div>

                                                        <div class="remove-action" data-rowid="0" data-randid="jmIr70">
                                                            <button class="btn btn-danger btn-sm text-white" id="btn-remove-mg">
                                                                <i class="fa fa-trash"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="js">
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const handleCurrencyFormat = (value) => {
                return value.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 2,
                });
            }

            function handleRupiahFormat(number, prefix) {
                let numberToString = number.toString().replace(/[^,\d]/g, ''),
                    split = numberToString.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1].slice(0, 2) : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }

            const handleSetNumber = (number) => {
                let numberToString = number.toString().replace(/[^,\d]/g, '').replace(/,/g, '.');

                return Number(numberToString) ? Number(numberToString) : 0;
            }

            $(`.forwarder_name`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('po-tracking.search.forwarder') }}`,
                    dataType: 'json',
                    language: "id",
                    type: 'GET',
                    delay: 450,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(res) {
                        console.log(res);
                        return {
                            results: $.map(res, function(object) {
                                return {
                                    id: object.id,
                                    text: object.forwarder_name,
                                    data: object,
                                }
                            })
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });

            $(`[name="selected_po_supplier"]`).select2({
                placeholder: "Select from the list",
                width: '100%',
                ajax: {
                    url: `{{ route('po-tracking.search.po_supplier') }}`,
                    dataType: 'json',
                    language: "id",
                    type: 'GET',
                    delay: 450,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(res) {
                        return {
                            results: $.map(res, function(object) {
                                return {
                                    id: object.id,
                                    text: object.sales_order.quotations[0].purchase_order_customer.kode_khusus,
                                    data: object,
                                }
                            })
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });

            $(document).on('select2:selecting', `[name="selected_po_supplier"]`, function(e) {
                const data = e.params.args.data.data;
                handleSetSalesOrder(data);
            });


            $(document).on('click', '#btn-add-row-mg', function() {
                // Clone baris terakhir


                $('.forwarder_name').select2("destroy");


                var $lastRow = $('.row-mg:last');
                var $newRow = $lastRow.clone();

                // Kosongkan nilai input pada baris yang di-clone
                $newRow.find('input').val('');
                $newRow.find('button').removeAttr('disabled');

                // Tambahkan baris baru ke dalam tabel
                $lastRow.after($newRow);
                // $('.row-mg:last').find("select").remove();

                $('.forwarder_name:last').val('');
                $(`.forwarder_name`).select2({
                    placeholder: "Select from the list",
                    width: '100%',
                    ajax: {
                        url: `{{ route('po-tracking.search.forwarder') }}`,
                        dataType: 'json',
                        language: "id",
                        type: 'GET',
                        delay: 450,
                        data: function(params) {
                            return {
                                term: params.term
                            };
                        },
                        processResults: function(res) {
                            console.log(res);
                            return {
                                results: $.map(res, function(object) {
                                    return {
                                        id: object.id,
                                        text: object.forwarder_name,
                                        data: object,
                                    }
                                })
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                });

            });

            $(document).on('click', '#btn-remove-mg', function() {
                // Hapus baris yang ditekan tombol 
                $(this).closest('#row-mg').remove();
            });

            $(document).on('click', '#save-tracking', function(e) {
                e.preventDefault();
                let datas = {};
                // Hapus baris yang ditekan tombol 

                var forwarderItem = [];
                $('.row-input').each(function(index) {
                    var input_name = $(this).attr('name');
                    var input_value = $(this).val();
                    var input_index = Math.floor(index / 4); // Membagi setiap 5 input menjadi satu objek pada array
                    if (index % 4 == 0) {
                        console.log(forwarderItem);
                        forwarderItem[input_index] = {
                            forwarder_id: input_value
                        };
                    } else if (index % 4 == 1) {
                        forwarderItem[input_index].price = input_value;
                    } else if (index % 4 == 2) {
                        forwarderItem[input_index].track = input_value;
                    } else if (index % 4 == 3) {
                        forwarderItem[input_index].description = input_value;
                    }
                });

                let po_suplier_id = $('#idPoSuplier').val();

                datas.details = forwarderItem;
                datas.po_suplier_id = po_suplier_id;

                $.ajax({
                    url: '{{url("po-tracking/store")}}',
                    type: "POST",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",

                    success: function(response) {
                        console.log('ok');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: ' You clicked the button!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                });
            });


            const handleSetSalesOrder = (data) => {
                listItemTable(data);
                $('#customer_name').val(data.sales_order.inquiry.visit.customer.name);
                $('#due_date').val(data.sales_order.inquiry.due_date);
                $('#subject').val(data.sales_order.inquiry.subject);
                $('#supplier_name').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.company);
                $('#supplier_telephone').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.company_phone);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone_number').val(data.phone_number);
                $('#mobile_number').val(data.mobile_number);
                $('#pickup_adress').val(data.pickup_adress);
                $('#idPoSuplier').val(data.id);
                $('#pic_name').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_representation);
                $('#pic_email').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_email);
                $('#pic_phone').val(data.sales_order.sourcing.selected_sourcing_suppliers[0].supplier.sales_number);
            }


            function listItemTable(data) {
                $("#product-list").html('');
                let datas = data.sales_order.sourcing.selected_sourcing_suppliers;
                if (datas) {
                    var element = ``
                    var number = 1
                    $.each(datas, function(index, value) {
                        element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td>${datas[index].sourcing_supplier.item_name}<br>
                                        ${datas[index].sourcing_supplier.description}<br>
                                        ${datas[index].sourcing_supplier.inquiry_product.size}<br>
                                        ${datas[index].sourcing_supplier.inquiry_product.remark}<br>
                                        </td>
                                        <td class="text-center">${datas[index].sourcing_supplier.qty}</td>
                                        <td class="text-center">${datas[index].sourcing_supplier.unitprice}</td>
                                        <td class="text-center">${datas[index].sourcing_supplier.qty*datas[index].sourcing_supplier.unitprice}</td>
                                        <td class="text-center">${datas[index].sourcing_supplier.dt}</td>
                                    </tr>`
                        number++
                    });

                    $("#product-list").append(element);
                }
            }
        </script>
    </x-slot>
</x-app-layout>