@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $role);
    $breadcrumb_parent = $breadcrumbsData->where('title','!=',$breadcrumb->title)->last();

    // Bangun data permission untuk Alpine.js
    $permissionData = [];

    // Permission tanpa grup
    foreach ($permissions as $p) {
        $permissionData[] = [
            'id'       => (string)$p->id,
            'name'     => $p->name,
            'group'    => null,
            'checked'  => $role->permissions->contains($p->id),
        ];
    }

    // Permission dengan grup
    $groupData = [];
    foreach ($permission_groups as $grp) {
        $items = [];
        foreach ($grp->permissions as $perm) {
            $items[] = [
                'id'      => (string)$perm->id,
                'name'    => $perm->name,
                'checked' => $role->permissions->contains($perm->id),
            ];
        }
        $groupData[] = [
            'name'             => $grp->name,
            'items'            => $items,
            'menu_group_names' => $grp->menuGroups ? $grp->menuGroups->pluck('name')->implode(', ') : '',
        ];
    }
@endphp

@extends('layouts.backend.main')

@section('title', 'Role Permissions Management')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6 pb-12 font-satoshi-medium" x-data="permissionTree()">
        <!-- Header Banner & Title Card -->
        <div class="bg-white rounded-2xl border border-slate-200/70 p-6 shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-56 h-56 bg-slate-900/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-2xl shadow-md shadow-slate-900/10 shrink-0">
                        <i class="ri-shield-keyhole-line"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <!-- Judul Card Utama: Tetap Bold -->
                            <h4 class="text-xl font-satoshi-bold text-slate-900 tracking-tight">{{ $role->name }}</h4>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-satoshi-medium bg-slate-900/10 text-slate-800">
                                Role Permissions
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1 font-satoshi-medium">Configure granular access privileges and menu group permissions for this role</p>
                    </div>
                </div>

                <!-- Live Search Bar -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative min-w-[260px]">
                        <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Search permission or group..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200/90 rounded-xl text-sm font-satoshi-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/15 focus:border-slate-900 transition-all duration-200" />
                        <button type="button" 
                                x-show="searchQuery.length > 0" 
                                @click="searchQuery = ''"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                            <i class="ri-close-circle-fill text-base"></i>
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Select All / Deselect All Toggle -->
                        <button type="button" 
                                @click="toggleAll()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-satoshi-medium transition-all duration-200 border cursor-pointer select-none"
                                :class="isAllSelected
                                    ? 'bg-slate-900 text-white border-slate-900 hover:bg-slate-800 shadow-sm'
                                    : 'bg-white text-slate-700 border-slate-200/90 hover:bg-slate-50 hover:border-slate-300'">
                            <i class="text-sm" :class="isAllSelected ? 'ri-checkbox-multiple-fill' : 'ri-checkbox-multiple-line'"></i>
                            <span x-text="isAllSelected ? 'Deselect All' : 'Select All'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <form id="formPermission" method="POST" action="{{ $action }}" @submit.prevent="submitForm()" class="space-y-6">
            @csrf
            <input type="hidden" name="permission" id="checkedPermissions">

            <!-- Full Width Selected Privileges Banner -->
            <div class="bg-white rounded-2xl border border-slate-200/70 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 border border-emerald-100/80">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <div>
                        <span class="text-xs font-satoshi-medium text-slate-400 block uppercase tracking-wider">Selected Privileges</span>
                        <span class="text-base font-satoshi-medium text-slate-800">
                            <span class="text-emerald-600 font-satoshi-medium" x-text="checkedCount"></span> of <span x-text="totalCount"></span> Enabled
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-72">
                    <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" :style="`width: ${percentage}%`"></div>
                    </div>
                    <span class="text-xs font-satoshi-medium text-slate-600 min-w-[40px] text-right" x-text="`${percentage}%`"></span>
                </div>
            </div>

            <!-- General Permissions (Ungrouped) -->
            @if(count($permissionData) > 0)
            <div class="bg-white rounded-2xl border border-slate-200/70 p-6 shadow-sm transition-all duration-200" 
                 x-show="matchesSearchGroup('General Permissions', {{ json_encode($permissionData) }})">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                            <i class="ri-key-2-line"></i>
                        </div>
                        <div>
                            <!-- Judul Section: Tetap Bold -->
                            <h6 class="text-sm font-satoshi-bold text-slate-900 tracking-wide uppercase">General Permissions</h6>
                            <p class="text-xs font-satoshi-medium text-slate-400">Standalone user permissions</p>
                        </div>
                    </div>

                    <button type="button" @click="toggleGroup({{ json_encode(collect($permissionData)->pluck('id')) }})"
                            class="text-xs font-satoshi-medium px-3.5 py-1.5 rounded-lg border transition-all duration-200 cursor-pointer"
                            :class="isGroupSelected({{ json_encode(collect($permissionData)->pluck('id')) }})
                                ? 'bg-slate-900 text-white border-slate-900 hover:bg-slate-800'
                                : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'">
                        <span x-text="isGroupSelected({{ json_encode(collect($permissionData)->pluck('id')) }}) ? 'Deselect Group' : 'Select Group'"></span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                    @foreach($permissionData as $perm)
                    <label x-show="matchesSearch('{{ $perm['name'] }}', 'General Permissions')"
                           class="group relative flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 bg-white cursor-pointer transition-all duration-200 hover:border-slate-300 hover:shadow-sm select-none"
                           :class="checked.includes('{{ $perm['id'] }}') && 'border-slate-900 bg-slate-900/[0.02] ring-1 ring-slate-900/10'">
                        <div class="flex items-center gap-3 min-w-0 pr-2">
                            <div class="relative flex items-center">
                                <input type="checkbox" value="{{ $perm['id'] }}"
                                    x-model="checked"
                                    class="peer h-4.5 w-4.5 cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition-all duration-200 checked:border-slate-900 checked:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20" />
                                <span class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-50 text-white opacity-0 transition-all duration-200 peer-checked:scale-100 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </span>
                            </div>
                            <span class="text-sm font-satoshi-medium text-slate-600 group-hover:text-slate-900 truncate transition-colors"
                                  :class="checked.includes('{{ $perm['id'] }}') && '!text-slate-900'">
                                {{ $perm['name'] }}
                            </span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Grouped Permissions -->
            <div class="grid grid-cols-1 gap-6">
                @foreach($groupData as $idx => $group)
                <div class="bg-white rounded-2xl border border-slate-200/70 p-6 shadow-sm transition-all duration-200" 
                     x-data="{ open: true }"
                     x-show="matchesSearchGroup('{{ addslashes($group['name']) }}', {{ json_encode($group['items']) }})">
                    
                    {{-- Header grup --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-slate-100">
                        <button type="button" @click="open = !open" class="flex items-center gap-3 group text-left cursor-pointer select-none">
                            <div class="w-9 h-9 rounded-xl bg-slate-100/80 group-hover:bg-slate-900 group-hover:text-white text-slate-600 flex items-center justify-center text-lg transition-colors shrink-0">
                                <i class="ri-folder-keyhole-line"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <!-- Judul Group/Tabel: Tetap Bold -->
                                    <h6 class="text-sm font-satoshi-bold text-slate-900 tracking-wide uppercase group-hover:text-slate-900 transition-colors">
                                        {{ $group['name'] }}
                                    </h6>

                                    @if(!empty($group['menu_group_names']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-satoshi-medium bg-slate-100/90 text-slate-600 border border-slate-200/60">
                                            <i class="ri-menu-2-line text-slate-400 text-xs"></i>
                                            Menu Group: {{ $group['menu_group_names'] }}
                                        </span>
                                    @endif

                                    <i class="text-slate-400 text-lg transition-transform duration-200"
                                       :class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-right-s-line'"></i>
                                </div>
                                <span class="text-xs font-satoshi-medium text-slate-400">
                                    <span class="text-slate-700" x-text="getGroupCheckedCount({{ json_encode(collect($group['items'])->pluck('id')) }})"></span> of {{ count($group['items']) }} permissions active
                                </span>
                            </div>
                        </button>

                        {{-- Toggle grup --}}
                        <button type="button" @click="toggleGroup({{ json_encode(collect($group['items'])->pluck('id')) }})"
                                class="text-xs font-satoshi-medium px-3.5 py-1.5 rounded-lg border transition-all duration-200 cursor-pointer self-start sm:self-auto"
                                :class="isGroupSelected({{ json_encode(collect($group['items'])->pluck('id')) }})
                                    ? 'bg-slate-900 text-white border-slate-900 hover:bg-slate-800'
                                    : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'">
                            <span x-text="isGroupSelected({{ json_encode(collect($group['items'])->pluck('id')) }}) ? 'Deselect Group' : 'Select Group'"></span>
                        </button>
                    </div>

                    {{-- Items grid --}}
                    <div x-show="open" x-collapse class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                        @foreach($group['items'] as $perm)
                        @php
                            $actionName = strtolower($perm['name']);
                            $badgeClass = 'bg-slate-100/80 text-slate-600 border-slate-200/80';
                            $badgeLabel = 'Action';

                            if (str_contains($actionName, 'access')) {
                                $badgeClass = 'bg-sky-50 text-sky-700 border-sky-200/80';
                                $badgeLabel = 'Access';
                            } elseif (str_contains($actionName, 'create')) {
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                                $badgeLabel = 'Create';
                            } elseif (str_contains($actionName, 'update')) {
                                $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200/80';
                                $badgeLabel = 'Update';
                            } elseif (str_contains($actionName, 'delete')) {
                                $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200/80';
                                $badgeLabel = 'Delete';
                            } elseif (str_contains($actionName, 'detail')) {
                                $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200/80';
                                $badgeLabel = 'Detail';
                            }
                        @endphp
                        <label x-show="matchesSearch('{{ $perm['name'] }}', '{{ addslashes($group['name']) }}')"
                               class="group relative flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 bg-white cursor-pointer transition-all duration-200 hover:border-slate-300 hover:shadow-sm select-none"
                               :class="checked.includes('{{ $perm['id'] }}') && 'border-slate-900 bg-slate-900/[0.02] ring-1 ring-slate-900/10'">
                            <div class="flex items-center gap-3 min-w-0 pr-2">
                                <div class="relative flex items-center">
                                    <input type="checkbox" value="{{ $perm['id'] }}"
                                        x-model="checked"
                                        class="peer h-4.5 w-4.5 cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition-all duration-200 checked:border-slate-900 checked:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20" />
                                    <span class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-50 text-white opacity-0 transition-all duration-200 peer-checked:scale-100 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </span>
                                </div>
                                <span class="text-sm font-satoshi-medium text-slate-600 group-hover:text-slate-900 truncate transition-colors"
                                      :class="checked.includes('{{ $perm['id'] }}') && '!text-slate-900'">
                                    {{ $perm['name'] }}
                                </span>
                            </div>
                            
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-satoshi-medium border uppercase shrink-0 {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Standard Form Footer Action Card using x-ui.button -->
            <div class="bg-white rounded-2xl border border-slate-200/70 p-6 shadow-sm flex items-center justify-between gap-4">
                <div class="text-sm font-satoshi-medium text-slate-500">
                    <span class="text-slate-900 font-satoshi-medium" x-text="checkedCount"></span> of <span class="text-slate-900 font-satoshi-medium" x-text="totalCount"></span> permissions selected
                </div>
                
                <div class="flex items-center gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ url('role') }}'">
                        Cancel
                    </x-ui.button>
                    <x-ui.button type="submit" font="medium" size="sm">
                        Save
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('permissionTree', () => {
        // Kumpulkan semua ID permission
        const allIds = {!! json_encode(
            collect($permissionData)->pluck('id')
                ->merge(collect($groupData)->flatMap(fn($g) => collect($g['items'])->pluck('id')))
                ->values()
        ) !!};

        // Kumpulkan ID yang sudah terpilih
        const initialChecked = {!! json_encode(
            collect($permissionData)->where('checked', true)->pluck('id')
                ->merge(collect($groupData)->flatMap(fn($g) => collect($g['items'])->where('checked', true)->pluck('id')))
                ->values()
        ) !!};

        return {
            checked: initialChecked.map(String),
            allIds: allIds.map(String),
            searchQuery: '',

            get totalCount() { return this.allIds.length; },
            get checkedCount() { return this.checked.length; },
            get percentage() { return this.totalCount > 0 ? Math.round((this.checkedCount / this.totalCount) * 100) : 0; },
            get isAllSelected() { return this.allIds.length > 0 && this.allIds.every(id => this.checked.includes(id)); },

            toggleAll() {
                if (this.isAllSelected) {
                    this.checked = [];
                } else {
                    this.checked = [...this.allIds];
                }
            },

            isGroupSelected(ids) {
                return ids.length > 0 && ids.every(id => this.checked.includes(String(id)));
            },

            getGroupCheckedCount(ids) {
                return ids.filter(id => this.checked.includes(String(id))).length;
            },

            toggleGroup(ids) {
                const strIds = ids.map(String);
                if (this.isGroupSelected(strIds)) {
                    this.checked = this.checked.filter(id => !strIds.includes(id));
                } else {
                    const toAdd = strIds.filter(id => !this.checked.includes(id));
                    this.checked = [...this.checked, ...toAdd];
                }
            },

            matchesSearch(permName, groupName) {
                if (!this.searchQuery.trim()) return true;
                const query = this.searchQuery.toLowerCase();
                return permName.toLowerCase().includes(query) || groupName.toLowerCase().includes(query);
            },

            matchesSearchGroup(groupName, items) {
                if (!this.searchQuery.trim()) return true;
                const query = this.searchQuery.toLowerCase();
                if (groupName.toLowerCase().includes(query)) return true;
                return items.some(item => item.name.toLowerCase().includes(query));
            },

            submitForm() {
                document.getElementById('checkedPermissions').value = this.checked.join(',');
                document.getElementById('formPermission').submit();
            }
        };
    });
});
</script>
@endpush