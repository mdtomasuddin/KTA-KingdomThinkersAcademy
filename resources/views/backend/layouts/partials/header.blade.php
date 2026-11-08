<!--begin: Header-->
<header role="banner"
    class="sticky top-0 z-30 bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-800 shadow-sm">
    <!--begin: Header Inner Wrapper-->
    <div class="flex items-center justify-between h-16 px-4 lg:px-6">
        <!--begin: Header Left Section-->
        <div class="flex items-center gap-3">
            <button @click="toggleSidebar()"
                class="hidden lg:flex w-10 h-10 items-center justify-center rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200"
                :title="sidebarOpen ? 'Collapse Sidebar' : 'Expand Sidebar'" :aria-expanded="sidebarOpen">
                <i class="fa-solid fa-bars-staggered text-lg"></i>
            </button>
            <button @click="mobileSidebarOpen = true"
                class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
                aria-label="Open sidebar" :aria-expanded="mobileSidebarOpen">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
        <!--end: Header Left Section-->

        <!--begin: Header Right Section-->
        <div class="flex items-center gap-1 sm:gap-2">

            <button onclick="toggleFullscreen()"
                class="hidden sm:flex w-10 h-10 items-center justify-center rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
                title="Fullscreen">
                <i class="fa-solid fa-expand text-lg"></i>
            </button>
            <button @click="toggleDarkMode()"
                class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
                :title="darkMode ? 'Light Mode' : 'Dark Mode'">
                <i x-show="!darkMode" class="fa-solid fa-moon text-lg"></i>
                <i x-show="darkMode" class="fa-solid fa-sun text-lg text-yellow-400"></i>
            </button>

            <!--begin: Notifications Bell Wrapper-->
            @php
                $headerUser = Auth::user();
                $unreadNotificationCount = $headerUser ? $headerUser->unreadNotifications()->count() : 0;
            @endphp
            <div class="relative" @click.outside="notificationsOpen = false">
                <button @click="notificationsOpen = !notificationsOpen"
                    class="relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
                    title="Notifications" :aria-expanded="notificationsOpen">
                    <i class="fa-regular fa-bell text-lg"></i>
                    @if ($unreadNotificationCount > 0)
                        <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white dark:ring-gray-950"></span>
                    @endif
                </button>
                @include('backend.layouts.partials.notifications_dropdown')
            </div>
            <!--end: Notifications Bell Wrapper-->

            <!--begin: Profile Dropdown Wrapper-->
            @php
                $headerUser = Auth::user();
                $headerInitial = strtoupper(substr($headerUser?->first_name ?: 'A', 0, 1));
                $headerAvatar = $headerUser?->avatar;
                $headerHasAvatar = !is_null($headerAvatar);
            @endphp
            <div class="relative" @click.outside="profileDropdownOpen = false">
                <button @click="profileDropdownOpen = !profileDropdownOpen"
                    class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 group">
                    <!--begin: Profile Avatar-->
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-sm font-bold shadow-md ring-2 ring-white dark:ring-gray-950 overflow-hidden flex-shrink-0">
                        @if ($headerHasAvatar)
                            <img src="{{ $headerAvatar }}" alt="{{ $headerUser->first_name ?? '' }}"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-sm font-bold"
                                style="display:none">{{ $headerInitial }}</div>
                        @else
                            {{ $headerInitial }}
                        @endif
                    </div>
                    <!--end: Profile Avatar-->
                    <!--begin: Profile Name Area-->
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white leading-tight">
                            {{ trim(($headerUser->first_name ?? 'User') . ' ' . ($headerUser->last_name ?? '')) }}</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 leading-tight">
                            {{ ucfirst($headerUser->role ?? 'Admin') }}</p>
                    </div>
                    <!--end: Profile Name Area-->
                    <i
                        class="hidden lg:block fa-solid fa-chevron-down text-[10px] text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors"></i>
                </button>
                @include('backend.layouts.partials.profile_dropdown')
            </div>
            <!--end: Profile Dropdown Wrapper-->
        </div>
        <!--end: Header Right Section-->
    </div>
    <!--end: Header Inner Wrapper-->

</header>
<!--end: Header-->
