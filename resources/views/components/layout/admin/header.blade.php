@props(['sub_title' => ''])

<header id="admin-header" class="sticky top-0 z-50 flex h-20 items-center bg-white justify-between px-10 lg:px-16 xl:px-20 py-10">
  <div class="flex items-center gap-4">
    <!-- Mobile Sidebar Toggle -->
    <button type="button" class="lg:hidden text-slate-500 hover:text-slate-900 transition-colors cursor-pointer" onclick="toggleSidebar()">
      <i class="ri-menu-2-line text-2xl"></i>
    </button>
    
    @if($sub_title)
      <h2 class="text-3xl font-satoshi-bold text-slate-900 truncate max-w-[200px] sm:max-w-md">{{ $sub_title }}</h2>
    @endif
  </div>

  <div class="flex items-center gap-3 sm:gap-4">
    <!-- Fullscreen Button -->
    <button type="button" id="btn-fullscreen" class="hidden sm:flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all cursor-pointer">
      <i class="ri-fullscreen-line text-2xl"></i>
    </button>

    <!-- Notification Center Dropdown -->
    <div class="relative" id="notification-dropdown-wrapper">
      <button 
        type="button" 
        id="btn-notification-dropdown" 
        class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all cursor-pointer"
        onclick="toggleNotificationDropdown()"
        aria-label="Notifikasi"
      >
        <i class="ri-notification-3-line text-2xl"></i>
        
        <!-- Pulse Indicator for Unread -->
        <span 
          id="header-notif-ping"
          class="header-notif-ping absolute top-1.5 right-1.5 flex h-2.5 w-2.5 {{ ($unreadNotifCount ?? 0) > 0 ? '' : 'hidden' }}"
        >
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
        </span>

        <!-- Badge Counter -->
        <span 
          id="header-notif-badge" 
          class="header-notif-badge absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-satoshi-bold text-white shadow-xs ring-2 ring-white {{ ($unreadNotifCount ?? 0) > 0 ? '' : 'hidden' }}"
        >
          {{ ($unreadNotifCount ?? 0) > 99 ? '99+' : ($unreadNotifCount ?? 0) }}
        </span>
      </button>

      <!-- Notification Dropdown Panel -->
      <div 
        id="notification-dropdown" 
        class="absolute right-0 mt-2 w-80 sm:w-96 origin-top-right rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-300/40 transition-all scale-95 opacity-0 pointer-events-none z-50 overflow-hidden"
      >
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3.5 border-b border-slate-100 bg-slate-50/50">
          <div class="flex items-center gap-2">
            <h3 class="text-sm font-satoshi-bold text-slate-900">Notifikasi Pesanan</h3>
            <span id="notif-panel-count" class="px-2 py-0.5 text-[11px] font-satoshi-bold rounded-full bg-slate-200 text-slate-700">
              {{ $unreadNotifCount ?? 0 }} Baru
            </span>
          </div>

          <button 
            type="button" 
            onclick="markAllNotificationsAsRead()"
            class="text-xs font-satoshi-bold text-[#ca9e54] hover:text-[#b08842] transition-colors cursor-pointer"
          >
            Tandai Dibaca
          </button>
        </div>

        <!-- Notification List -->
        <div id="notification-list-container" class="max-h-[380px] overflow-y-auto divide-y divide-slate-100">
          @if(isset($recentAdminNotifs) && $recentAdminNotifs->count() > 0)
            @foreach($recentAdminNotifs as $notif)
              @php
                $data = $notif->data ?? [];
                $isCancelled = $notif->type === 'order_cancelled';
                $isConfirmed = $notif->type === 'order_confirmed';
                $isNew = $notif->type === 'order_created';
                $isUnread = $notif->isUnread();
              @endphp

              <a 
                href="{{ route('admin.notifications.read', $notif->uuid) }}" 
                class="flex items-start gap-3 p-3.5 hover:bg-slate-50/80 transition-colors {{ $isUnread ? 'bg-amber-50/25' : '' }}"
              >
                <!-- Icon -->
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $isCancelled ? 'bg-rose-50 text-rose-600 border border-rose-100' : ($isConfirmed ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100') }}">
                  @if($isCancelled)
                    <i class="ri-close-circle-line text-lg"></i>
                  @elseif($isConfirmed)
                    <i class="ri-checkbox-circle-line text-lg"></i>
                  @else
                    <i class="ri-calendar-check-line text-lg"></i>
                  @endif
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-1 mb-0.5">
                    <span class="text-xs font-satoshi-bold {{ $isCancelled ? 'text-rose-600' : ($isConfirmed ? 'text-indigo-600' : 'text-emerald-600') }}">
                      {{ $notif->title }}
                    </span>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                  </div>

                  <p class="text-xs font-satoshi-medium text-slate-800 line-clamp-2 leading-relaxed">
                    {{ $notif->message }}
                  </p>

                  <!-- Snapshot Badges / Details -->
                  @if(!empty($data['property_name']) || !empty($data['total_price']))
                    <div class="mt-2 flex flex-wrap items-center gap-1.5 text-[11px]">
                      @if(!empty($data['booking_code']))
                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono font-bold">
                          #{{ $data['booking_code'] }}
                        </span>
                      @endif

                      @if(!empty($data['property_name']))
                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 truncate max-w-[120px]">
                          {{ $data['property_name'] }}
                        </span>
                      @endif

                      @if(!empty($data['total_price']))
                        <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold">
                          Rp {{ number_format($data['total_price'], 0, ',', '.') }}
                        </span>
                      @endif
                    </div>
                  @endif
                </div>

                <!-- Unread indicator dot -->
                @if($isUnread)
                  <span class="h-2 w-2 rounded-full bg-rose-500 shrink-0 mt-1.5"></span>
                @endif
              </a>
            @endforeach
          @else
            <!-- Empty State -->
            <div id="notif-empty-state" class="py-10 px-4 text-center">
              <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-3">
                <i class="ri-notification-off-line text-2xl"></i>
              </div>
              <p class="text-xs font-satoshi-bold text-slate-700">Belum ada notifikasi pesanan</p>
              <p class="text-[11px] text-slate-400 mt-0.5">Pesanan baru dan pembatalan akan muncul di sini</p>
            </div>
          @endif
        </div>

        <!-- Footer -->
        <div class="p-2.5 border-t border-slate-100 bg-slate-50/50 text-center">
          <a 
            href="{{ route('admin.notifications.index') }}" 
            class="inline-flex items-center justify-center gap-1.5 w-full py-1.5 text-xs font-satoshi-bold text-slate-700 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-colors"
          >
            <span>Lihat Semua Riwayat Notifikasi</span>
            <i class="ri-arrow-right-line text-sm"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- User Profile Dropdown -->
    <div class="relative" id="profile-dropdown-wrapper">
      <button type="button" id="btn-profile-dropdown" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-slate-50 transition-all cursor-pointer" onclick="toggleProfileDropdown()">
        @php
            $avatar = Auth::user()->foto && str_starts_with(Auth::user()->foto, 'http')
                ? Auth::user()->foto
                : (Auth::user()->foto && str_starts_with(Auth::user()->foto, 'avatar-')
                    ? asset('assets/img/avatar/' . Auth::user()->foto)
                    : (Auth::user()->foto 
                        ? asset('storage/uploads/users/' . Auth::user()->foto) 
                        : asset('assets/img/avatar/avatar-1.jpg')));
        @endphp
        
        <div class="relative">
          <img
              src="{{ asset($avatar) }}"
              alt="{{ Auth::user()->name }}"
              class="h-12 w-12 rounded-full object-cover border border-slate-100 shadow-xs"
          >

          <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full bg-emerald-500 border-2 border-white"></span>
      </div>
      </button>

      <!-- Dropdown Card -->
      <div id="profile-dropdown" class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-200/50 transition-all scale-95 opacity-0 pointer-events-none z-50">
        <!-- User Info Header -->
        <div class="flex items-center gap-3 px-4 py-3 border-b border-slate-100">
            <img
                src="{{ asset($avatar) }}"
                alt="{{ Auth::user()->name }}"
                class="h-12 w-12 rounded-full object-cover border border-slate-200 shadow-sm flex-shrink-0"
            >

            <div class="min-w-0 flex-1">
                <h3 class="text-sm font-satoshi-bold text-slate-900 truncate">
                    {{ Auth::user()->name }}
                </h3>

                <p class="mt-0.5 text-xs font-satoshi-medium text-slate-500 truncate">
                    {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                </p>
            </div>
        </div>

        <!-- Links -->
        <a href="{{ route('acount.index') }}" class="flex items-center font-satoshi-medium gap-2.5 px-3 py-2 rounded-xl text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
          <i class="ri-user-3-line text-lg text-slate-400"></i>
          <span>My Profile</span>
        </a>

        <div class="border-t border-slate-100 my-1"></div>

        <!-- Logout Button -->
        <button 
          type="button" 
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="w-full flex items-center justify-center font-satoshi-semibold gap-2.5 px-3 py-1 rounded-lg text-sm bg-rose-600 text-white hover:bg-rose-700 transition-colors cursor-pointer text-left"
        >
        <span>Logout</span>
        <i class="ri-logout-box-r-line text-lg text-white"></i>
        </button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
          @csrf
        </form>
      </div>
    </div>
  </div>
</header>

@push('scripts')
<script>
  function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown');
    const notifDropdown = document.getElementById('notification-dropdown');
    
    // Close notif dropdown if open
    if (notifDropdown && !notifDropdown.classList.contains('pointer-events-none')) {
      notifDropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      notifDropdown.classList.remove('scale-100', 'opacity-100');
    }

    const isClosed = dropdown.classList.contains('pointer-events-none');
    if (isClosed) {
      dropdown.classList.remove('pointer-events-none', 'scale-95', 'opacity-0');
      dropdown.classList.add('scale-100', 'opacity-100');
    } else {
      dropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      dropdown.classList.remove('scale-100', 'opacity-100');
    }
  }

  function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notification-dropdown');
    const profileDropdown = document.getElementById('profile-dropdown');

    // Close profile dropdown if open
    if (profileDropdown && !profileDropdown.classList.contains('pointer-events-none')) {
      profileDropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      profileDropdown.classList.remove('scale-100', 'opacity-100');
    }

    if (!dropdown) return;
    const isClosed = dropdown.classList.contains('pointer-events-none');

    if (isClosed) {
      dropdown.classList.remove('pointer-events-none', 'scale-95', 'opacity-0');
      dropdown.classList.add('scale-100', 'opacity-100');
    } else {
      dropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      dropdown.classList.remove('scale-100', 'opacity-100');
    }
  }

  // Close dropdowns on click outside
  window.addEventListener('click', function(e) {
    const profileWrapper = document.getElementById('profile-dropdown-wrapper');
    const profileDropdown = document.getElementById('profile-dropdown');
    if (profileWrapper && profileDropdown && !profileWrapper.contains(e.target)) {
      profileDropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      profileDropdown.classList.remove('scale-100', 'opacity-100');
    }

    const notifWrapper = document.getElementById('notification-dropdown-wrapper');
    const notifDropdown = document.getElementById('notification-dropdown');
    if (notifWrapper && notifDropdown && !notifWrapper.contains(e.target)) {
      notifDropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
      notifDropdown.classList.remove('scale-100', 'opacity-100');
    }
  });

  // Mark all notifications as read via AJAX
  function markAllNotificationsAsRead() {
    fetch("{{ route('admin.notifications.mark-all-read') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      // Update UI badges
      document.querySelectorAll('.header-notif-ping, .admin-notif-dot').forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('.header-notif-badge, .admin-notif-badge, .admin-booking-badge').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '0';
      });

      const panelCount = document.getElementById('notif-panel-count');
      if (panelCount) panelCount.textContent = '0 Baru';

      // Remove unread dots in dropdown
      document.querySelectorAll('#notification-list-container .bg-rose-500.rounded-full').forEach(el => el.remove());
      document.querySelectorAll('#notification-list-container .bg-amber-50\\/25').forEach(el => el.classList.remove('bg-amber-50/25'));

      if (window.dispatchEvent) {
        window.dispatchEvent(new CustomEvent('show-toast', {
          detail: { type: 'success', message: 'Semua notifikasi telah ditandai sebagai dibaca.' }
        }));
      }
    })
    .catch(err => {
      console.error('Failed to mark all as read:', err);
    });
  }

  // Fullscreen support
  document.addEventListener("DOMContentLoaded", function () {
      const btnFullscreen = document.getElementById("btn-fullscreen");
      if (btnFullscreen) {
          btnFullscreen.addEventListener("click", function () {
              if (!document.fullscreenElement) {
                  document.documentElement.requestFullscreen().catch(err => {
                      console.error(`Error attempting to enable full-screen mode: ${err.message}`);
                  });
                  this.querySelector("i").classList.replace("ri-fullscreen-line", "ri-fullscreen-exit-line");
              } else {
                  document.exitFullscreen();
                  this.querySelector("i").classList.replace("ri-fullscreen-exit-line", "ri-fullscreen-line");
              }
          });
      }
  });
</script>
@endpush