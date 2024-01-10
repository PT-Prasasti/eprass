<header id="page-header">
    <div class="content-header">
        <div class="content-header-section">
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-circle btn-dual-secondary" id="page-header-options-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-wrench"></i>
                </button>
                <div class="dropdown-menu min-width-300" aria-labelledby="page-header-options-dropdown">
                    <h5 class="h6 text-center py-10 mb-10 border-b text-uppercase">Settings</h5>
                    <h6 class="dropdown-header">Sidebar</h6>
                    <div class="row gutters-tiny text-center mb-5">
                        <div class="col-6">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10"
                                data-toggle="layout" data-action="sidebar_style_inverse_off">Light</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10"
                                data-toggle="layout" data-action="sidebar_style_inverse_on">Dark</button>
                        </div>
                    </div>
                    <div class="d-none d-xl-block">
                        <h6 class="dropdown-header">Main Content</h6>
                        <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout"
                            data-action="content_layout_toggle">Toggle Layout</button>
                    </div>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </div>
        <div class="content-header-section">
            {{-- <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-primary badge-pill" id="notif-numbers">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
                    <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifications</h5>
                    <ul class="list-unstyled my-20" id="notif-list">
                        @foreach (auth()->user()->notifications->take(4) as $item)
                        <li>
                            <a class="d-flex align-items-center text-body-color-dark media mb-15" href="javascript:void(0)">
                                <div class="ml-5 mr-15">
                                    @if ($item->read_at == null)
                                    <i class="fa fa-fw fa-circle text-primary"></i>
                                    @else 
                                    <i class="fa fa-fw fa-circle text-white"></i>
                                    @endif
                                </div>
                                <div class="media-body pr-10">
                                    @php
                                        $notif = $item->data['message'];
                                        if (str_contains($notif, ":visit")) {
                                            $replacement = $item->data['visit_id'];
                                            $notif = str_replace(":visit", $replacement, $notif);
                                        }
                                        if (str_contains($notif, ":customer")) {
                                            $customer = App\Models\Customer::find($item->data['customer_id'])->name;
                                            $company = App\Models\Customer::find($item->data['customer_id'])->company;
                                            $replacement = $customer . ' ['. $company .']';
                                            $notif = str_replace(":customer", $replacement, $notif);
                                        }
                                        if (str_contains($notif, ":sales")) {
                                            $sales = App\Models\Sales::find($item->data['sales_id'])->name;
                                            $replacement = $sales;
                                            $notif = str_replace(":sales", $replacement, $notif);
                                        }

                                        $created = $item->created_at;
                                        $now = Carbon\Carbon::now();
                                        $duration = $now->diff($created);
                                        $seconds = $duration->s;
                                        $minutes = $duration->i;
                                        $hours = $duration->h;
                                        $days = $duration->d;

                                        $time = $seconds . 'detik yang lalu';
                                        if($minutes >= 1) {
                                            $time = $minutes . 'menit yang lalu';
                                        }
                                        if($hours >= 1) {
                                            $time = $hours . 'jam yang lalu';
                                        }
                                        if($days >= 1) {
                                            $time = $days . 'hari yang lalu';
                                        }
                                    @endphp
                                    <p class="mb-0">{{ $notif }}</p>
                                    <div class="text-muted font-size-sm font-italic">{{ $time }}</div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-center mb-0" href="{{ route('notification') }}" id="view-all-notification">
                        <i class="fa fa-flag mr-5"></i> View All
                    </a>
                </div>
            </div> --}}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ strtoupper(auth()->user()->name) }}</span>
                    <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-200"
                    aria-labelledby="page-header-user-dropdown">
                    <!-- <a class="dropdown-item" href="">
                        <i class="si si-user mr-5"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div> -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="si si-logout mr-5"></i> Sign Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form action="be_pages_generic_search.html" method="post">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-secondary" data-toggle="layout"
                            data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                        id="page-header-search-input" name="page-header-search-input">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
</header>
