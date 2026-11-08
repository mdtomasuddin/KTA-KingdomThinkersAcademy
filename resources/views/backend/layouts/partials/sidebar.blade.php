<!--begin::Sidebar-->
@php
    $user = auth()->user();
    $isSuperAdmin = $user && in_array($user->role, ['super_admin', 'admin'], true);

    $canViewUsers            = $isSuperAdmin;
    $canViewCategories       = $isSuperAdmin;
    $canViewPages            = $isSuperAdmin;
    $canViewFaqs             = $isSuperAdmin;
    $canViewSystemSettings   = $isSuperAdmin;
    $canViewMailSettings     = $isSuperAdmin;
    $canViewIntegrations     = $isSuperAdmin;
    $canViewSocialLinks      = $isSuperAdmin;
    $canViewSettingsDropdown =
        $canViewSystemSettings || $canViewMailSettings || $canViewIntegrations || $canViewSocialLinks;
@endphp

<aside role="navigation" aria-label="Main navigation" x-cloak
    class="fixed top-0 left-0 z-50 h-full flex flex-col bg-white dark:bg-sidebar-dark border-r border-gray-200 dark:border-gray-800 sidebar-transition shadow-lg"
    :class="{
        'w-[260px]': isSidebarExpanded(),
        'w-[72px]': !isSidebarExpanded(),
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full lg:translate-x-0': !mobileSidebarOpen
    }"
    @mouseenter="sidebarHover = true" @mouseleave="sidebarHover = false">

    <!--begin::BrandLogo-->
    <div class="flex-shrink-0 flex items-center h-16 px-4 border-b border-gray-200 dark:border-gray-800"
        :class="isSidebarExpanded() ? 'justify-between' : 'justify-center'">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 overflow-hidden">
            @if (!empty($setting->logo))
                <img src="{{ $setting->logo }}" alt="{{ $setting->title ?? 'Dashboard' }}"
                    class="h-9 w-auto object-contain">
            @else
                <img src="{{ asset('images/applogo.png') }}" alt="{{ $setting->title ?? 'Dashboard' }}"
                    class="h-8 w-auto object-contain">
                <div x-show="isSidebarExpanded()" x-cloak x-transition.opacity class="whitespace-nowrap">
                    <span
                        class="text-base font-bold tracking-tight text-gray-900 dark:text-white">{{ $setting->title ?? 'Dashboard' }}</span>
                </div>
            @endif
        </a>
        <button @click="mobileSidebarOpen = false"
            class="lg:hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>
    <!--end::BrandLogo-->

    <!--begin::SidebarNav-->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-3 px-3" id="sidebar-menu">
        <ul class="flex flex-col gap-1" id="sideNavbar">

            <!--begin::OverviewHeading-->
            <li class="nav-item" x-show="isSidebarExpanded()" x-cloak x-transition.opacity>
                <div
                    class="navbar-heading px-2.5 pt-1 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 whitespace-nowrap">
                    Overview
                </div>
            </li>
            <!--end::OverviewHeading-->

            <!--begin::DashboardLink-->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}" :title="!isSidebarExpanded() ? 'Dashboard' : ''">
                    <i class="fa-solid fa-gauge-high nav-icon"></i>
                    <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                        class="whitespace-nowrap">Dashboard</span>
                </a>
            </li>
            <!--end::DashboardLink-->



            @if ($canViewUsers)
                <!--begin::UserManagementHeading-->
                <li class="nav-item pt-2" x-show="isSidebarExpanded()" x-cloak x-transition.opacity>
                    <div
                        class="navbar-heading px-2.5 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 whitespace-nowrap">
                        User Management
                    </div>
                </li>
                <!--end::UserManagementHeading-->

                <!--begin::UsersLink-->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}" :title="!isSidebarExpanded() ? 'Users' : ''">
                        <i class="fa-solid fa-users nav-icon"></i>
                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                            class="whitespace-nowrap">Users</span>
                    </a>
                </li>
                <!--end::UsersLink-->
            @endif

            @if ($canViewCategories || $canViewPages || $canViewFaqs)
                <!--begin::AppContentHeading-->
                <li class="nav-item pt-2" x-show="isSidebarExpanded()" x-cloak x-transition.opacity>
                    <div
                        class="navbar-heading px-2.5 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 whitespace-nowrap">
                        App Content & CMS
                    </div>
                </li>
                <!--end::AppContentHeading-->

                @if ($canViewCategories)
                    <!--begin::CategoriesLink-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}"
                            href="{{ route('category.index') }}" :title="!isSidebarExpanded() ? 'Categories' : ''">
                            <i class="fa-solid fa-layer-group nav-icon"></i>
                            <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                class="whitespace-nowrap">Categories</span>
                        </a>
                    </li>
                    <!--end::CategoriesLink-->
                @endif

                @if ($canViewPages)
                    <!--begin::DynamicPagesLink-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.*') ? 'active' : '' }}"
                            href="{{ route('pages.index') }}" :title="!isSidebarExpanded() ? 'Dynamic Pages' : ''">
                            <i class="fa-solid fa-file-lines nav-icon"></i>
                            <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                class="whitespace-nowrap">Dynamic
                                Pages</span>
                        </a>
                    </li>
                    <!--end::DynamicPagesLink-->
                @endif

                @if ($canViewFaqs)
                    <!--begin::FaqLink-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('faq.*') ? 'active' : '' }}"
                            href="{{ route('faq.index') }}" :title="!isSidebarExpanded() ? 'FAQs' : ''">
                            <i class="fa-solid fa-circle-question nav-icon"></i>
                            <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                class="whitespace-nowrap">FAQs</span>
                        </a>
                    </li>
                    <!--end::FaqLink-->
                @endif
            @endif

            @if ($canViewSettingsDropdown)
                <!--begin::SystemSettingsHeading-->
                @php
                    $settingsOpen =
                        request()->routeIs('system-setting.*') ||
                        request()->routeIs('mail-setting.*') ||
                        request()->routeIs('integration.*') ||
                        request()->routeIs('social-links.*');
                @endphp
                <li class="nav-item pt-2" x-show="isSidebarExpanded()" x-cloak x-transition.opacity>
                    <div
                        class="navbar-heading px-2.5 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 whitespace-nowrap">
                        System Settings
                    </div>
                </li>
                <!--end::SystemSettingsHeading-->

                <!--begin::SettingsDropdown-->
                <li class="nav-item" x-data="{ open: {{ $settingsOpen ? 'true' : 'false' }} }">
                    <button @click="isSidebarExpanded() ? (open = !open) : (sidebarOpen = true)"
                        class="nav-link nav-toggle w-full text-left {{ $settingsOpen ? 'active' : '' }}"
                        :class="{
                            'bg-gray-100/70 dark:bg-gray-800/50 text-gray-900 dark:text-white': open && !
                                {{ $settingsOpen ? 'true' : 'false' }}
                        }"
                        :title="!isSidebarExpanded() ? 'Settings' : ''">
                        <i class="fa-solid fa-gear nav-icon"></i>
                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                            class="flex-1 text-left whitespace-nowrap">Settings</span>
                        <i x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                            class="fa-solid fa-chevron-down nav-arrow" :class="open ? 'rotated' : ''"></i>
                    </button>
                    <!--begin::SettingsSubmenu-->
                    <div x-show="open && isSidebarExpanded()" x-collapse.duration.200ms class="nav-submenu">
                        <ul class="flex flex-col gap-1">
                            @if ($canViewSystemSettings)
                                <!--begin::SystemSettingsLink-->
                                <li class="nav-item">
                                    <a class="nav-link nav-sub-link {{ request()->routeIs('system-setting.*') ? 'active' : '' }}"
                                        href="{{ route('system-setting.index') }}">
                                        <i class="fa-solid fa-sliders sub-icon"></i>
                                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                            class="whitespace-nowrap">System Settings</span>
                                    </a>
                                </li>
                                <!--end::SystemSettingsLink-->
                            @endif

                            @if ($canViewMailSettings)
                                <!--begin::MailSettingLink-->
                                <li class="nav-item">
                                    <a class="nav-link nav-sub-link {{ request()->routeIs('mail-setting.*') ? 'active' : '' }}"
                                        href="{{ route('mail-setting.index') }}">
                                        <i class="fa-solid fa-envelope sub-icon"></i>
                                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                            class="whitespace-nowrap">Mail Configuration</span>
                                    </a>
                                </li>
                                <!--end::MailSettingLink-->
                            @endif

                            @if ($canViewIntegrations)
                                <!--begin::IntegrationSettingLink-->
                                <li class="nav-item">
                                    <a class="nav-link nav-sub-link {{ request()->routeIs('integration.*') ? 'active' : '' }}"
                                        href="{{ route('integration.setting') }}">
                                        <i class="fa-solid fa-plug sub-icon"></i>
                                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                            class="whitespace-nowrap">Integrations</span>
                                    </a>
                                </li>
                                <!--end::IntegrationSettingLink-->
                            @endif

                            @if ($canViewSocialLinks)
                                <!--begin::SocialLinksLink-->
                                <li class="nav-item">
                                    <a class="nav-link nav-sub-link {{ request()->routeIs('social-links.*') ? 'active' : '' }}"
                                        href="{{ route('social-links.index') }}">
                                        <i class="fa-solid fa-share-nodes sub-icon"></i>
                                        <span x-show="isSidebarExpanded()" x-cloak x-transition.opacity
                                            class="whitespace-nowrap">Social Links</span>
                                    </a>
                                </li>
                                <!--end::SocialLinksLink-->
                            @endif
                        </ul>
                    </div>
                    <!--end::SettingsSubmenu-->
                </li>
                <!--end::SettingsDropdown-->
            @endif
        </ul>
    </nav>
    <!--end::SidebarNav-->
</aside>
<!--end::Sidebar-->
