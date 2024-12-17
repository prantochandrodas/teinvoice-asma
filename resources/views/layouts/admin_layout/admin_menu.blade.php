@php
    $authAdmin      = auth()->guard('admin')->user();
    $defaultAdmin   = $authAdmin->email == defaultAdmin();
@endphp
<li class="nav-item  {{ $main_menu == 'home' ? 'active' : '' }}" style="height: 2rem !important; " >
    <a href="{{ route('admin.home') }}" class="nav-link"
        style="height: 2.5rem !important;margin: 0 2px !important; background-color: #6e4ddf">
        <i class="fas fa-home fa-2x" style="color:red;"></i>
    </a>
</li>

{{-- <li class="nav-item dropdown">

    <a id="dropdownSubMenu1" href="{{ route('admin.home') }}"
            data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false" class="nav-link dropdown-toggle">
        {{ __('message.report') }}
    </a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
        <li><a href="{{ route('admin.home') }}" class="dropdown-item">Item Report </a></li>
        <li><a href="{{ route('admin.home') }}" class="dropdown-item">Daily Sales Report</a></li>
        <li><a href="{{ route('admin.home') }}" class="dropdown-item">Monthly Sales Report</a></li>
        <li><a href="{{ route('admin.home') }}" class="dropdown-item">User Report</a></li>
    </ul>
</li> --}}


{{--
@if ($authAdmin->can('application.view')
|| $authAdmin->can('admin.list')
|| $authAdmin->can('role.list')
|| $defaultAdmin
)
    <li class="nav-item dropdown {{ $main_menu == 'setting' ? 'active' : '' }} ">
        <a id="dropdownSubMenu1 "
            href="{{ route('admin.home') }}"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            class="nav-link dropdown-toggle">
            <i class="fas fa-cogs fa-lg text-success"></i>
            {{ __('message.settings') }}
        </a>

        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">

            @if ($authAdmin->can('application.view') || $defaultAdmin)
            <li>
                <a href="{{ route('admin.application.index') }}"
                class="dropdown-item {{ $child_menu == 'application' ? 'active' : '' }} ">
                {{ __('message.company_information') }}
                </a>
            </li>
            @endif

            @if ($authAdmin->can('admin.list') || $defaultAdmin)
            <li>
                <a href="{{ route('admin.admin.index') }}"
                class="dropdown-item {{ $child_menu == 'admin' ? 'active' : '' }} ">
                {{ __('message.admin') }}
                </a>
            </li>
            @endif

            @if ($authAdmin->can('admin.role') || $defaultAdmin)
            <li>
                <a href="{{ route('admin.role.index') }}"
                class="dropdown-item {{ $child_menu == 'role' ? 'active' : '' }} ">
                {{ __('message.roll') }}
                </a>
            </li>
            @endif

            @if ($authAdmin->can('item.list') || $defaultAdmin)
            <li>
                <a href="{{ route('admin.item.index') }}"
                class="dropdown-item {{ $child_menu == 'item' ? 'active' : '' }} ">
                    {{ __('message.item') }}
                </a>
            </li>
            @endif

            @if ($authAdmin->can('customer.list') || $defaultAdmin)
            <li>
                <a href="{{ route('admin.customer.index') }}"
                class="dropdown-item {{ $child_menu == 'customer' ? 'active' : '' }} ">
                    {{ __('message.customer') }}
                </a>
            </li>
            @endif

        </ul>
    </li>

@endif --}}

<li class="nav-item">
    <a href="#" class="btn btn-secondary nav-link "
        data-toggle="modal" data-target="#reportMenuModal"
        style="height: 4rem !important; margin: 0 2px !important;  background: #0077b5">
        <span class="text-white">
            <i class="fas fa-file-alt "></i>
            {{ __('message.report') }} <br> ({{__('message.report', [], $secondary_locale)}})
            <i class="fas fa-chevron-down"></i>
        </span>
    </a>
</li>

@if ($authAdmin->can('application.view')
|| $authAdmin->can('admin.list')
|| $authAdmin->can('role.list')
|| $defaultAdmin
)
<li class="nav-item">
    <a  href="#" class="btn  nav-link"
        data-toggle="modal" data-target="#settingsMenuModal"
        style="height: 4rem !important; margin: 0 2px !important;  background-color: #3b2b72">
        <span class="text-white">
            <i class="fas fa-cogs fa-lg "></i>
            {{ __('message.settings') }} <br> ({{__('message.settings', [], $secondary_locale)}})
            <i class="fas fa-chevron-down"></i>
        </span>
    </a>
</li>
@endif

<li class="nav-item">
    <a href="{{ route('admin.home') }}" class="btn " style="height: 4rem !important; margin: 0 2px !important; background-color: #3a5890; color:white">
        {{ __('message.session_bills') }} <br> ({{__('message.session_bills', [], $secondary_locale)}})
    </a>
</li>
<!--<li class="nav-item">
    <a href="{{ route('admin.home') }}" class="dropdown-item">Collect Session Bills</a>
</li>--->

<li class="nav-item">
    <a href="{{ route('admin.item.index') }}" class="btn" style="margin: 0 2px !important; padding:3px 1px!important; background-color: #FF5733; color:white" >
        {{ __('message.add_item') }} <br> ({{__('message.add_item', [], $secondary_locale)}})
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.buy-product-entry.index') }}"
                        class="btn btn-success btn-block {{ $child_menu == 'buy_product_list' ? 'active' : '' }} ">
                        {{ __('message.buy_product_report') }} <br> ({{__('message.buy_product_report', [], $secondary_locale)}})
                        </a>
</li>

<li class="nav-item dropdown">
    <a id="dropdownSubMenu1" class="nav-link dropdown-toggle btn btn-secondary" href="#"
        data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false" style="height: 4rem !important; margin: 0 2px !important">
        <span class="text-white"> {{ __('message.language') }}  <br> ({{__('message.language', [], $secondary_locale)}})</span>
    </a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
      <li><a href="{{ route('admin.lang', 'en') }}" class="dropdown-item {{ $application->locale == "en" ? 'active':'' }}">English</a></li>
      <li><a href="{{ route('admin.lang', 'ar') }}" class="dropdown-item {{ $application->locale == "ar" ? 'active':'' }}">Arabic عربى</a></li>
      <li><a href="{{ route('admin.lang', 'bn') }}" class="dropdown-item {{ $application->locale == "bn" ? 'active':'' }}">Bangla বাংলা</a></li>
    </ul>
</li>
