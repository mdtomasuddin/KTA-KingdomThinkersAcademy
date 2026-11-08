@php
    $headerUser      = Auth::user();
    $dbNotifications = $headerUser ? $headerUser->notifications()->latest()->take(10)->get() : collect();
    $unreadCount     = $headerUser ? $headerUser->unreadNotifications()->count() : 0;
@endphp
<!--begin: Notifications Dropdown Container-->
<div x-show="notificationsOpen" x-cloak @click.outside="notificationsOpen = false"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-900 rounded-2xl shadow-dropdown border border-gray-200 dark:border-gray-700 overflow-hidden origin-top-right z-50">
    <!--begin: Notifications Header-->
    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Notifications</h3>
            @if ($unreadCount > 0)
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ $unreadCount }} new</span>
            @endif
        </div>
    </div>
    <!--end: Notifications Header-->
    <!--begin: Notifications List-->
    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($dbNotifications as $n)
            @php
                $cat      = $n->category ?? ($n->data['category'] ?? 'system');
                $title    = $n->data['title'] ?? 'Notification';
                $desc     = $n->data['message'] ?? ($n->data['body'] ?? '');
                $isUnread = is_null($n->read_at);
                $timeAgo  = $n->created_at ? $n->created_at->diffForHumans() : '';

                $iconConfig = match ($cat) {
                    'announcement' => ['icon' => 'fa-solid fa-bullhorn', 'color' => 'text-amber-500', 'bg' => 'bg-amber-100 dark:bg-amber-900/30'],
                    'academic'     => ['icon' => 'fa-solid fa-graduation-cap', 'color' => 'text-cyan-500', 'bg' => 'bg-cyan-100 dark:bg-cyan-900/30'],
                    'security'     => ['icon' => 'fa-solid fa-shield-halved', 'color' => 'text-rose-500', 'bg' => 'bg-rose-100 dark:bg-rose-900/30'],
                    default        => ['icon' => 'fa-solid fa-bell', 'color' => 'text-primary-500', 'bg' => 'bg-primary-100 dark:bg-primary-900/30'],
                };
            @endphp
            <div class="flex items-start gap-3 px-4 py-3 {{ $isUnread ? 'bg-primary-50/40 dark:bg-primary-900/10' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl {{ $iconConfig['bg'] }} flex items-center justify-center">
                    <i class="{{ $iconConfig['icon'] }} {{ $iconConfig['color'] }} text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 dark:text-white truncate">{{ $title }}</p>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">{{ $desc }}</p>
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">{{ $timeAgo }}</p>
                </div>
                @if ($isUnread)
                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-primary-500 mt-1.5"></span>
                @endif
            </div>
        @empty
            <div class="py-8 text-center text-gray-400 dark:text-gray-500">
                <i class="fa-regular fa-bell-slash text-2xl mb-2 opacity-50 block"></i>
                <p class="text-xs font-medium">No notifications yet</p>
            </div>
        @endforelse
    </div>
    <!--end: Notifications List-->
</div>
<!--end: Notifications Dropdown Container-->
