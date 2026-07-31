<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['components.layout.admin.sidebar', 'layout.backend.sidebar'], function ($view) {
            static $cachedMenuData = null;

            if ($cachedMenuData === null) {
                $cachedMenuData = Cache::remember('admin_sidebar_menus', 3600, function () {
                    $menus = Menu::whereNull('menu_id')
                        ->where('status', 1)
                        ->with(['children.permissionGroup', 'menuGroup.permissionGroup', 'permissionGroup'])
                        ->get();

                    $groupedMenus = $menus->groupBy(function($menu) {
                        return $menu->menu_group_id ?? 0;
                    })->sortBy(function($items, $groupId) {
                        if ($groupId == 0) return 9999;
                        return $items->first()?->menuGroup?->sort ?? 999;
                    });

                    return compact('menus', 'groupedMenus');
                });
            }

            $view->with('groupedMenus', $cachedMenuData['groupedMenus']);
            $view->with('menus', $cachedMenuData['menus']);
        });
    }

    public function register()
    {
        //
    }
}