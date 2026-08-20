<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;
use App\Models\MenuGroup;
use App\Models\PermissionGroup;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Menu::truncate();
        Schema::enableForeignKeyConstraints();

        // Helper closures to resolve dynamic IDs
        $getGroupId = fn($name) => MenuGroup::where('name', $name)->value('id');
        $getPermId  = fn($name) => PermissionGroup::where('name', $name)->value('id');

        // =========================================================================
        // 1. GROUP: BOOKING & RESERVATION
        // =========================================================================
        $bookingGroupId = $getGroupId('Booking & Reservation');

        Menu::create([
            'menu_group_id'       => $bookingGroupId,
            'nama_menu'           => 'Bookings',
            'permission_group_id' => $getPermId('Booking'),
            'icon'                => 'ri-calendar-check-line',
            'href'                => '/bookings',
            'status'              => 1,
            'sort'                => 1,
        ]);

        Menu::create([
            'menu_group_id'       => $bookingGroupId,
            'nama_menu'           => 'Reviews',
            'permission_group_id' => $getPermId('Review'),
            'icon'                => 'ri-star-smile-line',
            'href'                => '/reviews',
            'status'              => 1,
            'sort'                => 2,
        ]);

        // =========================================================================
        // 2. GROUP: PROPERTY MANAGEMENT
        // =========================================================================
        $propertyGroupId = $getGroupId('Property Management');

        Menu::create([
            'menu_group_id'       => $propertyGroupId,
            'nama_menu'           => 'Properties',
            'permission_group_id' => $getPermId('Property'),
            'icon'                => 'ri-building-4-line',
            'href'                => '/properties',
            'status'              => 1,
            'sort'                => 1,
        ]);

        Menu::create([
            'menu_group_id'       => $propertyGroupId,
            'nama_menu'           => 'Destinations',
            'permission_group_id' => $getPermId('Destination'),
            'icon'                => 'ri-map-pin-2-line',
            'href'                => '/destination',
            'status'              => 1,
            'sort'                => 2,
        ]);

        Menu::create([
            'menu_group_id'       => $propertyGroupId,
            'nama_menu'           => 'Facilities',
            'permission_group_id' => $getPermId('Facility'),
            'icon'                => 'ri-building-2-line',
            'href'                => '/facilities',
            'status'              => 1,
            'sort'                => 3,
        ]);

        Menu::create([
            'menu_group_id'       => $propertyGroupId,
            'nama_menu'           => 'Property Services',
            'permission_group_id' => $getPermId('Property Service'),
            'icon'                => 'ri-customer-service-2-line',
            'href'                => '/property_services',
            'status'              => 1,
            'sort'                => 4,
        ]);

        Menu::create([
            'menu_group_id'       => $propertyGroupId,
            'nama_menu'           => 'Property Rules',
            'permission_group_id' => $getPermId('Property Rule'),
            'icon'                => 'ri-shield-keyhole-line',
            'href'                => '/property_rules',
            'status'              => 1,
            'sort'                => 5,
        ]);

        // =========================================================================
        // 3. GROUP: MARKETING & PROMOTION
        // =========================================================================
        $marketingGroupId = $getGroupId('Marketing & Promotion');

        Menu::create([
            'menu_group_id'       => $marketingGroupId,
            'nama_menu'           => 'Promotions',
            'permission_group_id' => $getPermId('Promotion'),
            'icon'                => 'ri-coupon-3-line',
            'href'                => '/promotion',
            'status'              => 1,
            'sort'                => 1,
        ]);

        // =========================================================================
        // 4. GROUP: CONTENT MANAGEMENT
        // =========================================================================
        $contentGroupId = $getGroupId('Content Management');

        $artikel = Menu::create([
            'menu_group_id'       => $contentGroupId,
            'nama_menu'           => 'Articles',
            'permission_group_id' => $getPermId('Article'),
            'icon'                => 'ri-article-line',
            'status'              => 1,
            'sort'                => 1,
        ]);

        Menu::create([
            'menu_id'             => $artikel->id,
            'nama_menu'           => 'All Articles',
            'permission_group_id' => $getPermId('Article'),
            'href'                => '/article',
            'status'              => 1,
            'sort'                => 1,
        ]);

        Menu::create([
            'menu_id'             => $artikel->id,
            'nama_menu'           => 'Article Categories',
            'permission_group_id' => $getPermId('Article Category'),
            'href'                => '/article_categories',
            'status'              => 1,
            'sort'                => 2,
        ]);

        // =========================================================================
        // 5. GROUP: FINANCE & PAYMENT
        // =========================================================================
        $financeGroupId = $getGroupId('Finance & Payment');

        Menu::create([
            'menu_group_id'       => $financeGroupId,
            'nama_menu'           => 'Payment Methods',
            'permission_group_id' => $getPermId('Payment Method'),
            'icon'                => 'ri-bank-card-line',
            'href'                => '/payment_methods',
            'status'              => 1,
            'sort'                => 1,
        ]);

        // =========================================================================
        // 6. GROUP: SETTINGS
        // =========================================================================
        $settingsGroupId = $getGroupId('Settings');

        $setting = Menu::create([
            'menu_group_id'       => $settingsGroupId,
            'nama_menu'           => 'Setting',
            'permission_group_id' => $getPermId('Setting'),
            'icon'                => 'ri-settings-3-line',
            'status'              => 1,
            'sort'                => 1,
        ]);

        // Submenu Level 2: User Management
        $userManagement = Menu::create([
            'menu_id'             => $setting->id,
            'nama_menu'           => 'User Management',
            'permission_group_id' => $getPermId('User'),
            'status'              => 1,
            'sort'                => 1,
        ]);

        // Level 3 items under User Management
        Menu::create([
            'menu_id'             => $userManagement->id,
            'nama_menu'           => 'Users',
            'permission_group_id' => $getPermId('User'),
            'href'                => '/user',
            'status'              => 1,
            'sort'                => 1,
        ]);

        Menu::create([
            'menu_id'             => $userManagement->id,
            'nama_menu'           => 'Roles',
            'permission_group_id' => $getPermId('Role'),
            'href'                => '/role',
            'status'              => 1,
            'sort'                => 2,
        ]);

        Menu::create([
            'menu_id'             => $userManagement->id,
            'nama_menu'           => 'Permission Group',
            'permission_group_id' => $getPermId('Permission Group'),
            'href'                => '/permissiongroup',
            'status'              => 1,
            'sort'                => 3,
        ]);

        Menu::create([
            'menu_id'             => $userManagement->id,
            'nama_menu'           => 'Permissions',
            'permission_group_id' => $getPermId('Permission'),
            'href'                => '/permission',
            'status'              => 1,
            'sort'                => 4,
        ]);

        // Submenu Level 2: Web Setting
        Menu::create([
            'menu_id'             => $setting->id,
            'nama_menu'           => 'Web Setting',
            'permission_group_id' => $getPermId('Setting'),
            'href'                => '/setting',
            'status'              => 1,
            'sort'                => 2,
        ]);

        // Submenu Level 2: Menu Management
        Menu::create([
            'menu_id'             => $setting->id,
            'nama_menu'           => 'Menu Management',
            'permission_group_id' => $getPermId('Menu'),
            'href'                => '/menu',
            'status'              => 1,
            'sort'                => 3,
        ]);

        // Submenu Level 2: Menu Group
        Menu::create([
            'menu_id'             => $setting->id,
            'nama_menu'           => 'Menu Group',
            'permission_group_id' => $getPermId('Menu Group'),
            'href'                => '/menugroup',
            'status'              => 1,
            'sort'                => 4,
        ]);

        Cache::forget('admin_sidebar_menus');
    }
}