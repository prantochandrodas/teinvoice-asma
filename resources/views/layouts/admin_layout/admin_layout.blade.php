@php
    $authAdmin      = auth()->guard('admin')->user();
    $defaultAdmin   = $authAdmin->email == defaultAdmin();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @if ($application->photo)
        <link rel="icon" type="image/png" href="{{ file_url($application->photo, 'application') }}"
            alt="{{ $application->name ?? config('app.name', 'Super Shop') }}">
    @endif
    <title>
        {{ isset($page_title) ? $page_title . ' || ' : '' }}{{ $application->name ?? config('app.name', 'Super Shop') }}
    </title>

    <title>  {{ isset($page_title) ?  $page_title." || " : ''}}{{ session()->get('company_name') ?? config('app.name', 'Inventory') }}  </title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin_css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin_css/style.css') }}">

    @stack('style_css')

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ route('admin.home') }}" class="navbar-brand">
                    @if ($application->photo)
                        <img src="{{ $application->photo_path }}"
                            class="brand-image  elevation-3" alt="Application Photo" style="    height: 2.1rem; width: 70px;">
                    @endif

                </a>
				<span class="brand-text font-weight-light" style="width:200px !important;  word-wrap: break-word;">
                        {{ $application->name }}
                 </span>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">

                        @include('layouts.admin_layout.admin_menu')

                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            @if ($application->photo)
                                <img src="{{ $application->photo_path }}" style="width: 3rem; box-shadow:0px 0px 20px #564a4a "
                                    class="brand-image img-circle " alt="Admin Photo">
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">
                                <span class="brand-text font-weight-light" style="word-wrap: break-word">
                                    {{ $application->name }}
                                </span>
                            </span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                Name :
                                <span class="float-right text-muted text-sm">
                                    {{ $authAdmin->full_name }}
                                </span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                Email :
                                <span class="float-right text-muted text-sm">
                                    {{ $authAdmin->email }}
                                </span>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.logout') }}" class="dropdown-item dropdown-footer">
                                <i class="fas fa-power-off text-danger"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>

            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container" style="max-width: 100%">

                @yield('content')

            </div>
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.admin_layout.admin_footer')

    </div>
    <!-- ./wrapper -->


    <div class="modal fade" id="reportMenuModal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="showResult">
                <div class="card-header text-center " style="font-size: 20px; font-weight:bold">
                    {{ __('message.report') }} ({{__('message.report', [], $secondary_locale)}})
                </div>
                <div class="card-body row" >

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.sale.list') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                        {{ __('message.item_report') }} ({{__('message.item_report', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.sale.list') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                        {{ __('message.daily_sales_report') }} ({{__('message.daily_sales_report', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.sale.list') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                        {{ __('message.monthly_sales_report') }} ({{__('message.monthly_sales_report', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.sale.list') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                        {{ __('message.user_report') }} ({{__('message.user_report', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.stockItem.index') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                        {{ __('message.stock_report') }} ({{__('message.stock_report', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.sale-payment.salePaymentList') }}"
                            class="btn btn-success btn-block {{ $child_menu == 'SalesPaymentList' ? 'active' : '' }} ">
                            {{ __('message.sale_payment_list') }} ({{__('message.sale_payment_list', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.due-payment.duePaymentList') }}"
                            class="btn btn-success btn-block {{ $child_menu == 'DuePaymentList' ? 'active' : '' }} ">
                            {{ __('message.due_payment_list') }} ({{__('message.due_payment_list', [], $secondary_locale)}})
                        </a>
                    </div>

                    <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.due-customer.index') }}"
                            class="btn btn-success btn-block {{ $child_menu == 'DueList' ? 'active' : '' }} ">
                            {{ __('message.customer_due_list') }} ({{__('message.customer_due_list', [], $secondary_locale)}})
                        </a>
                    </div>
                    {{-- <div class="col-md-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.buy-product-entry.index') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'buy_product_list' ? 'active' : '' }} ">
                            Buy Product Report
                        </a>
                    </div> --}}

                </div>
            </div>
            <div class="modal-footer">
            <button  type="button" class="btn btn-danger float-right" data-dismiss="modal"> {{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})</button>
            </div>
        </div>
        </div>
    </div>

    @if ($authAdmin->can('application.view')
    || $authAdmin->can('admin.list')
    || $authAdmin->can('role.list')
    || $defaultAdmin
    )
        <div class="modal fade" id="settingsMenuModal">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="showResult">
                    <div class="card-header text-center " style="font-size: 20px; font-weight:bold">
                        {{ __('message.settings') }} ({{__('message.settings', [], $secondary_locale)}})
                    </div>
                    <div class="card-body row" >

                        @if ($authAdmin->can('application.view') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.application.index') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'application' ? 'active' : '' }} ">
                                    {{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        @if ($authAdmin->can('admin.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.admin.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'admin' ? 'active' : '' }} ">
                                    {{ __('message.admin') }} ({{__('message.admin', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        @if ($authAdmin->can('role.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.role.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'role' ? 'active' : '' }} ">
                                    {{ __('message.role') }} ({{__('message.role', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        @if ($authAdmin->can('item.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.item.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'item' ? 'active' : '' }} ">
                                    {{ __('message.item') }} ({{__('message.item', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        @if ($authAdmin->can('customer.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.customer.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'customer' ? 'active' : '' }} ">
                                    {{ __('message.customer') }} ({{__('message.customer', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        {{-- <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.due-customer.index') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'DueList' ? 'active' : '' }} ">
                                {{ __('Customer Due-List') }}
                            </a>
                        </div> --}}

                        <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.due-payment.index') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'DuePayment' ? 'active' : '' }} ">
                                {{ __('message.due_payment') }} ({{__('message.due_payment', [], $secondary_locale)}})
                            </a>
                        </div>

                        {{-- <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.sale-payment.salePaymentList') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'SalesPaymentList' ? 'active' : '' }} ">
                                {{ __('Sale Payment List') }}
                            </a>
                        </div> --}}

                        {{-- <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.due-payment.duePaymentList') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'DuePaymentList' ? 'active' : '' }} ">
                                {{ __('Due Payment List') }}
                            </a>
                        </div> --}}


                        @if ($authAdmin->can('supplier.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.supplier.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'supplier' ? 'active' : '' }} ">
                                    {{ __('message.supplier') }} ({{__('message.supplier', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif

                        @if ($authAdmin->can('supplier.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.purchase.purchaseList') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'purchase' ? 'active' : '' }} ">
                                    {{ __('message.purchase') }} ({{__('message.purchase', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif
                        @if ($authAdmin->can('supplier.list') || $defaultAdmin)
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.expense-head.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'expenseHeadIndex' ? 'active' : '' }} ">
                                    {{ __('message.expense_head') }} ({{__('message.expense_head', [], $secondary_locale)}})
                                </a>
                            </div>
                        @endif
                        {{-- @if ($authAdmin->can('supplier.list') || $defaultAdmin) --}}
                            <div class="col-md-6" style="padding-bottom: 10px">
                                <a href="{{ route('admin.expense.index') }}"
                                    class="btn btn-success btn-block {{ $child_menu == 'expenseIndex' ? 'active' : '' }} ">
                                    {{ __('message.expense') }} ({{__('message.expense', [], $secondary_locale)}})
                                </a>
                            </div>
                        {{-- @endif --}}
                        {{-- <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.buy-product-entry.create') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'buy-product-entry' ? 'active' : '' }} ">
                                {{ __('Buy Product Entry') }}
                            </a>
                        </div> --}}

                        <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.branches.index') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'branch' ? 'active' : '' }} ">
                                {{ __('message.branch') }} ({{__('message.branch', [], $secondary_locale)}})
                            </a>
                        </div>

                        <div class="col-md-6" style="padding-bottom: 10px">
                            <a href="{{ route('admin.customer.ledger') }}"
                                class="btn btn-success btn-block {{ $child_menu == 'customerLedger' ? 'active' : '' }} ">
                                {{ __('message.customer_ledger') }} ({{__('message.customer_ledger', [], $secondary_locale)}})
                            </a>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button  type="button" class="btn btn-danger float-right" data-dismiss="modal"> {{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})</button>
                </div>
            </div>
            </div>
        </div>
    @endif



    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin_js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/admin_js/main.js') }}"></script>

    <script>

        @if(session()->has('message'))
            @if(session('type') == 'success')
                toastr.success('{{ session('message') }}','',10000);
            @endif

            @if(session('type') == 'danger')
                toastr.error('{{ session('message') }}','',10000);
            @endif
        @endif

        $(document).ready(function() {
    //        $('.dropdown-expanded').dropdown();
        });

        $(document).ready(function(){
            // Show hide popover
            $(document).on('click', '.dropdown', function(){
                $(this).find(".dropdown-menu").slideToggle("fast");
            });
        });
        $(document).on("click", function(event){
            var $trigger = $(".dropdown");
            if($trigger !== event.target && !$trigger.has(event.target).length){
                $(".dropdown-menu").slideUp("fast");
            }
        });
    </script>

    @stack('script_js')

</body>

</html>
