@php
  $appSettings = settings();
@endphp
<!doctype html>
<html lang="en" class="h-full bg-[#f7f7f7]">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ $appSettings['title'] ?? config('app.name') }}</title>
    <meta name="author" content="{{ $appSettings['author'] ?? '' }}">
    <meta name="description" content="{{ $appSettings['description'] ?? '' }}">
    <link rel="icon" type="image/png"
      href="{{ !empty($appSettings['favicon']) ? asset('storage/' . $appSettings['favicon']) : asset('images/no-image.png') }}">

    <!-- Preconnect & Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    {{-- Local Vendor Assets (Fast & Offline Ready) --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" />

    {{-- Data Table --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/responsive.dataTables.min.css') }}">

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}"/>

    {{-- Alpine.js --}}
    <script defer src="{{ asset('assets/vendor/alpine/alpine.min.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>
  <body class="min-h-screen text-slate-900 antialiased flex font-satoshi-medium" data-admin-panel="true">
    <!-- Sidebar component -->
    <x-layout.admin.sidebar />

    <!-- Main Container -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-[280px] min-h-screen">
      <!-- Header component -->
      <x-layout.admin.header :sub_title="View::yieldContent('sub_title')" />

      <!-- Main Body -->
      <main class="flex-1 p-6 md:p-8 flex flex-col">
        <!-- Breadcrumb section -->
        <div class="mb-6">
          @yield('breadcrumb')
        </div>

        <!-- Content slot -->
        <div class="flex-1 ">
          @yield('content')
        </div>
      </main>

      <!-- Footer component -->
      <x-layout.admin.footer />
    </div>

    <script>
      function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar && overlay) {
          const isHidden = sidebar.classList.contains('-translate-x-full');
          if (isHidden) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
          } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
          }
        }
      }
    </script>

    {{-- jQuery --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>

    {{-- Data table --}}
    <script src="{{ asset('assets/vendor/datatables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.responsive.min.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    
    {{-- Custom Components --}}
    <x-ui.notification />
    <x-ui.modal-confirm />

    {{-- Live Admin Notification Poller --}}
    <script>
      (function() {
        let lastNotifId = {{ \App\Models\AdminNotification::max('id') ?? 0 }};
        let isFirstLoad = true;

        function updateBadges(unreadCount) {
          // 1. Sidebar Booking Menu Badge
          document.querySelectorAll('.admin-booking-badge').forEach(badge => {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            if (unreadCount > 0) {
              badge.classList.remove('hidden');
            } else {
              badge.classList.add('hidden');
            }
          });

          // 2. Sidebar Dedicated Notif Menu Badge & Dot
          document.querySelectorAll('.admin-notif-badge').forEach(badge => {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            if (unreadCount > 0) {
              badge.classList.remove('hidden');
            } else {
              badge.classList.add('hidden');
            }
          });
          document.querySelectorAll('.admin-notif-dot').forEach(dot => {
            if (unreadCount > 0) {
              dot.classList.remove('hidden');
            } else {
              dot.classList.add('hidden');
            }
          });

          // 3. Header Bell Badge & Ping
          document.querySelectorAll('.header-notif-badge').forEach(badge => {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            if (unreadCount > 0) {
              badge.classList.remove('hidden');
            } else {
              badge.classList.add('hidden');
            }
          });
          document.querySelectorAll('.header-notif-ping').forEach(ping => {
            if (unreadCount > 0) {
              ping.classList.remove('hidden');
            } else {
              ping.classList.add('hidden');
            }
          });

          // 4. Panel Header Count
          const panelCount = document.getElementById('notif-panel-count');
          if (panelCount) {
            panelCount.textContent = unreadCount + ' Baru';
          }
        }

        function renderNotificationList(items) {
          const container = document.getElementById('notification-list-container');
          if (!container || !items) return;

          if (items.length === 0) {
            container.innerHTML = `
              <div id="notif-empty-state" class="py-10 px-4 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-3">
                  <i class="ri-notification-off-line text-2xl"></i>
                </div>
                <p class="text-xs font-satoshi-bold text-slate-700">Belum ada notifikasi pesanan</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Pesanan baru dan pembatalan akan muncul di sini</p>
              </div>
            `;
            return;
          }

          let html = '';
          items.forEach(item => {
            const isCancelled = item.type === 'order_cancelled';
            const isConfirmed = item.type === 'order_confirmed';
            
            const iconBg = isCancelled ? 'bg-rose-50 text-rose-600 border border-rose-100' : (isConfirmed ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100');
            const iconClass = isCancelled ? 'ri-close-circle-line' : (isConfirmed ? 'ri-checkbox-circle-line' : 'ri-calendar-check-line');
            const titleColor = isCancelled ? 'text-rose-600' : (isConfirmed ? 'text-indigo-600' : 'text-emerald-600');
            const unreadBg = item.is_unread ? 'bg-amber-50/25' : '';

            let snapshotHtml = '';
            if (item.property_name || item.total_price) {
              snapshotHtml = `<div class="mt-2 flex flex-wrap items-center gap-1.5 text-[11px]">`;
              if (item.booking_code) {
                snapshotHtml += `<span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono font-bold">#${item.booking_code}</span>`;
              }
              if (item.property_name) {
                snapshotHtml += `<span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 truncate max-w-[120px]">${item.property_name}</span>`;
              }
              if (item.total_price) {
                snapshotHtml += `<span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold">${item.total_price}</span>`;
              }
              snapshotHtml += `</div>`;
            }

            const unreadDot = item.is_unread ? `<span class="h-2 w-2 rounded-full bg-rose-500 shrink-0 mt-1.5"></span>` : '';

            html += `
              <a href="${item.read_url}" class="flex items-start gap-3 p-3.5 hover:bg-slate-50/80 transition-colors ${unreadBg}">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl ${iconBg}">
                  <i class="${iconClass} text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-1 mb-0.5">
                    <span class="text-xs font-satoshi-bold ${titleColor}">${item.title}</span>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">${item.created_at_human}</span>
                  </div>
                  <p class="text-xs font-satoshi-medium text-slate-800 line-clamp-2 leading-relaxed">${item.message}</p>
                  ${snapshotHtml}
                </div>
                ${unreadDot}
              </a>
            `;
          });

          container.innerHTML = html;
        }

        function pollFeed() {
          const url = "{{ route('admin.notifications.feed') }}?last_id=" + lastNotifId;
          fetch(url, {
            headers: {
              'Accept': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            updateBadges(data.unread_count);

            if (data.latest) {
              renderNotificationList(data.latest);
            }

            // If there are newly arrived notifications while admin is on page, show toast!
            if (!isFirstLoad && data.new_items && data.new_items.length > 0) {
              data.new_items.forEach(newItem => {
                const toastType = newItem.type === 'order_cancelled' ? 'danger' : 'success';
                const toastMsg = newItem.title + ': ' + newItem.message;
                
                if (window.dispatchEvent) {
                  window.dispatchEvent(new CustomEvent('show-toast', {
                    detail: { type: toastType, message: toastMsg }
                  }));
                }
              });
            }

            if (data.latest_id) {
              lastNotifId = data.latest_id;
            }
            isFirstLoad = false;
          })
          .catch(err => {
            // Silently ignore network interruptions
          });
        }

        // Run poller every 20 seconds
        setInterval(pollFeed, 20000);
      })();
    </script>

    @stack('scripts')
  </body>
</html>
