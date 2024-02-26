function calculate_long_row(rowid) {
  setTimeout(() => {
    var currect_long_row = 0;
    var info_width = $('.item-information').width();
    var form_width = 450;
    var jumlah_form = 0;
    $('.forwarder-' + rowid).each(function (k, v) {
      jumlah_form++;
    });
    $('.carl-long-row').each(function () {
      if (currect_long_row < $(this).width()) {
        currect_long_row = $(this).width();
      }
    });

    console.log({
      currect_long_row: currect_long_row,
      info_width: info_width,
      form_width: form_width,
      jumlah_form: jumlah_form,
    });

    total = info_width + (form_width + 50) * jumlah_form + 100;
    if (total > currect_long_row) {
      $('.carl-long-row').css('width', total + 'px');
    }
  }, 400);
}

/* init */
function init() {
  $('.carl-long-row').each(function () {
    so_id = $('.so_id').val();
    rowid = $(this).attr('data-rowid');
    product_inquiry = $(this).attr('data-prodinq');
    form = localget('form' + so_id);
    console.log('init', form);
    if (form) {
      console.log('form[rowid]', form[rowid]);
      if (form[rowid]) {
        for (var key in form[rowid]) {
          if (form[rowid].hasOwnProperty(key)) {
            var obj = form[rowid][key];
            console.log('init obj', obj);
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
  $('.carl-long-row').each(function () {
    so_id = $('.so_id').val();
    rowid = $(this).attr('data-rowid');
    product_inquiry = $(this).attr('data-prodinq');
    // form = localget("form" + so_id);
    // console.log("init", form);

    // get product from the list
    from = FORWARDER_PRODUCT[product_inquiry];

    $(from).each(function (k, v) {
      console.log('form obj', v);
      newform(rowid, product_inquiry, k, v);
    });
  });
}

/* add new form */
function newform(row_id, product_inquiry, rand_id, obj) {
  if (!rand_id) {
    rand_id = randomstring();
  }

  console.log('obj cuy', obj)

  if (IS_READONLY) {
    var html =
      `
            <div class="forwarder-information forwarder-` +
      rand_id +
      ` forwarder-` +
      row_id +
      `">
                <div class="row m-0">
                    <div class="col-12">
                        <div class="remove-action" data-rowid="` +
      row_id +
      `" data-randid="` +
      rand_id +
      `">
                            <input type="radio" name="forwarder` +
      obj.forwarder_id +
      `" value="` +
      obj.id +
      `" style="zoom:1.5">
                        </div>
                        <div>
                            <small>Forwarder Name</small>
                            <p class="mb-1">` +
      obj.forwarder_name +
      `</p>
                        </div>
                        <div class="">
                            <small>Price</small>
                            <p class="mb-1">` +
      obj.price +
      `</p>
                        </div>
                        <div>
                            <small>Track</small>
                            <p class="mb-1">` +
      obj.track +
      `</p>
                        </div>
                        <div>
                            <small>Description</small>
                            <p class="mb-1">` +
      obj.description.toUpperCase() +
      `</p>
                        </div>                        
                    </div>
                </div>
            </div>
        `;
  } else {
    var forwarder_options = ``;
    // var selected_supliyer =
    $(FORWARDER_OPT).each(function (k, v) {
      if (obj) {
        if (obj.forwarder_id == v.id) {
          forwarder_options =
            forwarder_options +
            `<option value="` +
            v.id +
            `" selected>` +
            v.forwarder_name +
            `</option>`;
        } else {
          forwarder_options =
            forwarder_options +
            `<option value="` +
            v.id +
            `">` +
            v.forwarder_name +
            `</option>`;
        }
      } else {
        forwarder_options =
          forwarder_options +
          `<option value="` +
          v.id +
          `">` +
          v.forwarder_name +
          `</option>`;
        obj = {};
      }

      console.log('final', obj);
    });

    var html =
      `
            <div class="forwarder-information forwarder-` +
      rand_id +
      ` forwarder-` +
      row_id +
      `">
                <div class="row m-0">
                    <div class="col-12">
                        
                        <div>
                            <small>Forwarder Name</small>
                            <select name="forwarder_id[` +
      product_inquiry +
      `][]" class="form-control forwarder-form" data-formid="` +
      rand_id +
      `" onchange="forwarder_change(` +
      row_id +
      `, $(this))">
                                <option value="">-Select Forwarder-</option>
                                ` +
      forwarder_options +
      `
                            </select>
                        </div>
                        <div class="">
                            <small>Price</small>
                            <input type="text" placeholder="Price" name="price[` +
      product_inquiry +
      `][]" class="form-control le-price" onchange="form_change(` +
      row_id +
      `,'product_price', $(this))" data-formid="` +
      rand_id +
      `" value="` +
      (obj.product_price ?? '') +
      `">
                        </div>
                        <div>
                        <small>Track</small>
                        <select name="track[` +
      product_inquiry +
      `][]" class="form-control" required>
                                <option value="" selected disabled>-Select Track-</option>
                                <option value="Sea Freight">Sea Freight</option>
                                <option value="Air Freight">Air Freight</option>
                            </select>
                        </div>
                        <div>
                            <small>Description</small>
                            <textarea name="description[` +
      product_inquiry +
      `][]" cols="30" rows="4" placeholder="Product Description" class="form-control" onchange="form_change(` +
      row_id +
      `,'product_desc', $(this))" data-formid="` +
      rand_id +
      `">` +
      (obj.product_desc ?? '') +
      `</textarea>
                        </div>
                        <div class="remove-action" data-rowid="` +
      row_id +
      `" data-randid="` +
      rand_id +
      `">
                            <a class="btn btn-danger btn-sm text-white" onclick="removeform(` +
      row_id +
      `, '` +
      rand_id +
      `')">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        `;
  }

  $(html).insertBefore('.forwarder-information-action-' + row_id);

  setTimeout(() => {
    calculate_long_row(row_id);
  }, 200);
}

setInterval(() => {
  $('.le-price').each(function () {
    price = $(this).val();
    price = toRupiah(price);
    $(this).val(price);
  });
}, 1000);

function forwarder_change(rowid, input) {
  var so_id = $('.so_id').val();
  var form_id = input.attr('data-formid');
  form = localget('form' + so_id);
  if (!form) {
    form = {};
  }
  if (!form[rowid]) {
    form[rowid] = {};
  }
  if (!form[rowid][form_id]) {
    form[rowid][form_id] = {};
  }
  form[rowid][form_id]['forwarder_id'] = input.val();
  localset('form' + so_id, form);
}

function form_change(rowid, formkey, input) {
  var so_id = $('.so_id').val();
  var form_id = input.attr('data-formid');
  form = localget('form' + so_id);
  if (!form) {
    form = {};
  }
  if (!form[rowid]) {
    form[rowid] = {};
  }
  if (!form[rowid][form_id]) {
    form[rowid][form_id] = {};
  }
  form[rowid][form_id][formkey] = input.val();
  localset('form' + so_id, form);
}

function removeform(rowid, form_id) {
  var so_id = $('.so_id').val();
  calculate_long_row(rowid);
  $('.forwarder-' + form_id).remove();

  form = localget('form');
  if (!form) {
    form = {};
  }
  if (!form[rowid]) {
    form[rowid] = {};
  }
  if (!form[rowid][form_id]) {
    form[rowid][form_id] = {};
  }

  delete form[rowid][form_id];
  localset('form' + so_id, form);
}
