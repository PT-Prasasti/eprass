<x-app-layout>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-primary text-white">
                    <i class="fa fa-save"></i> Save Data
                </a>
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PO Number</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="example-select" name="example-select">
                                                        <option value="0">Please select</option>
                                                        <option value="1">0001/PO/PRASASTI/XI20/23</option>
                                                        <option value="2">0002/PO/PRASASTI/XI20/23</option>
                                                        <option value="3">0003/PO/PRASASTI/XI20/23</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Customer Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="" value="PT. SPV" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Due Date to CS</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="" value="01 Desember 2023" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Subject</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="" value="Test PO" readonly>
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
                                                    <input type="text" class="form-control" name="" value="PT. Indo Jaya Teknik" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Supplier Telephone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="" value="021-451245" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Name</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="" value="Agus Hermawan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PIC Email - Phone</label>
                                                <label class="col-lg-1 col-form-label text-right">:</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="" value="agus@indojt.com" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="" value="081345946704" readonly>
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
                            <table class="table table-bordered table-vcenter js-dataTable-simple" style="font-size:13px">
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
                                <tbody>
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>
                                            Vario 125 <br>
                                            Matic<br>
                                            125 CC<br>
                                            Honda
                                        </td>
                                        <td class="text-center">5</td>
                                        <td class="text-right">Rp 40.000.000</td>
                                        <td class="text-right">Rp 200.000.000,00</td>
                                        <td class="text-center">3 Weeks</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2.</td>
                                        <td colspan="3">Shipping Fee (to Prasasti's Werehous)</td>
                                        <td class="text-right">Rp 500.000</td>
                                        <td class="text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3.</td>
                                        <td colspan="3">Sub Total</td>
                                        <td class="text-right">Rp 200.500.000</td>
                                        <td class="text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4.</td>
                                        <td colspan="3">PPN 11%</td>
                                        <td class="text-right">Rp 22.055.000</td>
                                        <td class="text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5.</td>
                                        <td colspan="3"><b>Grand Total</b></td>
                                        <td class="text-right"><b>Rp 222.555.000</b></td>
                                        <td class="text-right"></td>
                                    </tr>
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
                                                <input type="text" class="form-control" name="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Email</label>
                                                <input type="text" class="form-control" name="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Phone Number</label>
                                                <input type="text" class="form-control" name="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name-column">Mobile Number</label>
                                                <input type="text" class="form-control" name="" required="">
                                            </div>
                                            <div clasa="form-group">
                                                <label for="last-name-column">Pick Up Address</label>
                                                <textarea class="form-control" id="" name="" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-12">Document Pick Up Information :</label>
                                                <div class="col-12">
                                                    <p>1.<a href="#"> Packing List.pdf</a></p>
                                                    <p>2.<a href="#"> Packing List Detail.pdf</a></p>
                                                </div>
                                            </div>
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
                                            <a class="btn btn-info text-white">
                                                <i class="fa fa-plus"></i> Add Forwarder
                                            </a>
                                        </div>
                                        <div class="col-md-4 card" style="background-color: #efefef;">
                                            <div class="supliyer-information supliyer-jmIr70 supliyer-0">
                                                <div class="row m-0">
                                                    <div class="col-12">
                                                        <div>
                                                            <small>Forwarder Name</small>
                                                            <select name="" class="form-control supliyer-form">
                                                                <option value="">-Select Forwarder-</option>
                                                                <option value="3">PT. FM Global</option>
                                                                <option value="4">PT. JNE</option>
                                                                <option value="4">PT. Si Cepat</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <small>Price</small>
                                                            <input type="number" placeholder="0" name="" class="form-control text-right" value="">
                                                        </div>
                                                        <div>
                                                            <small>Track</small>
                                                            <select name="product_curentcy[36][]" class="form-control">
                                                                <option value="">-Select Track-</option>
                                                                <option value="">See Freight</option>
                                                                <option value="">Air Freight</option>
                                                            </select>
                                                        </div>
                                                        <div class="">
                                                            <small>Description</small>
                                                            <textarea name="" cols="30" rows="4" placeholder="Description" class="form-control"></textarea>
                                                        </div>

                                                        <div class="remove-action" data-rowid="0" data-randid="jmIr70">
                                                            <a class="btn btn-danger btn-sm text-white" onclick="removeform(0, 'jmIr70')">
                                                                <i class="fa fa-trash"></i> Remove
                                                            </a>

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
</x-app-layout>