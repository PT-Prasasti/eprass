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
            <div class="col-sm-12">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#btabs-static-home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link review-link" href="#btabs-static-review">Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#btabs-static-doc">Document</a>
                        </li>
                    </ul>
            
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
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
                                {{-- <div class="col-md-4">
                                    <div class="block block-rounded">
                                        <div class="block-content block-content-full bg-pattern">
                                            <h5>Document List</h5>
                                            <ul class="list-group">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div> --}}
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
                        <div class="tab-pane" id="btabs-static-review" role="tabpanel">
                            <div class="table-responsive pb-4" id="product-list">
                                
                                
                                
                            </div>
                        </div>
                        <div class="tab-pane" id="btabs-static-doc" role="tabpanel">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full bg-pattern">
                                    <div class="row">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                        </div>
                                        <div class="block block-rounded mt-3">
                                            <div class="block-content block-content-full bg-pattern">
                                                <h5>Document List</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="product-file-type">
                                                <ul class="list-unstyled" id="document-attachment-list">
                                                    
                                                </ul>
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

        </form>

    </div>

    <x-slot name="js">
        <style>
            .block-file-header {
                background-color: #eee;
                width: 50px;
                height: 50px;
                padding: 10px;
            }

            .block-file-body {
                padding-top:15px;
            }
        </style>
        <script>
            var uuid = ''
            var SOID = ''

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
                    console.log("detail", response)
                    SOID = response.soid;
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
                    getDocuments(response.documents)
                    // reviewurl = '{{ route("transaction.sourcing-item.add", ["id", ":id"]) }}';
                    // reviewurl = reviewurl.replace("id?:id", uuid);
                    // reviewurl = reviewurl + '#btabs-static-review';
                    // $('.review-link').attr("href", reviewurl);
                })
            }

            /* upload and show document start */


            /* triggers */

            $(document).ready(function(){
            
                var docheck_interval = setInterval(() => {
                    if (SOID) {
                        getDocuments();
                        clearInterval(docheck_interval);
                    }
                }, 3000);

            })

            $("#example-file-input-custom").change(function(){
                var fileinfo = $(this)[0].files[0];
                addDocument(fileinfo);
            });

            /* functions */

            function addDocument(fileinfo)
            {
                var formData = new FormData();
                
                formData.append('file', fileinfo);
                formData.append('related_table', 'sourcings');
                formData.append('related_id', SOID);
                formData.append('file_size', fileinfo.size);
                formData.append('file_type', fileinfo.type);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url : "{{ route('helper.docadd') }}",
                    type : 'POST',
                    data : formData,
                    processData: false, 
                    contentType: false,
                    success : function(data, status) {
                        if (status == "success") {
                            getDocuments()
                        }
                    },
                    error : function(data, status) {
                        alert("Upload gagal, pastikan file yang diupload tidak terlalu besar dan tidak corrupt!");
                    }
                });
            }

            function getDocuments(data) 
            {
                $.get("{{ route('helper.doclist') }}?related_table=sourcings&related_id=" + SOID, function(res){
                    
                    baseurl = "{{asset('storage')}}/";
                    html = ``
                    $.each(res.data, function(k,v){

                        filetype = "";
                        sliptstr = v.file_type.split("/");
                        filetype = sliptstr[1];

                        html = html + `
                        <li class="media media-list">
                            <span class="mr-3 align-self-center img-icon primary-rgba text-primary d-block block-file-header">.`+ filetype +`</span>
                            <div class="media-body block-file-body">
                                <h5 class="font-16 mb-1">`+v.filename+`
                                    <span class="float-right">
                                    <a href="`+ baseurl + v.path+`" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                    <a onclick="rmDocument(`+v.id+`)" class="btn btn-sm btn-danger delete-pointer"><i class="fa fa-trash text-white"></i></a>
                                    <span>
                                </h5>
                                <p>`+v.timeago+`, `+(v.file_size/1024).toFixed(2)+` KB</p>
                            </div>
                        </li>
                        `;
                    })
                    setTimeout(() => {
                        $("#document-attachment-list").html(html);
                    }, 200);
                });
            }

            function rmDocument(id)
            {
                response = window.confirm("Apa anda yakin ingin menghapus document ini? Aksi ini tidak bisa di-rollback")
                if (response) {
                    $.post("{{ route('helper.docrem') }}", {
                        _token : "{{ csrf_token() }}",
                        id : id
                    }, function(data){
                        getDocuments()
                    })
                } else {
                    return false;
                }
            }

            /* upload and show document finish */

            function createDocuments(id)
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
                        review_product_select(response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function review_product_select(datas)
            {
                $(datas).each(function(k,v){
                    // console.log('product detail', v)
                    no = k + 1;
                    html = `
                        <div class="carl-long-row carl-long-row-`+k+`" data-rowid="`+k+`" data-prodinq="`+v[5]+`">
                            <div class="item-information">
                                <div class="row m-0">
                                    <div class="col-2">
                                        <small>No.</small>
                                        <p>`+ no +`</p>
                                        <input type="hidden" class="product_inquery_id" name="product_inquery_id[]" value="`+v[5]+`">
                                        <input type="hidden" class="so_id" name="so_id[]" value="`+v[6]+`">
                                    </div>
                                    <div class="col-8">
                                        <small>Item Description</small>
                                        <p class="m-0">Item Name : `+ v[0] +`</p>
                                        <p class="m-0">Material Description : `+ v[1] +`</p>
                                        <p class="m-0">Size : `+ v[2] +`</p>
                                        <p class="m-0">Remark : `+ v[4] +`</p>
                                    </div>
                                    <div class="col-2">
                                        <small>Qty</small>
                                        <p>`+v[3]+`</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="supliyer-information-action supliyer-information-action-`+k+`">
                                <a class="btn btn-primary btn-sm text-white" onclick="newform(`+k+`, `+v[5]+`)">
                                    <i class="fa fa-plus"></i> Add More
                                </a>
                            </div>
                        </div>
                    `;

                    $("#product-list").append(html);

                })

                setTimeout(() => {
                        init() 
                    }, 300);
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
            var IS_READONLY = false;

            
        </script>
        <script src="{{ asset('assets/js/suppliyer/form.js') }}"></script>
        <script src="{{ asset('assets/js/suppliyer/function.js') }}"></script>
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

            .delete-pointer:hover {
                cursor: pointer;
            }
        </style>
    </x-slot>

</x-app-layout>