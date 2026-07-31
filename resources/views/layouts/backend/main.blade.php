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
  <body class="min-h-screen text-slate-900 antialiased flex font-satoshi" data-admin-panel="true">
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

    @stack('scripts')
  </body>
</html>
