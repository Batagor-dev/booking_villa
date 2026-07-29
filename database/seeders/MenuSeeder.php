<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuGroup;
use App\Models\PermissionGroup;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $kontenGroup     = MenuGroup::where('name', 'Content Management')->first();
        $propertyGroup   = MenuGroup::where('name', 'Property Management')->first();
        $pengaturanGroup = MenuGroup::where('name', 'Settings')->first();

        // Permission Groups
        $pgUser           = PermissionGroup::where('name', 'User')->first();
        $pgRole           = PermissionGroup::where('name', 'Role')->first();
        $pgPermGroup      = PermissionGroup::where('name', 'Permission Group')->first();
        $pgPermission     = PermissionGroup::where('name', 'Permission')->first();
        $pgMenu           = PermissionGroup::where('name', 'Menu')->first();
        $pgMenuGroup      = PermissionGroup::where('name', 'Menu Group')->first();
        $pgArticleCategory= PermissionGroup::where('name', 'Article Category')->first();
        $pgArticle        = PermissionGroup::where('name', 'Article')->first();
        $pgSetting        = PermissionGroup::where('name', 'Setting')->first();
        $pgBanner         = PermissionGroup::where('name', 'Banner')->first();
        $pgPropertyService= PermissionGroup::where('name', 'Property Service')->first();
        $pgFacility       = PermissionGroup::where('name', 'Facility')->first();
        $pgProperty       = PermissionGroup::where('name', 'Property')->first();

        // === Menu 1: Artikel (Group: Content Management) ===
        $artikel = Menu::create([
            'menu_group_id'      => $kontenGroup?->id,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> $pgArticle?->id, 
            'icon'               => 'ri-article-line',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel Kategori',
            'permission_group_id'=> $pgArticleCategory?->id,
            'href'               => '/article_categories',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> $pgArticle?->id,
            'href'               => '/article',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Menu 2: Banner (Group: Content Management) ===
        Menu::create([
            'menu_group_id'      => $kontenGroup?->id,
            'nama_menu'          => 'Banner',
            'permission_group_id'=> $pgBanner?->id,
            'icon'               => 'ri-image-line',
            'href'               => '/banner',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Single Menus (Group: Property Management) ===
        Menu::create([
            'menu_group_id'      => $propertyGroup?->id,
            'nama_menu'          => 'Properties',
            'permission_group_id'=> $pgProperty?->id,
            'icon'               => 'ri-building-4-line',
            'href'               => '/properties',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_group_id'      => $propertyGroup?->id,
            'nama_menu'          => 'Property Services',
            'permission_group_id'=> $pgPropertyService?->id,
            'icon'               => 'ri-customer-service-2-line',
            'href'               => '/property_services',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_group_id'      => $propertyGroup?->id,
            'nama_menu'          => 'Facilities',
            'permission_group_id'=> $pgFacility?->id,
            'icon'               => 'ri-building-2-line',
            'href'               => '/facilities',
            'status'             => '1',
            'sort'               => '3',
        ]);

        // === Menu 2: Setting (Group: PENGATURAN) ===
        $setting = Menu::create([
            'menu_group_id'      => $pengaturanGroup?->id,
            'nama_menu'          => 'Setting',
            'permission_group_id'=> $pgSetting?->id,
            'icon'               => 'ri-settings-3-line',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // Submenu User Management
        $userManagement = Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'User Management',
            'permission_group_id'=> $pgUser?->id,
            'status'             => '1',
            'sort'               => '1',
        ]);

        // Level 3 dari User Management
        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Users',
            'permission_group_id'=> $pgUser?->id,
            'href'               => '/user',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permission Group',
            'permission_group_id'=> $pgPermGroup?->id,
            'href'               => '/permissiongroup',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permissions',
            'permission_group_id'=> $pgPermission?->id,
            'href'               => '/permission',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Roles',
            'permission_group_id'=> $pgRole?->id,
            'href'               => '/role',
            'status'             => '1',
            'sort'               => '4',
        ]);

        // Submenu Web Setting (langsung di bawah Setting)
        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Web Setting',
            'permission_group_id'=> $pgSetting?->id,
            'href'               => '/setting',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Management',
            'permission_group_id'=> $pgMenu?->id,
            'href'               => '/menu',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Group',
            'permission_group_id'=> $pgMenuGroup?->id,
            'href'               => '/menugroup',
            'status'             => '1',
            'sort'               => '4',
        ]);
    }
}