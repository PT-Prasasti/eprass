<nav id="sidebar">
    <div class="sidebar-content">
        <div class="content-header content-header-fullrow px-15">
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <div class="content-header-item">
                    <img src="{{ asset('assets/logosimple.png') }}" width="45%">
                </div>
            </div>
        </div>
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="">
                    @if (auth()->user()->hasRole('customer'))
                        @if (App\Models\Customer::where('username', auth()->user()->username)->first()->profile_picture != null)
                            <img class="img-avatar"
                                src="{{ Storage::url(App\Models\Customer::where('username', auth()->user()->username)->first()->profile_picture) }}"
                                alt="">
                        @else
                            <img class="img-avatar" src="{{ asset('assets/avrifan.jpeg') }}" alt="">
                        @endif
                    @elseif (auth()->user()->hasRole('sales'))
                        @if (App\Models\Sales::where('username', auth()->user()->username)->first()->profile_picture != null)
                            <img class="img-avatar"
                                src="{{ Storage::url(App\Models\Sales::where('username', auth()->user()->username)->first()->profile_picture) }}"
                                alt="">
                        @else
                            <img class="img-avatar" src="{{ asset('assets/avrifan.jpeg') }}" alt="">
                        @endif
                    @else
                        <img class="img-avatar" src="{{ asset('assets/avrifan.jpeg') }}" alt="">
                    @endif
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <p class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase">
                            {{ strtoupper(auth()->user()->name) }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-side content-side-full">
            <ul class="nav-main">
                @if (!auth()->user()->hasRole('logistic'))
                    <li>
                        <a href="{{ route('dashboard') }}"><i class="si si-cup"></i><span
                                class="sidebar-mini-hide">Dashboard</span></a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('logistic'))
                    <li>
                        <a class="{{ Request::is('logistic/dashboard') ? 'active' : '' }}"
                            href="{{ route('logistic.dashboard') }}"><i class="si si-cup"></i><span
                                class="sidebar-mini-hide">Dashboard</span></a>
                    </li>

                    <li>
                        <a class="{{ Request::is('logistic/good-received*') ? 'active' : '' }}"
                            href="{{ route('logistic.good_received.index') }}"><i class="fa fa-file"></i><span
                                class="sidebar-mini-hide">Good
                                Received</span></a>
                    </li>

                    <li>
                        <a class="{{ Request::is('logistic/delivery-order*') ? 'active' : '' }}"
                            href="{{ route('logistic.delivery_order.index') }}"><i
                                class="fa fa-calendar-check-o"></i><span class="sidebar-mini-hide">Delivery
                                Schedule</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-book"></i>
                            <span class="sidebar-mini-hide">Payment Request</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('manager'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">SALES</span>
                    </li>
                    <li>
                        <a href="{{ route('crm.visit-schedule.show') }}"><i class="fa fa-calendar"></i><span
                                class="sidebar-mini-hide">ListVisit Schedule</span></a>
                    </li>
                    <li>
                        <a href="{{ route('crm.visit-report') }}"><i class="fa fa-file-text-o"></i><span
                                class="sidebar-mini-hide">List Report</span></a>
                    </li>
                    <li>
                    <li>
                        <a href="{{ route('crm.inquiry') }}"><i class="fa fa-edit"></i><span class="sidebar-mini-hide"
                                id="inquiry-nav">List Inquiry</span></a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">SALES ADMIN</span>
                    </li>
                    <li>
                        <a href="{{ route('transaction.sales-order') }}"><i class="fa fa-edit"></i><span
                                class="sidebar-mini-hide">List Sales Order</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-lock"></i>
                            <span class="sidebar-mini-hide">Quotation</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('transaction.quotation') }}">List Quotation</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.quotation') }}?filter=reject">Rejected Quotation</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">PURCHASING</span>
                    </li>
                    <li>
                        <a href="{{ route('transaction.sourcing-item') }}"><i class="fa fa-fax"></i><span
                                class="sidebar-mini-hide" id="sourcing-item-nav">List App Item</span></a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Order Customer</span>
                    </li>
                    <li>
                        <a href="{{ route('purchase-order-customer') }}">
                            <i class="fa fa-file"></i>
                            <span class="sidebar-mini-hide">List PO Customer</span>
                        </a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Order Supplier</span>
                    </li>
                    <li>
                        <a class="" href="{{ route('approval-po') }}"><i class="fa fa-calendar-check-o"></i><span
                                class="sidebar-mini-hide" id="po-supplier-nav">App PO Supplier</span></a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Payment Request</span>
                    </li>
                    <li>
                        <a href="{{ route('payment-request.exim') }}"><i class="fa fa-calendar-check-o"></i><span
                                class="sidebar-mini-hide" id="payment-req-nav">App Payment Request</span></a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('hod'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">SALES</span>
                    </li>
                    <li>
                        <a href="{{ route('crm.visit-schedule.show') }}"><i class="fa fa-calendar"></i><span
                                class="sidebar-mini-hide">ListVisit Schedule</span></a>
                    </li>
                    <li>
                        <a href="{{ route('crm.visit-report') }}"><i class="fa fa-file-text-o"></i><span
                                class="sidebar-mini-hide">List Report</span></a>
                    </li>
                    <li>
                    <li>
                        <a href="{{ route('crm.inquiry') }}"><i class="fa fa-edit"></i><span
                                class="sidebar-mini-hide" id="inquiry-nav">List Inquiry</span></a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">SALES ADMIN</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-edit"></i><span class="sidebar-mini-hide" id="sales-order-nav">Sales
                                Order</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('transaction.sales-order.add') }}">Add SO</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.sales-order') }}">List SO</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-lock"></i>
                            <span class="sidebar-mini-hide">Quotation</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('transaction.quotation.add') }}">Add Quotation</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.quotation') }}">List Quotation</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.quotation') }}?filter=reject">Rejected Quotation</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('purchase-order-customer-sales') }}">
                            <i class="fa fa-dollar"></i>
                            <span class="sidebar-mini-hide">List PO Customer</span>
                        </a>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">PURCHASING</span>
                    </li>
                    <li>
                        @if (auth()->user()->hasRole('manage'))
                            <a href="{{ route('transaction.sourcing-item') }}"><i class="fa fa-fax"></i><span
                                    class="sidebar-mini-hide">List Sourcing Item</span></a>
                        @else
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                    class="fa fa-fax"></i><span class="sidebar-mini-hide">Sourcing Item</span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('transaction.sourcing-item.add') }}">Add Sourcing Item</a>
                                </li>
                                <li>
                                    <a href="{{ route('transaction.sourcing-item') }}">List Sourcing Item <span
                                            id="selection-done-list-sourcing-item-nav"></span></a>
                                </li>
                            </ul>

                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-book"></i>
                            <span class="sidebar-mini-hide">PO Supplier</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('purchase-order-supplier.add') }}">Add PO Supplier</a>
                            </li>
                            <li>
                                <a href="{{ route('purchase-order-supplier') }}">List PO Supplier</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-book"></i>
                            <span class="sidebar-mini-hide">Payment Request</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasRole('hod'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">HOD</span>
                    </li>
                    <li>
                        <a href="{{ route('payment-request.exim') }}"><i class="fa fa-calendar-check-o"></i><span
                                class="sidebar-mini-hide" id="payment-req-nav">App Payment Request</span></a>
                    </li>






                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">PO TRACKING</span>
                    </li>

                    <li>
                        <a href="{{ route('po-tracking.index') }}">
                            <i class="fa fa-truck"></i>
                            <span class="sidebar-mini-hide">List PO Tracking</span>
                        </a>
                    </li>
                @endif
                </li>
                @endif

                @if (auth()->user()->hasRole('sales') ||
                        auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('hos') ||
                        auth()->user()->hasRole('manage'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Pipeline</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-calendar"></i><span class="sidebar-mini-hide">Visit Schedule</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('crm.visit-schedule.add') }}">Add Visit</a>
                            </li>
                            <li>
                                <a href="{{ route('crm.visit-schedule') }}">List Visit Schedule</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-file-text-o"></i><span class="sidebar-mini-hide">Report</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('crm.visit-report.add') }}">Add Report</a>
                            </li>
                            <li>
                                <a href="{{ route('crm.visit-report') }}">List Report</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-edit"></i><span class="sidebar-mini-hide">Inquiry</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('crm.inquiry.add') }}">Add Inquiry</a>
                            </li>
                            <li>
                                <a href="{{ route('crm.inquiry') }}">List Inquiry</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('transaction.quotation') }}">
                            <i class="fa fa-lock"></i>
                            <span class="sidebar-mini-hide">Quotation</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('sales'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Transaction</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-dollar"></i>
                            <span class="sidebar-mini-hide">PO Customer</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('purchase-order-customer-sales.add') }}">Add PO Customer</a>
                            </li>
                            <li>
                                <a href="{{ route('purchase-order-customer-sales') }}">List PO Customer</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Payment Request</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-book"></i>
                            <span class="sidebar-mini-hide">Payment Request</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasRole('admin_sales') ||
                        auth()->user()->hasRole('manage') ||
                        auth()->user()->hasRole('purchasing') ||
                        auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('hos'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Transaction</span>
                    </li>
                @endif

                @if (auth()->user()->hasRole('admin_sales') ||
                        auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('hos') ||
                        auth()->user()->hasRole('manage'))
                    <li>
                        <a href="{{ route('crm.inquiry') }}"><i class="si si-docs"></i><span
                                class="sidebar-mini-hide">List Inquiry</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-edit"></i><span class="sidebar-mini-hide">Sales Order</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('transaction.sales-order.add') }}">Add SO</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.sales-order') }}">List SO</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-lock"></i>
                            <span class="sidebar-mini-hide">Quotation</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('transaction.quotation.add') }}">Add Quotation</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.quotation') }}">List Quotation</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction.quotation') }}?filter=reject">Rejected Quotation</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-dollar"></i>
                            <span class="sidebar-mini-hide">PO Customer</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('purchase-order-customer.add') }}">Add PO Customer</a>
                            </li>
                            <li>
                                <a href="{{ route('purchase-order-customer') }}">List PO Customer</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-book"></i>
                            <span class="sidebar-mini-hide">Payment Request</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('purchasing') ||
                        auth()->user()->hasRole('manage') ||
                        auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('hos'))
                    <li>
                        <a href="{{ route('transaction.sales-order') }}"><i class="si si-docs"></i><span
                                class="sidebar-mini-hide">List Sales Order</span></a>
                    </li>
                    <li>
                        @if (auth()->user()->hasRole('manage'))
                            <a href="{{ route('transaction.sourcing-item') }}"><i class="fa fa-fax"></i><span
                                    class="sidebar-mini-hide">List Sourcing Item</span></a>
                        @else
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                    class="fa fa-fax"></i><span class="sidebar-mini-hide">Sourcing Item</span></a>
                            <ul>
                                <li>
                                    <a href="{{ route('transaction.sourcing-item.add') }}">Add Sourcing Item</a>
                                </li>
                                <li>
                                    <a href="{{ route('transaction.sourcing-item') }}">List Sourcing Item</a>
                                </li>
                            </ul>
                        @endif
                    </li>
                    @if (auth()->user()->hasRole('manager'))
                    @else
                        <li class="nav-main-heading">
                            <span class="sidebar-mini-hidden">Order Customer</span>
                        </li>
                        <li>
                            <a href="{{ route('purchase-order-customer') }}">
                                <i class="fa fa-file"></i>
                                <span class="sidebar-mini-hide">List PO Customer</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('manager'))
                        <li class="nav-main-heading">
                            <span class="sidebar-mini-hidden">Order Supplier</span>
                        </li>
                        <li>
                            <a class="" href="{{ route('approval-po') }}"><i
                                    class="fa fa-calendar-check-o"></i><span class="sidebar-mini-hide">App PO
                                    Supplier</span></a>
                        </li>
                        <li>
                            <a class="active" href="{{ route('approval-payment') }}"><i
                                    class="fa fa-calendar-check-o"></i><span class="sidebar-mini-hide">App Payment
                                    Request</span></a>
                        </li>
                    @else
                        <li class="nav-main-heading">
                            <span class="sidebar-mini-hidden">Order Supplier</span>
                        </li>
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                <i class="fa fa-book"></i>
                                <span class="sidebar-mini-hide">PO Supplier</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('purchase-order-supplier.add') }}">Add PO Supplier</a>
                                </li>
                                <li>
                                    <a href="{{ route('purchase-order-supplier') }}">List PO Supplier</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                <i class="fa fa-book"></i>
                                <span class="sidebar-mini-hide">Payment Request</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                                </li>
                                <li>
                                    <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                @if (auth()->user()->hasRole('purchasing') || auth()->user()->hasRole('superadmin'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Cloud</span>
                    </li>
                    <li>
                        <a href="{{ route('cloud') }}">
                            <i class="fa fa-archive"></i>
                            <span class="sidebar-mini-hide"> Document List</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('sales') || auth()->user()->hasRole('superadmin'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Data Master</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-group"></i><span class="sidebar-mini-hide">Customer</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('data-master.customer.add') }}">Add Customer</a>
                            </li>
                            <li>
                                <a href="{{ route('data-master.customer') }}">List Customer</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('exim'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Order Supplier</span>
                    </li>
                    <li>
                        <a class="nav-submenu nav-link" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-dollar"></i><span class="sidebar-mini-hide">PO Supplier</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('purchase-order-supplier') }}">List PO Supplier</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu nav-link" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-truck"></i><span class="sidebar-mini-hide">PO Tracking</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('po-tracking.add') }}">Add PO Tracking</a>
                            </li>
                            <li>
                                <a href="{{ route('po-tracking.index') }}">List PO Tracking</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Payment</span>
                    </li>
                    <li>
                        <a class="nav-submenu nav-link" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-book"></i><span class="sidebar-mini-hide">Payment Request</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('payment-request.exim.add') }}">Add Payment Request</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-request.exim') }}">List Payment Request</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Data Master</span>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-dollar"></i><span class="sidebar-mini-hide">Data Forwarder</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('data-master.exim.add') }}">Add Forwarder</a>
                            </li>
                            <li>
                                <a href="{{ route('data-master.exim') }}">List Forwarder</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('hrd'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">Payment Request</span>
                    </li>
                    <li>
                        <a class="{{ request()->is('payment-request*') ? 'active' : '' }}"
                            href="{{ route('payment-request.exim') }}"><i class="fa fa-calendar-check-o"></i><span
                                class="sidebar-mini-hide" id="payment-req-nav">App Payment Request</span></a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('superadmin'))
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-user-secret"></i><span class="sidebar-mini-hide">Supplier</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('data-master.supplier.add') }}">Add Supplier</a>
                            </li>
                            <li>
                                <a href="{{ route('data-master.supplier') }}">List Supplier</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                class="fa fa-id-card-o"></i><span class="sidebar-mini-hide">Sales</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('data-master.sales.add') }}">Add Sales</a>
                            </li>
                            <li>
                                <a href="{{ route('data-master.sales') }}">List Sales</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('finance'))
                    <li class="nav-main-heading">
                        <span class="sidebar-mini-hidden">ORDER SUPPLIER</span>
                    </li>
                    <li>
                        <a class="active" href="{{ route('payment-request.exim') }}"><i class="fa fa-file"></i><span
                                class="sidebar-mini-hide">List Payment</span></a>
                    </li>
                @endif



            </ul>
        </div>
    </div>
</nav>
