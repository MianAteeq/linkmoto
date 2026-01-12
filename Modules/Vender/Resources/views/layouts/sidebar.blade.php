<!-- BEGIN: Main Menu-->
{{-- @dd(auth()->user()->getPermissionNames()) --}}

@php
    $permissions = getPermission();

    // dd($permission);

@endphp

<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            <li class=" nav-item"><a style="padding-left: 28px "><i class="la la-home d-none"></i><span class="menu-title"
                        data-i18n="Dashboard"
                        style="font-weight: bold; color: black;">{{ auth()->user()->profile->company_name }} <span style=" display: inline-block;
    padding: 0.6em 0.6em;
    font-size: 83%;
"
                            class="badge badge-success">
                            @if (accountVerfied() == 0)
                                Active
                            @else
                                Setup
                            @endif
                        </span></span></a></li>
            <li class="{{ request()->route()->uri == 'vender' ? 'active' : '' }} nav-item mt-1"><a
                    href="{{ route('vender.index') }}" style="padding-bottom: 0px;padding-top: 0px;"><i
                        class="la la-home d-none"></i><span class="menu-title" data-i18n="Home">
                        @if (accountVerfied() == 0)
                            Home
                        @else
                            Getting started
                        @endif
                    </span></a></li>

            @if (existsInArray('Access Details', $permissions) == true ||
                    existsInArray('Access Main Contacts', $permissions) == true ||
                    existsInArray('Access Trading Name', $permissions) == true ||
                    existsInArray('Access Sites', $permissions) == true)
                <li class=" navigation-header mt-2" style="padding-top: 1px;padding-left: 29px;"><span>Business</span>
                </li>
            @endif
            @if (existsInArray('Access Details', $permissions) == true)
                <li
                    class=" {{ str_contains(request()->route()->uri, 'vender/business/information') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.business.information') }}">
                        <i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Details">Information</span></a>
                </li>
                <li
                    class=" {{ str_contains(request()->route()->uri, 'vender/business/vat') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.business.vat') }}">
                        <i class="la la-home d-none"></i><span class="menu-title" data-i18n="Details">VAT</span></a>
                </li>
            @endif
            @if (existsInArray('Access Main Contacts', $permissions) == true)
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/main/contact') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.main.contact') }}"><i class="la la-home d-none"></i><span
                            class="menu-title" data-i18n="Main Contacts">Main Contacts</span></a>
                </li>
            @endif
            @if (existsInArray('Access Trading Name', $permissions) == true)
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/trading/name') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.trading.name') }}"><i class="la la-home d-none"></i><span
                            class="menu-title" data-i18n="Trading names">Trading names</span></a>
                </li>
            @endif
            @if (existsInArray('Access Sites', $permissions) == true)
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/sites') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.site') }}"><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Sites">Sites</span></a>
                </li>
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/banks') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.bank') }}"><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Bank Accounts">Bank Accounts</span></a>
                </li>
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/email/address') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.mail') }}"><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Email Address">Email Addresses</span></a>
                </li>
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/verification') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.verification') }}"><i class="la la-home d-none"></i><span
                            class="menu-title" data-i18n="Email Address">Verification
                            ({{ accountVerfied() }})</span></a>
                </li>
            @endif
            @if (existsInArray('Access User', $permissions) == true)
                <li class=" navigation-header mt-2" style="padding-top: 1px;padding-left: 29px;"><span>Directory</span>
                </li>
                <li
                    class="{{ str_contains(request()->route()->uri, 'vender/user') == true ? 'sub_active' : '' }} nav-item">
                    <a href="{{ route('vender.user') }}"><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Users">Users</span></a>
                </li>
            @endif
            @if (existsInArray('Service Provider', $permissions) == true || existsInArray('Business Manager', $permissions) == true)
                <li class=" navigation-header mt-2" style="padding-top: 1px;padding-left: 29px;"><span>Products</span>
                </li>
            @endif
            @if (existsInArray('Business Manager', $permissions) == true)
                <li class=" nav-item"><a href="{{ route('vender.app.setting') }}">
                        <i class="la la-home d-none"></i><span class="menu-title" data-i18n="Business Manager">Business
                            Manager</span></a></li>
                @if (str_contains(request()->route()->uri, 'vender/app/setting') == true)
                    <li class="{{ str_contains(request()->route()->uri, 'vender/app/setting') == true ? 'sub_active' : '' }} nav-item"
                        style="padding-left: 26px;"><a href="{{ route('vender.app.setting') }}"><i
                                class="la la-home d-none"></i><span class="menu-title" data-i18n="App Setting">App
                                Setting</span></a></li>
                @endif
            @endif
            @if (existsInArray('Service Provider', $permissions) == true)


                <li class=" nav-item"><a href="{{ route('vender.service.provider.trading.unit') }}"><i
                            class="la la-home d-none"></i><span class="menu-title" data-i18n="Service Provider">Service
                            Provider</span></a></li>
                @if (str_contains(request()->route()->uri, 'vender/service/provider') == true)
                    <li class="{{ str_contains(request()->route()->uri, 'vender/service/provider/trading/unit') == true ? 'sub_active' : '' }} nav-item"
                        style="padding-left: 26px;"><a href="{{ route('vender.service.provider.trading.unit') }}"><i
                                class="la la-home d-none"></i><span class="menu-title" data-i18n="Trading Unit">Trade
                                Units</span></a></li>
                    <li class="{{ str_contains(request()->route()->uri, 'vender/service/provider/app/setting') == true ? 'sub_active' : '' }} nav-item"
                        style="padding-left: 26px;"><a href="{{ route('vender.service.provider.app.setting') }}"><i
                                class="la la-home d-none"></i><span class="menu-title" data-i18n="App Setting">App
                                Setting</span></a></li>
                    <li class="{{ str_contains(request()->route()->uri, 'vender/service/provider/app/data') == true ? 'sub_active' : '' }} nav-item"
                        style="padding-left: 26px;"><a href="{{ route('vender.service.provider.app.data') }}"><i
                                class="la la-home d-none"></i><span class="menu-title" data-i18n="App Data">App
                                Data</span></a></li>
                @endif
            @endif

            @if (existsInArray('App Report', $permissions) == true ||
                    existsInArray('User Report', $permissions) == true ||
                    existsInArray('Business Report', $permissions) == true)
                <li class=" navigation-header mt-2" style="padding-top: 1px;padding-left: 29px;">
                    <span>Reporting</span>
                </li>
            @endif
            @if (existsInArray('App Report', $permissions) == true)
                <li class=" nav-item"><a><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Apps Reports">Apps Reports</span></a></li>
            @endif
            @if (existsInArray('User Report', $permissions) == true)
                <li class=" nav-item"><a><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="User Reports">User Reports</span></a></li>
            @endif
            @if (existsInArray('Business Report', $permissions) == true)
                <li class=" nav-item"><a><i class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Business Reports">Business Reports</span></a></li>
            @endif
            @if (existsInArray('Subscription', $permissions) == true || existsInArray('Invoice', $permissions) == true)
                <li class=" navigation-header mt-2" style="padding-top: 1px;padding-left: 29px;"><span>Billing</span>
                </li>
            @endif
            @if (existsInArray('Subscription', $permissions) == true)
                <li class=" nav-item"><a href="{{ route('vender.subscription.index') }}"><i
                            class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Subscription">Subscriptions</span></a></li>
            @endif
            @if (existsInArray('Invoice', $permissions) == true)
                <li class=" nav-item"><a href="{{ route('vender.invoice.index') }}"><i
                            class="la la-home d-none"></i><span class="menu-title"
                            data-i18n="Invoice">Invoices</span></a></li>
                <li class=" nav-item"><a href="{{ route('vender.payout') }}"><i class="la la-home d-none"></i><span
                            class="menu-title" data-i18n="Invoice">Payout Account</span></a></li>
            @endif







        </ul>
    </div>
</div>

<!-- END: Main Menu-->
