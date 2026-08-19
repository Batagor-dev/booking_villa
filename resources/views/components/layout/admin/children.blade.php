@php
    use App\Helpers\MenuHelper;

    $permissionGroup = optional($menu->permissionGroup)->name;
    $permissionName  = $permissionGroup ? ($permissionGroup . ' Access') : null;
    $canAccess       = !$permissionName || (auth()->check() && auth()->user()->can($permissionName));

    $isActive = MenuHelper::isActive($menu);
    $hasChildren = $menu->children->isNotEmpty();
    $uniqueId = 'menu-' . str_replace('.', '-', $menu->uuid ?? uniqid());
@endphp

@if($canAccess)
    @if($hasChildren)
        @php
            $visibleChildren = $menu->children->filter(function($child) {
                $cPermName = optional($child->permissionGroup)->name ? (optional($child->permissionGroup)->name . ' Access') : null;
                return !$cPermName || (auth()->check() && auth()->user()->can($cPermName));
            });
        @endphp

        @if($visibleChildren->count() > 0)
            <li class="w-full">
                <button 
                    type="button" 
                    data-sidebar-toggle 
                    data-target="{{ $uniqueId }}"
                    aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                    class="group/menu w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-base font-satoshi-medium transition-all duration-200 cursor-pointer min-w-0 {{ $isActive ? 'bg-slate-50 text-slate-900' : 'text-slate-600 hover:bg-slate-50/70 hover:text-slate-900' }}"
                >
                    <span class="flex items-center gap-3 min-w-0 text-left">
                        @if($menu->icon)
                            <i class="{{ $menu->icon }} text-xl w-5 flex-shrink-0 text-center transition-colors duration-200 {{ $isActive ? 'text-slate-900' : 'text-slate-400 group-hover/menu:text-slate-600' }}"></i>
                        @else
                            <i class="ri-circle-fill text-[10px] w-5 flex-shrink-0 text-center transition-colors duration-200 {{ $isActive ? 'text-slate-900' : 'text-slate-400 group-hover/menu:text-slate-600' }}"></i>
                        @endif
                        <span class="truncate">{{ $menu->nama_menu }}</span>
                    </span>
                    <i class="ri-arrow-down-s-line text-base text-slate-400 flex-shrink-0 transition-transform duration-300 group-aria-expanded:rotate-180 group-hover/menu:text-slate-600"></i>
                </button>
                
                <ul 
                    id="{{ $uniqueId }}"
                    class="overflow-hidden transition-all duration-300 ease-in-out pl-2.5 ml-3 mt-1 border-l border-slate-100 space-y-1"
                    style="{{ $isActive ? '' : 'max-height: 0px;' }}"
                >
                    @foreach($visibleChildren as $child)
                        @include('components.layout.admin.children', ['menu' => $child])
                    @endforeach
                </ul>
            </li>
        @endif
    @else
        <li class="w-full">
            <a 
                href="{{ $menu->href ?? '#' }}" 
                class="group/menu flex items-center justify-between px-3 py-2.5 rounded-xl text-base font-satoshi-medium transition-all duration-200 min-w-0 {{ $isActive ? 'bg-slate-900 text-white shadow-md shadow-slate-900/10' : 'text-slate-600 hover:bg-slate-50/70 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3 min-w-0">
                    @if($menu->icon)
                        <i class="{{ $menu->icon }} text-xl w-5 flex-shrink-0 text-center transition-colors duration-200 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover/menu:text-slate-600' }}"></i>
                    @else
                        <i class="ri-circle-fill text-[10px] w-5 flex-shrink-0 text-center transition-colors duration-200 {{ $isActive ? 'text-white' : 'text-slate-300 group-hover/menu:text-slate-500' }}"></i>
                    @endif
                    <span class="truncate text-left">{{ $menu->nama_menu }}</span>
                </div>

                @if(isset($menu->href) && (str_contains($menu->href, 'bookings') || strtolower($menu->nama_menu) === 'bookings'))
                    <span 
                        id="sidebar-booking-badge" 
                        class="admin-booking-badge inline-flex items-center justify-center px-2 py-0.5 text-xs font-satoshi-bold rounded-full transition-all duration-300 {{ ($unreadNotifCount ?? 0) > 0 ? 'bg-rose-500 text-white shadow-sm ring-2 ring-rose-200 animate-pulse' : 'hidden' }}"
                        data-count="{{ $unreadNotifCount ?? 0 }}"
                    >
                        {{ $unreadNotifCount ?? 0 }}
                    </span>
                @endif
            </a>
        </li>
    @endif
@endif
