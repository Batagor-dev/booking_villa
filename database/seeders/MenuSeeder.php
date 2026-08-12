<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Menu Group IDs:
        // 1 = Content Management
        // 2 = Property Management
        // 3 = Settings

        // Permission Group IDs:
        // 1 = User, 2 = Role, 3 = Permission Group, 4 = Permission, 5 = Menu, 6 = Menu Group,
        // 7 = Article Category, 8 = Article, 9 = Setting, 10 = Banner, 11 = Property Service,
        // 12 = Facility, 13 = Property, 14 = Content Management, 15 = Property Management,
        // 16 = Settings, 17 = Payment Method

        // === Menu 1: Artikel (Group: Content Management - ID 1) ===
        $artikel = Menu::create([
            'menu_group_id'      => 1,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 8, 
            'icon'               => 'ri-article-line',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel Kategori',
            'permission_group_id'=> 7,
            'href'               => '/article_categories',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 8,
            'href'               => '/article',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Menu 2: Banner (Group: Content Management - ID 1) ===
        Menu::create([
            'menu_group_id'      => 1,
            'nama_menu'          => 'Banner',
            'permission_group_id'=> 10,
            'icon'               => 'ri-image-line',
            'href'               => '/banner',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Single Menus (Group: Property Management - ID 2) ===
        Menu::updateOrCreate(
            ['href' => '/destination'],
            [
                'menu_group_id'      => 2,
                'nama_menu'          => 'Destinations',
                'permission_group_id'=> 19,
                'icon'               => 'ri-map-pin-2-line',
                'status'             => '1',
                'sort'               => '1',
            ]
        );

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Properties',
            'permission_group_id'=> 13,
            'icon'               => 'ri-building-4-line',
            'href'               => '/properties',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Property Services',
            'permission_group_id'=> 11,
            'icon'               => 'ri-customer-service-2-line',
            'href'               => '/property_services',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Facilities',
            'permission_group_id'=> 12,
            'icon'               => 'ri-building-2-line',
            'href'               => '/facilities',
            'status'             => '1',
            'sort'               => '4',
        ]);

        Menu::updateOrCreate(
            ['href' => '/property_rules'],
            [
                'menu_group_id'      => 2,
                'nama_menu'          => 'Property Rules',
                'permission_group_id'=> null,
                'icon'               => 'ri-shield-keyhole-line',
                'status'             => '1',
                'sort'               => '5',
            ]
        );

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Payment Methods',
            'permission_group_id'=> 17,
            'icon'               => 'ri-bank-card-line',
            'href'               => '/payment_methods',
            'status'             => '1',
            'sort'               => '5',
        ]);

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Bookings',
            'permission_group_id'=> 18,
            'icon'               => 'ri-calendar-check-line',
            'href'               => '/bookings',
            'status'             => '1',
            'sort'               => '6',
        ]);

        Menu::create([
            'menu_group_id'      => 2,
            'nama_menu'          => 'Promotions',
            'permission_group_id'=> 20,
            'icon'               => 'ri-coupon-3-line',
            'href'               => '/promotion',
            'status'             => '1',
            'sort'               => '7',
        ]);

        Menu::updateOrCreate(
            ['href' => '/reviews'],
            [
                'menu_group_id'      => 2,
                'nama_menu'          => 'Reviews',
                'permission_group_id'=> \App\Models\PermissionGroup::where('name', 'Review')->first()?->id ?? 21,
                'icon'               => 'ri-star-smile-line',
                'status'             => '1',
                'sort'               => '8',
            ]
        );

        // === Menu 2: Setting (Group: Settings - ID 3) ===
        $setting = Menu::create([
            'menu_group_id'      => 3,
            'nama_menu'          => 'Setting',
            'permission_group_id'=> 9,
            'icon'               => 'ri-settings-3-line',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // Submenu User Management
        $userManagement = Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'User Management',
            'permission_group_id'=> 1,
            'status'             => '1',
            'sort'               => '1',
        ]);

        // Level 3 dari User Management
        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Users',
            'permission_group_id'=> 1,
            'href'               => '/user',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permission Group',
            'permission_group_id'=> 3,
            'href'               => '/permissiongroup',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permissions',
            'permission_group_id'=> 4,
            'href'               => '/permission',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Roles',
            'permission_group_id'=> 2,
            'href'               => '/role',
            'status'             => '1',
            'sort'               => '4',
        ]);

        // Submenu Web Setting (langsung di bawah Setting)
        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Web Setting',
            'permission_group_id'=> 9,
            'href'               => '/setting',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Management',
            'permission_group_id'=> 5,
            'href'               => '/menu',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Group',
            'permission_group_id'=> 6,
            'href'               => '/menugroup',
            'status'             => '1',
            'sort'               => '4',
        ]);
    }
}