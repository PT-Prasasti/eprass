function calculate_long_row(rowid)
{
    setTimeout(() => {
        var currect_long_row = 0;
        var info_width = $(".item-information").width();
        var form_width = 450
        var jumlah_form = 0;
        $(".supliyer-" + rowid).each(function(k,v){
            jumlah_form++;
        }) 
        $('.carl-long-row').each(function(){
            if (currect_long_row < $(this).width())  {
                currect_long_row = $(this).width();
            }
        })

        console.log({
            "currect_long_row" : currect_long_row,
            "info_width" : info_width,
            "form_width" : form_width,
            "jumlah_form" : jumlah_form
        })

        total = info_width + ((form_width + 50 ) * jumlah_form) + 100;
        if (total > currect_long_row) {
            $(".carl-long-row").css("width", total + "px");
        }        
    }, 400);
}

/* init */
function init() {
    
    $(".carl-long-row").each(function(){
        so_id = $(".so_id").val()
        rowid = $(this).attr("data-rowid");
        product_inquiry = $(this).attr("data-prodinq");
        form = localget("form" + so_id);
        console.log("init", form);
        if (form) {
            console.log("form[rowid]", form[rowid]);
            if (form[rowid]) {
                for (var key in form[rowid]) {
                    if (form[rowid].hasOwnProperty(key)) {
                        var obj = form[rowid][key];
                        console.log("init obj", obj);
                        newform(rowid, product_inquiry, key, obj);
                    }
                }
            }
        } else {
            newform(rowid, product_inquiry);
        } 
    });
}

function init_readonly() {
    
    $(".carl-long-row").each(function(){
        so_id = $(".so_id").val()
        rowid = $(this).attr("data-rowid");
        product_inquiry = $(this).attr("data-prodinq");
        // form = localget("form" + so_id);
        // console.log("init", form);

        // get product from the list
        from = SUPPLIYER_PRODUCT[product_inquiry];
        
        $(from).each(function(k,v){
            console.log("form obj", v);
            newform(rowid, product_inquiry, k, v);
        })
        // if (form) {
        //     console.log("form[rowid]", form[rowid]);
        //     if (form[rowid]) {
        //         for (var key in form[rowid]) {
        //             if (form[rowid].hasOwnProperty(key)) {
        //                 var obj = form[rowid][key];
        //                 console.log("init obj", obj);
        //                 newform(rowid, product_inquiry, key, obj);
        //             }
        //         }
        //     }
        // } else {
        //     newform(rowid, product_inquiry);
        // } 
    });
}

/* add new form */
function newform(row_id, product_inquiry, rand_id, obj){
    if (!rand_id) {
        rand_id = randomstring();
    }

    if (IS_READONLY) {
        var html = `
            <div class="supliyer-information supliyer-`+ rand_id +` supliyer-`+row_id+`">
                <div class="row m-0">
                    <div class="col-12">
                        <div class="remove-action" data-rowid="`+row_id+`" data-randid="`+rand_id+`">
                            <input type="radio" name="product_`+product_inquiry+`" value="`+obj.id+`" style="zoom:1.5">
                        </div>
                        <div>
                            <small>Supplier</small>
                            <p class="mb-1">`+obj.company+`</p>
                        </div>
                        <div class="">
                            <small>Item Description</small>
                            <p class="mb-1">`+obj.description+`</p>
                        </div>
                        <div>
                            <small>Qty</small>
                            <p class="mb-1">`+obj.qty+`</p>
                        </div>
                        <div>
                            <small>Currency</small>
                            <p class="mb-1">`+obj.currency.toUpperCase()+`</p>
                        </div>
                        <div>
                            <small>Harga Satuan</small>
                            <p class="mb-1">`+obj.price+`</p>
                        </div>
                        
                        <div>
                            <small>Production Time</small>
                            <p class="mb-1">`+obj.dt+`</p>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        `;
    } else {
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
                obj = {};
            }
    
            console.log("final", obj);
        });

        var html = `
            <div class="supliyer-information supliyer-`+ rand_id +` supliyer-`+row_id+`">
                <div class="row m-0">
                    <div class="col-12">
                        
                        <div>
                            <small>Supplier</small>
                            <select name="supplier_id[`+product_inquiry+`][]" class="form-control supliyer-form" data-formid="`+rand_id+`" onchange="supliyer_change(`+row_id+`, $(this))">
                                <option value="">-Select Suppliyer-</option>
                                `+supliyer_options+`
                            </select>
                        </div>
                        <div class="">
                            <small>Item Description</small>
                            <textarea name="product_desc[`+product_inquiry+`][]" cols="30" rows="4" placeholder="Product Description" class="form-control" onchange="form_change(`+row_id+`,'product_desc', $(this))" data-formid="`+rand_id+`">`+ (obj.product_desc ?? '') +`</textarea>
                        </div>
                        <div>
                            <small>Qty</small>
                            <input type="number" placeholder="Qty" name="product_qty[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_qty', $(this))" data-formid="`+rand_id+`" value="`+ (obj.product_qty ?? '') +`">
                        </div>
                        <div>
                            <small>Currency</small>
                            <select name="product_curentcy[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_curentcy', $(this))" data-formid="`+rand_id+`">
                                <option value="">-Select Curency-</option>
                                <option value="idr" `+ ((obj.product_curentcy ?? '') == 'idr' ? 'selected' : '') +`>IDR</option>
                                <option value="usd" `+ ((obj.product_curentcy ?? '') == 'usd' ? 'selected' : '') +`>USD</option>
                            </select>
                        </div>
                        <div>
                            <small>Harga Satuan</small>
                            <input type="number" placeholder="Price" name="product_price[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'product_price', $(this))" data-formid="`+rand_id+`" value="`+ (obj.product_price ?? '') +`">
                        </div>
                        <div>
                            <small>Remark</small>
                            <input type="text" placeholder="Remark" name="remark[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'remark', $(this))" data-formid="`+rand_id+`" value="`+ (obj.remark ?? '') +`">
                        </div>
                        <div>
                            <small>Production Time</small>
                            <p>
                                <input type="text" placeholder="Production Time" name="production_time[`+product_inquiry+`][]" class="form-control" onchange="form_change(`+row_id+`,'production_time', $(this))" data-formid="`+rand_id+`" value="`+ (obj.production_time ?? '') +`">
                            </p>
                        </div>
                        <div class="remove-action" data-rowid="`+row_id+`" data-randid="`+rand_id+`">
                            <a class="btn btn-danger btn-sm text-white" onclick="removeform(`+row_id+`, '`+rand_id+`')">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        `;
    }
    
    $(html).insertBefore(".supliyer-information-action-" + row_id);

    setTimeout(() => {
        calculate_long_row(row_id);
    }, 200);
}

function supliyer_change(rowid, input)
{
    var so_id = $(".so_id").val()
    var form_id = input.attr("data-formid");
    form = localget("form" + so_id);
    if (!form) {
        form = {};
    }
    if (!form[rowid]) {
        form[rowid] = {}
    }
    if (!form[rowid][form_id]) {
        form[rowid][form_id] = {};
    }
    form[rowid][form_id]["supliyer_id"] = input.val();
    localset("form" + so_id, form);
}

function form_change(rowid, formkey, input)
{
    var so_id = $(".so_id").val()
    var form_id = input.attr("data-formid");
    form = localget("form" + so_id);
    if (!form) {
        form = {};
    }
    if (!form[rowid]) {
        form[rowid] = {}
    }
    if (!form[rowid][form_id]) {
        form[rowid][form_id] = {};
    }
    form[rowid][form_id][formkey] = input.val();
    localset("form" + so_id, form);
}

function removeform(rowid, form_id)
{
    var so_id = $(".so_id").val()
    calculate_long_row(rowid);
    $('.supliyer-' + form_id).remove()

    form = localget("form");
    if (!form) {
        form = {};
    }
    if (!form[rowid]) {
        form[rowid] = {}
    }
    if (!form[rowid][form_id]) {
        form[rowid][form_id] = {};
    }
    
    delete form[rowid][form_id];
    localset("form" + so_id, form);
}