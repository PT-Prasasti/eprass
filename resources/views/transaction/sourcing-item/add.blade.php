<x-app-layout>

    <div class="content">
        <form method="POST" action="{{ route('transaction.sourcing-item.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <h4><b>Sourching Item</b></h4>
            </div>
            <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-success mr-5 mb-5">
                    <i class="fa fa-save mr-5"></i>Save Data
                </button>
            </div>
        </div>

        
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#btabs-static-home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#btabs-static-review">Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#btabs-static-doc">Document</a>
                        </li>
                    </ul>
            
                    <div class="block-content tab-content">
                        <div class="tab-pane" id="btabs-static-home" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="block block-rounded">
                                        <div class="block-content block-content-full bg-pattern">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">SO Number</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <select class="form-control" name="so">
                                                                <option value="0" selected disabled>Please select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Sales Name</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="sales" value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Customer & Company Name</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="customer" value="" readonly>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="company" value="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Phone & Email</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="phone" value="" disabled>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="email" value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Telp</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="company_phone" value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Subject</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="subject" value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Due Date</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="due_date" value="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Grade</label>
                                                        <label class="col-lg-1 col-form-label text-right">:</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="grade" value="" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="block block-rounded">
                                        <div class="block-content block-content-full bg-pattern">
                                            <h5>Document List</h5>
                                            <ul class="list-group">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Product List</h5>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="push">
                                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download Product List</button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <a class="dropdown-item" id="download-excel" href="javascript:void(0)">
                                                                Excel
                                                            </a>
                                                            <a class="dropdown-item" id="download-pdf" href="javascript:void(0)">
                                                                PDF
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-vcenter js-dataTable-simple" style="font-size:13px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">Material Description</th>
                                                <th class="text-center">Size</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Note</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div id="note"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="btabs-static-review" role="tabpanel">
                            <div class="text-right">
                                <div class="push">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <button type="button" class="btn btn-primary">Time</button>
                                        <button type="button" class="btn btn-primary">Price</button>
                                        <button type="button" class="btn btn-primary">Desc</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                @foreach ($datas as $no => $data)
                                <div class="carl-long-row">
                                    <div class="item-information">
                                        {{-- <h5>Item Information</h5> --}}
                                        <div class="row m-0">
                                            <div class="col-2">
                                                <small>No.</small>
                                                <p>{{++$no}}.</p>
                                            </div>
                                            <div class="col-8">
                                                <small>Item Description</small>
                                                <p>
                                                    <b>{{ $data->product_name }}</b></br>
                                                    {!! $data->product_desc !!}
                                                </p>
                                                
                                            </div>
                                            <div class="col-2">
                                                <small>Qty</small>
                                                <p>{{ $data->qty }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="supliyer-information-action">
                                        <a class="btn btn-primary btn-sm text-white" id="add-suppliyer">
                                            <i class="fa fa-plus"></i> Add More
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                               
                                {{-- <table class="table table-striped table-vcenter table-bordered js-dataTable-simple" style="font-size:10px">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No.</th>
                                            <th rowspan="2" class="text-center">Item Desc</th>
                                            <th rowspan="2" class="text-center">Qty</th>
                                            <th rowspan="2" class="text-center">Supplier</th>
                                            <th colspan="4" class="text-center">Input Nama PT 1<hr></th>
                                            <th colspan="4" class="text-center">Input Nama PT 2<hr></th>
                                        </tr>
                                        <tr>                                  
                                            <th class="text-center" style="width: 15%;">Description</th>
                                            <th class="text-center" style="width: 2%;">QTY</th>
                                            <th class="text-center" style="width: 5%;">Unit Price</th>
                                            <th class="text-center">DT</th>
                                            <th class="text-center" style="width: 15%;">Description</th>
                                            <th class="text-center" style="width: 2%;">QTY</th>
                                            <th class="text-center" style="width: 2%;">Unit Price</th>
                                            <th class="text-center">DT</th>
                                            <th class="text-center" style="width: 15%;">Description</th>
                                            <th class="text-center" style="width: 2%;">QTY</th>
                                            <th class="text-center" style="width: 2%;">Unit Price</th>
                                            <th class="text-center">DT</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td style="width:200px">
                                                PRESSURE RELIEF VALVE</br>
                                                Brand : CLA-VAL or equivalent</br>
                                                DN150 TYPE ANGLE 6” Flanged</br>
                                                SIZE : INLET 6” & OUTLET 6”</br>
                                                Pressure Gauge Size ½“ ;300 psi</br>
                                                Material Accessories : Stainless Steel (Brass not approved = corrosive)</br>
                                                Standard : NFPA20</br>
                                                Certificated : Yes</br>
                                            </td>
                                            <td class="text-center">2</td>
                                            <td>
                                                <select class="form-control" name="">
                                                    <option value="0">Select</option>
                                                    <option value="">Supp 1</option>
                                                    <option value="">Supp 2</option>
                                                </select>
                                            </td>
    
                                            <td class="text-center"></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                            <td></td>
    
                                            <td></td>
                                            <td> </td>
                                            <td class="text-right"></td>
                                            <td></td>
    
                                            <td></td>
                                            <td> </td>
                                            <td class="text-right"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                        <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f1" value="">
                                        <label class="custom-control-label" for="f1">Catalog</label>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f2" value="">
                                        <label class="custom-control-label" for="f2">Drawing</label>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f3" value="">
                                        <label class="custom-control-label" for="f3">Folder 1</label>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-f1">
                                        <i class="fa fa-folder" style="color:#2481b3; font-size: 130px;"></i>
                                    </button>
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input class="custom-control-input" type="checkbox" name="" id="f4" value="">
                                        <label class="custom-control-label" for="f4">Folder 2</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </form>

    </div>

    <x-slot name="js">
        <script>
            var uuid = ''

            $(document).ready(function() {
                listSO()
                $('select[name=so]').select2()
                $('select[name=so]').change(function() {
                    getSODetail($(this).val())
                })
            })

            function listSO()
            {
                var url = "{{ route('transaction.sourcing-item.sales-order') }}"
                $.get(url, function(response) {
                    $('select[name=so]').html('')
                    var element = ``
                    element += `<option selected disabled>Please select</option>`
                    $.each(response, function(index, value) {
                        element += `<option value="`+value.uuid+`">`+value.id+`</option>`
                    })
                    $('select[name=so]').append(element)
                })
            }

            function getSODetail(id)
            {
                var url = "{{ route('transaction.sourcing-item.so-detail', ['id' => ':id']) }}"
                url = url.replace(':id', id)
                $.get(url, function(response) {
                    $('input[name=sales]').val(response.sales)
                    $('input[name=customer]').val(response.customer)
                    $('input[name=company]').val(response.company)
                    $('input[name=phone]').val(response.phone)
                    $('input[name=email]').val(response.email)
                    $('input[name=company_phone]').val(response.company_phone)
                    $('input[name=subject]').val(response.subject)
                    $('input[name=due_date]').val(response.due_date)
                    $('input[name=grade]').val(response.grade)
                    $('#note').html(``)
                    $('#note').html(response.note)
                    uuid = ''
                    uuid = response.uuid
                    getPdf(id)
                    getProductList(id)
                })
            }

            function getPdf(id)
            {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.get-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function listItemPdf(status, data)
            {
                if(status == 200) {
                    var element = ``
                    var number = 1
                    var visit = $('select[name=so]').val()
                    $.each(data, function(index, value) {
                        element += `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/inquiry/${uuid}/${value.filename}" target="_blank">`+number+`. `+value.aliases+`</a>
                                        </div>
                                    </li>`
                        number++
                    })
                    $('.list-group').html(``)
                    $('.list-group').html(element)
                }
            }

            function getProductList(id)
            {
                $.ajax({
                    url: "{{ route('transaction.sourcing-item.get-product') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        listItemTable(response.status, response.data)
                        $('#download-excel').attr('href', '/transaction/sales-order/download/product-list/excel/'+response.uuid)
                        $('#download-pdf').attr('href', '/transaction/sales-order/download/product-list/pdf/'+response.uuid)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function listItemTable(status, data)
            {
                if(status == 200) {
                    var element = ``
                    var number = 1
                    $.each(data, function(index, value) {
                        element += `<tr>
                                        <td class="text-center">${number}.</td>
                                        <td>${value[0]}</td>
                                        <td>${value[1]}</td>
                                        <td class="text-center">${value[2]}</td>
                                        <td class="text-center">${value[3]}</td>
                                        <td class="text-center">${value[4]}</td>
                                    </tr>`
                        number++
                    })
                    $('#tbody').html(``)
                    $('#tbody').html(element)
                }
            }

        </script>
        <script>
            var SUPLIYER_OPT = {!! json_encode($suppliyers) !!};
            function randomstring(length = 6) {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let randomString = '';

                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * characters.length);
                    randomString += characters.charAt(randomIndex);
                }

                return randomString;
            }

            function calculate_long_row()
            {
                var currect_long_row = $('.carl-long-row').width();
                var info_width = $(".item-information").width();
                var form_width = $(".supliyer-information").width();
                var jumlah_form = 0;
                $(".supliyer-information").each(function(k,v){
                    jumlah_form++;
                }) 

                setTimeout(() => {
                    total = info_width + ((form_width + 50 ) * jumlah_form) + 100;
                    if (total > currect_long_row) {
                        $(".carl-long-row").css("width", total + "px");
                    }        
                }, 100);
            }

            function localset(key, val)
            {
                json = JSON.stringify(val);
                console.log("local set " + key + " : ", val);
                window.localStorage.setItem(key, json);
            }

            function localget(key)
            {
                obj = window.localStorage.getItem(key);
                json = JSON.parse(obj);
                console.log("local get " + key + " : ", json);
                return json;
            }

            /* init */
            init();
            function init() {
                form = localget("form");
                if (form) {
                    for (var key in form) {
                        if (form.hasOwnProperty(key)) {
                            var obj = form[key];
                            newform(key, obj);
                        }
                    }
                } else {
                    newform();
                }
            }

            /* add new form */
            function newform(rand_id, obj){
                if (!rand_id) {
                    rand_id = randomstring();
                }
                
                var supliyer_options = ``;
                // var selected_supliyer = 
                $(SUPLIYER_OPT).each(function(k,v){
                    if (obj) {
                        if (obj.supliyer_id == v.id) {
                            supliyer_options = supliyer_options + `<option value="`+v.id+`" selected>`+v.company+`</option>`;
                        } else {
                            supliyer_options = supliyer_options + `<option value="`+v.id+`">`+v.company+`</option>`;
                        }
                    } else {
                        supliyer_options = supliyer_options + `<option value="`+v.id+`">`+v.company+`</option>`;
                    }
                });
                var html = `
                    <div class="supliyer-information supliyer-`+ rand_id +`">
                        <div class="row m-0">
                            <div class="col-12">
                                <div>
                                    <small>Supliyer</small>
                                    <select name="supplier_id[]" class="form-control supliyer-form" data-formid="`+rand_id+`">
                                        <option value="">-Select Suppliyer-</option>
                                        `+supliyer_options+`
                                    </select>
                                </div>
                                <div class="">
                                    <small>Item Name</small>
                                    <input type="text" placeholder="Product name" name="product_name[]" class="form-control">
                                    <small>Item Description</small>
                                    <textarea name="product_desc[]" cols="30" rows="10" placeholder="Product Description" class="form-control"></textarea>
                                </div>
                                <div>
                                    <small>Qty</small>
                                    <input type="number" placeholder="Qty" name="product_qty[]" class="form-control">
                                </div>
                                <div>
                                    <small>{{ '@Price' }}</small>
                                    <p>
                                        <input type="number" placeholder="Price" name="product_price[]" class="form-control">
                                    </p>
                                </div>
                                <div class="">
                                    <a class="btn btn-danger btn-sm text-white" onclick="$('.supliyer-`+ rand_id +`').remove()">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                `;
                $(html).insertBefore(".supliyer-information-action");

                setTimeout(() => {
                    calculate_long_row();
                }, 100);
            }
            
            $("#add-suppliyer").click(function(){
                newform();
            })


            /* on select supliyer */
            $(".supliyer-form").change(function(){
                var form_id = $(this).attr("data-formid");
                form = localget("form");
                if (!form) {
                    form = {};
                }
                if (!form[form_id]) {
                    form[form_id] = {};
                }
                form[form_id]["supliyer_id"] = $(this).val();
                localset("form", form);
            });
        </script>
        <style>
            .item-information {
                width:400px;
                min-height: 250px;
                display: inline-block;
            }
        
            .supliyer-information {
                width:400px;
                min-height: 250px;
                display: inline-block;
                background-color: #efefef;
                padding: 10px 5px;
                border-radius: 7px;
                margin-bottom: 5px;
                margin-right: 5px;
            }
        
            .supliyer-information-action {
                width:100px;
                min-height: 250px;
                display: inline-block;
            }

            .carl-long-row {
                min-width: 100%;
            }
        
            small {
                font-weight: bold;
            }
        </style>
    </x-slot>

</x-app-layout>