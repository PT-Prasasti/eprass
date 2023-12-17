<?php

use App\Http\Controllers\ApprovalPaymentRequestController;
use App\Http\Controllers\ApprovalPoSupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Crm\InquiryController;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Crm\VisitReportController;
use App\Http\Controllers\DataMaster\SalesController;
use App\Http\Controllers\Crm\VisitScheduleController;
use App\Http\Controllers\DataMaster\CustomerController;
use App\Http\Controllers\DataMaster\SupplierController;
use App\Http\Controllers\EximController;
use App\Http\Controllers\Helper\NotificationController;
use App\Http\Controllers\ListPaymentController;
use App\Http\Controllers\PaymentRequest\PaymentRequestController;
use App\Http\Controllers\PoTrackingController;
use App\Http\Controllers\PurchaseOrderCustomer\PurchaseOrderCustomerController;
use App\Http\Controllers\PurchaseOrderCustomerSalesController;
use App\Http\Controllers\PurchaseOrderSupplier\PurchaseOrderSupplierController;
use App\Http\Controllers\Transaction\QuotationController;
use App\Http\Controllers\Transaction\SalesOrderController;
use App\Http\Controllers\Transaction\SourcingItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// route dashboard
Route::prefix('/dashboard')->name('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('/event', [DashboardController::class, 'event'])->name('.event');
    Route::get('/visit/month', [DashboardController::class, 'visit_month'])->name('.visit-month');
    Route::get('/visit/year', [DashboardController::class, 'visit_year'])->name('.visit-year');
    Route::get('/crm/month', [DashboardController::class, 'crm_month'])->name('.crm-month');
    Route::get('/crm/year', [DashboardController::class, 'crm_year'])->name('.crm-year');
    Route::get('/data', [DashboardController::class, 'data'])->name('.data');
    Route::get('/data/admin-sales', [DashboardController::class, 'data_admin_sales'])->name('.data-admin-sales');
    Route::get('/pipeline/admin-sales/month', [DashboardController::class, 'pipeline_month_admin_sales'])->name('.pipeline-admin-sales-month');
    Route::get('/pipeline/admin-sales/year', [DashboardController::class, 'pipeline_year_admin_sales'])->name('.pipeline-admin-sales-year');

    Route::post('/visit-schedule', [DashboardController::class, 'visit_schedule'])->name('.visit-schedule');
    Route::post('/top-customer', [DashboardController::class, 'top_customer'])->name('.top-customer');
});

// route notification
Route::prefix('/notification')->name('notification')->group(function () {
    Route::get('/', [NotificationController::class, 'all_notification']);
    Route::get('/mark-as-read', [NotificationController::class, 'mark_as_read'])->name('.mark-as-read');
    Route::get('{id}/mark-as-read', [NotificationController::class, 'read_notification'])->name('.read-notification');
    Route::get('get-notification', [NotificationController::class, 'get_notification'])->name('.get-notification');
});

// route file 
Route::prefix('/file')->name('file')->group(function () {
    Route::get('/show/{folder1}/{folder2}/{file}', [FilesController::class, 'show'])->name('.show');
});

Route::prefix('/po-tracking')->name('po-tracking')->group(function () {
    Route::get('/add', [PoTrackingController::class, 'add'])->name('.add');
    Route::post('/store', [PoTrackingController::class, 'add'])->name('.store');
    Route::get('/search/po_supplier', [PoTrackingController::class, 'search_po_supplier'])->name('.search.po_supplier');
    Route::get('/search/forwarder', [PoTrackingController::class, 'search_forwarder'])->name('.search.forwarder');
    Route::get('/', [PoTrackingController::class, 'index']);
});

// route data master
Route::prefix('/data-master')->name('data-master')->group(function () {

    // route data master customer
    Route::prefix('/customer')->name('.customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/add', [CustomerController::class, 'add'])->name('.add');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('.edit');
        Route::get('/profile/{id}', [CustomerController::class, 'profile'])->name('.profile');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('.delete');

        Route::post('/data', [CustomerController::class, 'data'])->name('.data');
        Route::post('/store', [CustomerController::class, 'store'])->name('.store');
        Route::post('/edit', [CustomerController::class, 'store_edit'])->name('.store-edit');
    });
    Route::prefix('/exim')->name('.exim')->group(function () {
        Route::get('/', [EximController::class, 'index']);
        Route::get('/add', [EximController::class, 'add'])->name('.add');
        Route::get('/edit/{id}', [EximController::class, 'edit'])->name('.edit');
        Route::get('/profile/{id}', [EximController::class, 'profile'])->name('.profile');
        Route::get('/delete/{id}', [EximController::class, 'delete'])->name('.delete');

        Route::post('/data', [EximController::class, 'data'])->name('.data');
        Route::post('/store', [EximController::class, 'store'])->name('.store');
        Route::post('/edit', [EximController::class, 'store_edit'])->name('.store-edit');
    });

    // route data master supplier
    Route::prefix('/supplier')->name('.supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/add', [SupplierController::class, 'add'])->name('.add');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('.edit');
        Route::get('/delete/{id}', [SupplierController::class, 'delete'])->name('.delete');

        Route::post('/data', [SupplierController::class, 'data'])->name('.data');
        Route::post('/store', [SupplierController::class, 'store'])->name('.store');
        Route::post('/edit', [SupplierController::class, 'store_edit'])->name('.store-edit');
    });

    // route data master sales
    Route::prefix('/sales')->name('.sales')->group(function () {
        Route::get('/', [SalesController::class, 'index']);
        Route::get('/add', [SalesController::class, 'add'])->name('.add');
        Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('.edit');
        Route::get('/profile/{id}', [SalesController::class, 'profile'])->name('.profile');
        Route::get('/delete/{id}', [SalesController::class, 'delete'])->name('.delete');

        Route::post('/data', [SalesController::class, 'data'])->name('.data');
        Route::post('/store', [SalesController::class, 'store'])->name('.store');
        Route::post('/edit', [SalesController::class, 'store_edit'])->name('.store-edit');
    });
});

// route crm
Route::prefix('/crm')->name('crm')->group(function () {

    // route crm visit schedule
    Route::prefix('/visit-schedule')->name('.visit-schedule')->group(function () {
        Route::get('/', [VisitScheduleController::class, 'index']);
        Route::get('/add', [VisitScheduleController::class, 'add'])->name('.add');
        Route::get('/id', [VisitScheduleController::class, 'generate_id'])->name('.id');
        Route::get('/company', [VisitScheduleController::class, 'company'])->name('.company');
        Route::get('/company/{id}', [VisitScheduleController::class, 'company_detail'])->name('.company-detail');
        Route::get('/edit/{id}', [VisitScheduleController::class, 'edit'])->name('.edit');
        Route::get('/view/{id}', [VisitScheduleController::class, 'view'])->name('.view');
        Route::get('/delete/{id}', [VisitScheduleController::class, 'delete'])->name('.delete');
        Route::get('/search_enginer', [VisitScheduleController::class, 'search_enginer'])->name('.search_enginer');

        Route::post('/data', [VisitScheduleController::class, 'data'])->name('.data');
        Route::post('/status', [VisitScheduleController::class, 'status'])->name('.status');
        Route::post('/store', [VisitScheduleController::class, 'store'])->name('.store');
        Route::post('/edit', [VisitScheduleController::class, 'store_edit'])->name('.store-edit');
    });

    // route crm visit report
    Route::prefix('/visit-report')->name('.visit-report')->group(function () {
        Route::get('/', [VisitReportController::class, 'index']);
        Route::get('/report/{id?}', [VisitReportController::class, 'report'])->name('.report');
        Route::get('/add/{id?}', [VisitReportController::class, 'add'])->name('.add');
        Route::get('/id', [VisitReportController::class, 'generate_id'])->name('.id');
        Route::get('/visit', [VisitReportController::class, 'visit'])->name('.visit');
        Route::get('/visit/{id}', [VisitReportController::class, 'visit_detail'])->name('.visit-detail');
        Route::get('/edit/{id}', [VisitReportController::class, 'edit'])->name('.edit');
        Route::get('/delete/{id}', [VisitReportController::class, 'delete'])->name('.delete');

        Route::post('/get_pdf', [VisitReportController::class, 'get_pdf'])->name('.get-pdf');
        Route::post('/upload_pdf', [VisitReportController::class, 'upload_pdf'])->name('.upload-pdf');
        Route::post('/delete_pdf', [VisitReportController::class, 'delete_pdf'])->name('.delete-pdf');

        Route::post('/data', [VisitReportController::class, 'data'])->name('.data');
        Route::post('/store', [VisitReportController::class, 'store'])->name('.store');
        Route::post('/edit', [VisitReportController::class, 'store_edit'])->name('.store-edit');
    });

    // route project inquiry
    Route::prefix('/inquiry')->name('.inquiry')->group(function () {
        Route::get('/', [InquiryController::class, 'index']);
        Route::get('/add/{id?}', [InquiryController::class, 'add'])->name('.add');
        Route::get('/id', [InquiryController::class, 'generate_id'])->name('.id');
        Route::get('/download/excel/template', [InquiryController::class, 'download_template'])->name('.download-template');
        Route::get('/visit', [InquiryController::class, 'visit'])->name('.visit');
        Route::get('/visit/{id}', [InquiryController::class, 'visit_detail'])->name('.visit-detail');
        Route::get('/customer', [InquiryController::class, 'customer'])->name('.customer');
        Route::get('/customer/{id}', [InquiryController::class, 'customer_detail'])->name('.customer-detail');
        Route::get('/sales', [InquiryController::class, 'sales'])->name('.sales');
        Route::get('/sales/{id}', [InquiryController::class, 'sales_detail'])->name('.sales-detail');
        Route::get('/view/{id}', [InquiryController::class, 'view'])->name('.view');
        Route::get('/edit/{id}', [InquiryController::class, 'edit'])->name('.edit');
        Route::get('/delete/{id}', [InquiryController::class, 'delete'])->name('.delete');

        Route::post('/data', [InquiryController::class, 'data'])->name('.data');
        Route::post('/data-grade', [InquiryController::class, 'data_grade'])->name('.data-grade');
        Route::post('/data-status', [InquiryController::class, 'data_status'])->name('.data-status');
        Route::post('/data-customer', [InquiryController::class, 'data_customer'])->name('.data-customer');
        Route::post('/data-sales', [InquiryController::class, 'data_sales'])->name('.data-sales');
        Route::post('/get_pdf', [InquiryController::class, 'get_pdf'])->name('.get-pdf');
        Route::post('/upload_pdf', [InquiryController::class, 'upload_pdf'])->name('.upload-pdf');
        Route::post('/delete_pdf', [InquiryController::class, 'delete_pdf'])->name('.delete-pdf');
        Route::post('/upload_excel', [InquiryController::class, 'upload_excel'])->name('.upload-excel');
        Route::post('/get-product', [InquiryController::class, 'get_product'])->name('.get-product');
        Route::post('/product-list', [InquiryController::class, 'product_list'])->name('.product-list');
        Route::post('/store-product', [InquiryController::class, 'store_product'])->name('.store-product');
        Route::post('/delete-product', [InquiryController::class, 'delete_product'])->name('.delete-product');
        Route::post('/store', [InquiryController::class, 'store'])->name('.store');
        Route::post('/edit', [InquiryController::class, 'store_edit'])->name('.store-edit');

        Route::post('/store-sourcing-suppliers', [InquiryController::class, 'store_sourcing_suppliers'])->name('.store-sourcing-suppliers');
    });
});

// route transaction
Route::prefix('/transaction')->name('transaction')->group(function () {

    // route transaction sales order
    Route::prefix('/sales-order')->name('.sales-order')->group(function () {
        Route::get('/', [SalesOrderController::class, 'index']);
        Route::get('/add/{id?}', [SalesOrderController::class, 'add'])->name('.add');
        Route::get('/id', [SalesOrderController::class, 'generate_id'])->name('.id');
        Route::get('/download/excel/template', [SalesOrderController::class, 'download_template'])->name('.download-template');
        Route::get('/inquiries', [SalesOrderController::class, 'inquiries'])->name('.inquiries');
        Route::get('/inquiry/{id}', [SalesOrderController::class, 'inquiry_detail'])->name('.inquiry-detail');
        Route::get('/customer', [SalesOrderController::class, 'customer'])->name('.customer');
        Route::get('/customer/{id}', [SalesOrderController::class, 'customer_detail'])->name('.customer-detail');
        Route::get('/sales', [SalesOrderController::class, 'sales'])->name('.sales');
        Route::get('/sales/{id}', [SalesOrderController::class, 'sales_detail'])->name('.sales-detail');
        Route::get('/open/{id}', [SalesOrderController::class, 'open'])->name('.open');
        Route::get('/view/{id}', [SalesOrderController::class, 'view'])->name('.view');
        Route::get('/download/product-list/excel/{id}', [SalesOrderController::class, 'download_product_list_excel'])->name('.download-product-list-excel');
        Route::get('/download/product-list/pdf/{id}', [SalesOrderController::class, 'download_product_list_pdf'])->name('.download-product-list-pdf');
        Route::get('/edit/{id}', [SalesOrderController::class, 'edit'])->name('.edit');
        Route::get('/delete/{id}', [SalesOrderController::class, 'delete'])->name('.delete');

        Route::post('/data', [SalesOrderController::class, 'data'])->name('.data');
        Route::post('/data-grade', [SalesOrderController::class, 'data_grade'])->name('.data-grade');
        Route::post('/data-status', [SalesOrderController::class, 'data_status'])->name('.data-status');
        Route::post('/data-customer', [SalesOrderController::class, 'data_customer'])->name('.data-customer');
        Route::post('/data-sales', [SalesOrderController::class, 'data_sales'])->name('.data-sales');
        Route::post('/get_pdf', [SalesOrderController::class, 'get_pdf'])->name('.get-pdf');
        Route::post('/upload_pdf', [SalesOrderController::class, 'upload_pdf'])->name('.upload-pdf');
        Route::post('/delete_pdf', [SalesOrderController::class, 'delete_pdf'])->name('.delete-pdf');
        Route::post('/upload_excel', [SalesOrderController::class, 'upload_excel'])->name('.upload-excel');
        Route::post('/get-product', [SalesOrderController::class, 'get_product'])->name('.get-product');
        Route::post('/store-product', [SalesOrderController::class, 'store_product'])->name('.store-product');
        Route::post('/store', [SalesOrderController::class, 'store'])->name('.store');
        Route::post('/edit', [SalesOrderController::class, 'store_edit'])->name('.store-edit');
        Route::post('/open', [SalesOrderController::class, 'openstore'])->name('.open-store');

        Route::post('/reviews', [SalesOrderController::class, 'review_get_data'])->name('.review_get_data');
        Route::post('/review-set-supplier', [SalesOrderController::class, 'set_supplier'])->name('.review_set_supplier');

        Route::get('/price/{id}', [SalesOrderController::class, 'price'])->name('.price');
        Route::post('/price/{id}', [SalesOrderController::class, 'store_price'])->name('.price.store');
        Route::post('/product-list', [SalesOrderController::class, 'product_lists'])->name('.product_lists');
        Route::post('currency-converter', [SalesOrderController::class, 'currency_converter'])->name('.currency_converter');
    });

    // route transaction sourcing item
    Route::prefix('/sourcing-item')->name('.sourcing-item')->group(function () {
        Route::get('/', [SourcingItemController::class, 'index']);
        Route::get('/add/{id?}', [SourcingItemController::class, 'add'])->name('.add');
        Route::get('/id', [SourcingItemController::class, 'generate_id'])->name('.id');
        Route::post('/reviews', [SourcingItemController::class, 'review_get_data'])->name('.review_get_data');
        Route::get('/download/excel/template', [SourcingItemController::class, 'download_template'])->name('.download-template');
        Route::get('/sales-order', [SourcingItemController::class, 'sales_order'])->name('.sales-order');
        Route::get('/so/{id}', [SourcingItemController::class, 'so_detail'])->name('.so-detail');
        Route::get('/customer', [SourcingItemController::class, 'customer'])->name('.customer');
        Route::get('/customer/{id}', [SourcingItemController::class, 'customer_detail'])->name('.customer-detail');
        Route::get('/sales', [SourcingItemController::class, 'sales'])->name('.sales');
        Route::get('/sales/{id}', [SourcingItemController::class, 'sales_detail'])->name('.sales-detail');
        Route::get('/view/{id}', [SourcingItemController::class, 'view'])->name('.view');
        Route::get('/selected/{id}', [SourcingItemController::class, 'selected'])->name('.selected');
        Route::get('/download/product-list/excel/{id}', [SourcingItemController::class, 'download_product_list_excel'])->name('.download-product-list-excel');
        Route::get('/download/product-list/pdf/{id}', [SourcingItemController::class, 'download_product_list_pdf'])->name('.download-product-list-pdf');
        Route::get('/edit/{id}', [SourcingItemController::class, 'edit'])->name('.edit');
        Route::get('/delete/{id}', [SourcingItemController::class, 'delete'])->name('.delete');
        Route::get('/search_supplier', [SourcingItemController::class, 'get_supplier'])->name('.get_supplier');

        Route::post('/data', [SourcingItemController::class, 'data'])->name('.data');
        Route::post('/data-grade', [SourcingItemController::class, 'data_grade'])->name('.data-grade');
        Route::post('/data-status', [SourcingItemController::class, 'data_status'])->name('.data-status');
        Route::post('/data-customer', [SourcingItemController::class, 'data_customer'])->name('.data-customer');
        Route::post('/data-sales', [SourcingItemController::class, 'data_sales'])->name('.data-sales');
        Route::post('/get_pdf', [SourcingItemController::class, 'get_pdf'])->name('.get-pdf');
        Route::post('/upload_pdf', [SourcingItemController::class, 'upload_pdf'])->name('.upload-pdf');
        Route::post('/delete_pdf', [SourcingItemController::class, 'delete_pdf'])->name('.delete-pdf');
        Route::post('/upload_excel', [SourcingItemController::class, 'upload_excel'])->name('.upload-excel');
        Route::post('/get-product', [SourcingItemController::class, 'get_product'])->name('.get-product');
        Route::post('/store-product', [SourcingItemController::class, 'store_product'])->name('.store-product');
        Route::post('/store', [SourcingItemController::class, 'store'])->name('.store');
        Route::post('/edit', [SourcingItemController::class, 'store_edit'])->name('.store-edit');

        Route::post('/get-storage', [SourcingItemController::class, 'get_storage'])->name('.get-storage');
        Route::post('/save-folder', [SourcingItemController::class, 'save_folder'])->name('.save-folder');
        Route::post('/delete-file-folder', [SourcingItemController::class, 'delete_file_folder'])->name('.delete-file-folder');
        Route::post('/upload-file', [SourcingItemController::class, 'upload_file'])->name('.upload-file');

        Route::post('/review-save-product', [SourcingItemController::class, 'review_save_product'])->name('.review_save_product');
    });

    Route::prefix('/quotation')->name('.quotation')->group(function () {
        Route::get('/', [QuotationController::class, 'index']);
        Route::get('/data', [QuotationController::class, 'data'])->name('.data');
        Route::get('/add', [QuotationController::class, 'add'])->name('.add');
        Route::post('/store', [QuotationController::class, 'store'])->name('.store');
        Route::get('/{id}/re-create', [QuotationController::class, 'reCreate'])->name('.re-create');
        Route::post('/{id}/re-create', [QuotationController::class, 'reCreateStore'])->name('.re-create-store');
        Route::get('/{id}', [QuotationController::class, 'view'])->name('.view');
        Route::get('/{id}/print', [QuotationController::class, 'print'])->name('.print');
        Route::patch('/{id}', [QuotationController::class, 'update'])->name('.update');
        Route::delete('/{id}', [QuotationController::class, 'delete'])->name('.delete');
        Route::get('/search/sales-orders', [QuotationController::class, 'search_sales_orders'])->name('.search.sales-orders');
    });
});

Route::prefix('/purchase-order-customer')->name('purchase-order-customer')->group(function () {
    Route::get('/', [PurchaseOrderCustomerController::class, 'index']);
    Route::get('/add', [PurchaseOrderCustomerController::class, 'add'])->name('.add');
    Route::post('/store', [PurchaseOrderCustomerController::class, 'store'])->name('.store');
    Route::get('/{id}/edit', [PurchaseOrderCustomerController::class, 'edit'])->name('.edit');
    Route::put('/{id}', [PurchaseOrderCustomerController::class, 'update'])->name('.update');
    Route::delete('/{id}', [PurchaseOrderCustomerController::class, 'delete'])->name('.delete');
    Route::get('/search/quotation', [PurchaseOrderCustomerController::class, 'search_quotation'])->name('.search.quotation');
    Route::post('upload-document', [PurchaseOrderCustomerController::class, 'uploadDocument'])->name('.upload-document');
    Route::post('save-po/{id}', [PurchaseOrderCustomerController::class, 'savePOCustomer'])->name('.save-po');
});

Route::prefix('/purchase-order-customer-sales')->name('purchase-order-customer-sales')->group(function () {
    Route::get('/', [PurchaseOrderCustomerSalesController::class, 'index']);
    Route::get('/add', [PurchaseOrderCustomerSalesController::class, 'add'])->name('.add');
    Route::post('/store', [PurchaseOrderCustomerSalesController::class, 'store'])->name('.store');
    Route::get('/{id}/edit', [PurchaseOrderCustomerSalesController::class, 'edit'])->name('.edit');
    Route::put('/{id}', [PurchaseOrderCustomerSalesController::class, 'update'])->name('.update');
    Route::delete('/{id}', [PurchaseOrderCustomerSalesController::class, 'delete'])->name('.delete');
    Route::get('/search/quotation', [PurchaseOrderCustomerSalesController::class, 'search_quotation'])->name('.search.quotation');
    Route::post('upload-document', [PurchaseOrderCustomerSalesController::class, 'uploadDocument'])->name('.upload-document');
    Route::post('/product-delete/{id}', [PurchaseOrderCustomerSalesController::class, 'deleteProduct'])->name('.delete-product');
});

Route::prefix('/purchase-order-supplier')->name('purchase-order-supplier')->group(function () {
    Route::get('/', [PurchaseOrderSupplierController::class, 'index']);
    Route::get('/add', [PurchaseOrderSupplierController::class, 'add'])->name('.add');
    Route::post('/store', [PurchaseOrderSupplierController::class, 'store'])->name('.store');
    Route::get('/{id}/edit', [PurchaseOrderSupplierController::class, 'edit'])->name('.edit');
    Route::get('/{id}/print', [PurchaseOrderSupplierController::class, 'print'])->name('.print');
    Route::put('/{id}', [PurchaseOrderSupplierController::class, 'update'])->name('.update');
    Route::delete('/{id}', [PurchaseOrderSupplierController::class, 'delete'])->name('.delete');
    Route::get('/search/sales-order', [PurchaseOrderSupplierController::class, 'search_sales_order'])->name('.search.sales-order');
    Route::get('/search/po-customer', [PurchaseOrderSupplierController::class, 'search_po_customer'])->name('.search.po_customer');
    Route::post('upload-document', [PurchaseOrderSupplierController::class, 'upload_document'])->name('.upload-document');
});

Route::prefix('/payment-request')->name('payment-request')->group(function () {
    Route::get('/', [PaymentRequestController::class, 'index']);
    Route::get('/add', [PaymentRequestController::class, 'add'])->name('.add');
    Route::post('/store', [PaymentRequestController::class, 'store'])->name('.store');
    Route::get('/{id}/edit', [PaymentRequestController::class, 'edit'])->name('.edit');
    Route::get('/{id}/print', [PaymentRequestController::class, 'print'])->name('.print');
    Route::put('/{id}', [PaymentRequestController::class, 'update'])->name('.update');
    Route::delete('/{id}', [PaymentRequestController::class, 'delete'])->name('.delete');
    Route::get('/search/purchase-order-supplier', [PaymentRequestController::class, 'search_purchase_order_supplier'])->name('.search.purchase-order-supplier');
    Route::post('upload-document', [PaymentRequestController::class, 'upload_document'])->name('.upload-document');
    Route::get('/id', [PaymentRequestController::class, 'generate_id'])->name('.id');
});

Route::prefix('list-payment')->name('list-payment')->group(function () {
    Route::get('/', [ListPaymentController::class, 'index']);
    Route::get('/add', [PurchaseOrderCustomerController::class, 'add'])->name('.add');
    Route::post('/store', [PurchaseOrderCustomerController::class, 'store'])->name('.store');
    Route::get('/{id}/edit', [ListPaymentController::class, 'edit'])->name('.edit');
    Route::get('/{id}/approve', [ListPaymentController::class, 'approve'])->name('.approve');
    Route::get('/{id}/bukti_transfer', [ListPaymentController::class, 'bukti_transfer'])->name('.bukti_transfer');
    Route::put('/{id}', [PurchaseOrderCustomerController::class, 'update'])->name('.update');
    Route::delete('/{id}', [PurchaseOrderCustomerController::class, 'delete'])->name('.delete');
    Route::get('/search/quotation', [PurchaseOrderCustomerController::class, 'search_quotation'])->name('.search.quotation');
    Route::post('upload-document', [PurchaseOrderCustomerController::class, 'uploadDocument'])->name('.upload-document');
});

Route::prefix('approval-po')->name('approval-po')->group(function () {
    Route::get('/', [ApprovalPoSupplierController::class, 'index']);
    Route::get('/{id}/edit', [ApprovalPoSupplierController::class, 'edit'])->name('.edit');
    Route::get('/{id}/approve', [ApprovalPoSupplierController::class, 'approve'])->name('.approve');
    Route::get('/{id}/reject', [ApprovalPoSupplierController::class, 'reject'])->name('.reject');
});

Route::prefix('approval-payment')->name('approval-payment')->group(function () {
    Route::get('/', [ApprovalPaymentRequestController::class, 'index']);
    Route::get('/{id}/edit', [ApprovalPaymentRequestController::class, 'edit'])->name('.edit');
    Route::get('/{id}/approve', [ApprovalPaymentRequestController::class, 'approve'])->name('.approve');
});

Route::any('/files/{any}', function ($filePath) {
    if (Storage::exists('public/' . $filePath)) {
        $storageType = 'public';
    } elseif (Storage::exists('temp/' . $filePath)) {
        $storageType = 'temp';
    } else {
        abort(404);
    }

    return response()->file(storage_path('app/' . $storageType . '/' . $filePath));
})->where('any', '.*');

// route project
Route::prefix('/project')->name('project')->group(function () {

    // route project purchasing
    Route::prefix('/purchasing')->name('.purchasing')->group(function () {
        Route::get('/', [PurchasingController::class, 'index']);
        Route::get('/add', [PurchasingController::class, 'add'])->name('.add');
        Route::get('/id', [PurchasingController::class, 'generate_id'])->name('.id');
        Route::get('/download/excel/template', [PurchasingController::class, 'downloaod_template'])->name('.download-template');
        Route::get('/inquiries', [PurchasingController::class, 'inquiries'])->name('.inquiries');
        Route::get('/inquiry/{id}/{edit?}', [PurchasingController::class, 'inquiry_detail'])->name('.inquiry-detail');
        Route::get('/get-excel/{id}', [PurchasingController::class, 'get_excel'])->name('.get-excel');
        Route::get('/get-header/{id}', [PurchasingController::class, 'get_header'])->name('.get-header');
        Route::get('/review-excel/{id}', [PurchasingController::class, 'review_excel'])->name('.review-excel');
        Route::get('/get-folders/{id}', [PurchasingController::class, 'get_folders'])->name('.get-folders');
        Route::get('/edit/{id}', [PurchasingController::class, 'edit'])->name('.edit');
        Route::get('/estimate/{id}', [PurchasingController::class, 'estimate'])->name('.estimate');
        Route::get('/delete/{id}', [PurchasingController::class, 'delete'])->name('.delete');

        Route::post('/data', [PurchasingController::class, 'data'])->name('.data');
        Route::post('/upload_excel', [PurchasingController::class, 'upload_excel'])->name('.upload-excel');
        Route::post('/delete_excel', [PurchasingController::class, 'delete_excel'])->name('.delete-excel');
        Route::post('/review-set-supplier', [PurchasingController::class, 'set_supplier'])->name('.review-set-supplier');
        Route::post('/create-folder', [PurchasingController::class, 'create_folder'])->name('.create-folder');
        Route::post('/upload-folder-files', [PurchasingController::class, 'upload_document'])->name('.upload-folder-files');
        Route::post('/open-folder', [PurchasingController::class, 'open_folder'])->name('.open-folder');
        Route::post('/show-file', [PurchasingController::class, 'open_file'])->name('.show-file');
        Route::post('/delete-folder', [PurchasingController::class, 'delete_folder'])->name('.delete-folder');
        Route::post('/store', [PurchasingController::class, 'store'])->name('.store');
        Route::post('/edit', [PurchasingController::class, 'store_edit'])->name('.store-edit');
        Route::post('/estimate/data', [PurchasingController::class, 'estimate_data'])->name('.estimate-data');
        Route::post('/estimate/dt', [PurchasingController::class, 'estimate_dt'])->name('.estimate-dt');
        Route::post('/estimate/shipping', [PurchasingController::class, 'estimate_shipping'])->name('.estimate-shipping');
        Route::post('/estimate/estimate', [PurchasingController::class, 'estimate_estimate'])->name('.estimate-estimate');
    });

    // route project quotation
    Route::prefix('/quotation')->name('.quotation')->group(function () {
        Route::get('/', [QuotationController::class, 'index']);
        Route::get('/add', [QuotationController::class, 'add'])->name('.add');
        Route::get('/price/{id}', [QuotationController::class, 'price'])->name('.price');
        Route::get('/terms-cond/{id}', [QuotationController::class, 'terms_cond'])->name('.terms-cond');
        Route::get('/document/{id}', [QuotationController::class, 'document'])->name('.document');
        Route::get('/print/{id}', [QuotationController::class, 'print'])->name('.print');

        Route::post('/data', [QuotationController::class, 'data'])->name('.data');
        Route::post('/price-data', [QuotationController::class, 'price_data'])->name('.price-data');
        Route::post('/term-data', [QuotationController::class, 'term_data'])->name('.term-data');
        Route::post('/store-price', [QuotationController::class, 'store_price'])->name('.store-price');
        Route::post('/up-price', [QuotationController::class, 'up_price'])->name('.up-price');
        Route::post('/clear-redis', [QuotationController::class, 'clear_redis'])->name('.clear-redis');
        Route::post('/store-terms', [QuotationController::class, 'store_terms'])->name('.store-terms');
        Route::post('/open-folder', [QuotationController::class, 'open_folder'])->name('.open-folder');
        Route::post('/open-file', [QuotationController::class, 'open_file'])->name('.open-file');
    });

    // route project preorder
    Route::prefix('/pre-order')->name('.pre-order')->group(function () {
        Route::get('/', [PreOrderCustomerController::class, 'index']);
        Route::get('/add', [PreOrderCustomerController::class, 'add'])->name('.add');
        Route::get('/quotation-list', [PreOrderCustomerController::class, 'quotation_list'])->name('.quotation-list');
        Route::get('/quotation-detail/{id}', [PreOrderCustomerController::class, 'quotation_detail'])->name('.quotation-detail');
        Route::get('/item-detail/{id}', [PreOrderCustomerController::class, 'item_detail'])->name('.item-detail');
        Route::get('/view/{id}', [PreOrderCustomerController::class, 'view'])->name('.view');

        Route::post('/data', [PreOrderCustomerController::class, 'data'])->name('.data');
        Route::post('/store', [PreOrderCustomerController::class, 'store'])->name('.store');
    });
});

// route preorder 
Route::prefix('/pre-order')->name('pre-order')->group(function () {
    Route::get('/', [PreOrderSupplierController::class, 'index']);
    Route::get('/ready', [PreOrderSupplierController::class, 'ready'])->name('.ready');
    Route::get('/create-po/{id}', [PreOrderSupplierController::class, 'create_po'])->name('.create-po');
    Route::get('/id', [PreOrderSupplierController::class, 'generate_id'])->name('.id');
    Route::get('/list-item/{id}', [PreOrderSupplierController::class, 'list_item'])->name('.list-item');
    Route::get('/document/{id}', [PreOrderSupplierController::class, 'document'])->name('.document');
    Route::get('/list/{id}', [PreOrderSupplierController::class, 'list'])->name('.list');
    Route::get('/print/{id}', [PreOrderSupplierController::class, 'print'])->name('.print');

    Route::post('/data', [PreOrderSupplierController::class, 'data'])->name('.data');
    Route::post('/ready-data', [PreOrderSupplierController::class, 'ready_data'])->name('.ready-data');
    Route::post('/add', [PreOrderSupplierController::class, 'add'])->name('.add');
    Route::any('/change-price', [PreOrderSupplierController::class, 'change_price'])->name('.change-price');
    Route::post('/store', [PreOrderSupplierController::class, 'store'])->name('.store');
});


Route::get('/test_mail', function () {
    try {
        $sendmail = 'test@pt-prasasti.com';
        $data = \App\Models\VisitReport::with(['visit', 'visit.customer', 'sales'])->where('uuid', 'a876a5c6-59d8-4344-9b9c-abc2ebd299a1')->first();
        // dd($data);
        $dataVisitReport = [
            'id' => $data->visit_schedule_id,
            'date' => $data->visit->date,
            'time' => $data->visit->time,
            'customer_company' => $data->visit->customer->name . " - " . $data->visit->customer->company,
            'customer_phone'     => $data->visit->customer->phone,
            'customer_email'     => $data->visit->customer->email,
            'status'           => $data->status,
            'note'      => $data->note,
            'plan'      => $data->planing,
            'sales'     => $data->sales->name
        ];
        $email = new \App\Mail\ReportMail(collect($dataVisitReport));

        \Mail::to($sendmail)->send($email);
        // dispatch(new \App\Jobs\SendMailVisitJob($sendmail));
        dd('Success');
    } catch (\Throwable $th) {
        dd($th);
    }
});

require __DIR__ . '/auth.php';
