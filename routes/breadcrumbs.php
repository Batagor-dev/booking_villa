<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});


// **************************** USER ***************************

// Home > User
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('user.index'));
});

// Home > User > [Update]
Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail, $user) {
    // dd($user);
    $trail->parent('user.index');
    $trail->push('Update [' . $user->name . ']', route('user.edit', $user));
});

// Home > User > Create
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.index');
    $trail->push('Create', route('user.create'));
});

// Home > User > Permission
Breadcrumbs::for('user.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('User Permission', route('user.show', $user));
});

// Home > User > Permission
Breadcrumbs::for('user.role', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('User Roles [' . $user->name . ']', route('user.role', $user));
});

// **************************** END USER ***************************


// **************************** ROLE ***************************

// Home > Role
Breadcrumbs::for('role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('role.index'));
});

// Home > Role > [Update]
Breadcrumbs::for('role.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('role.index');
    $trail->push('Update [' . $role->name . ']', route('role.edit', $role));
});

// Home > Role > Create
Breadcrumbs::for('role.create', function (BreadcrumbTrail $trail) {
    $trail->parent('role.index');
    $trail->push('Create', route('role.create'));
});

// Home > Role > Permission
Breadcrumbs::for('role.show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('role.index');
    $trail->push('Role Permission', route('role.show', $role));
});

// **************************** END ROLE ***************************


// **************************** PERMISSION ***************************

// Home > Permission
Breadcrumbs::for('permission.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permission', route('permission.index'));
});

// Home > Permission > [Update]
Breadcrumbs::for('permission.edit', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('permission.index');
    $trail->push('Update [' . $permission->name . ']', route('permission.edit', $permission));
});

// Home > Permission > Create
Breadcrumbs::for('permission.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permission.index');
    $trail->push('Create', route('permission.create'));
});

// **************************** END PERMISSION ***************************


// **************************** PERMISSION GROUP ***************************

// Home > Permission Group
Breadcrumbs::for('permissiongroup.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permission Group', route('permissiongroup.index'));
});

// Home > Permission Group > [Update]
Breadcrumbs::for('permissiongroup.edit', function (BreadcrumbTrail $trail, $permissiongroup) {
    $trail->parent('permissiongroup.index');
    $trail->push('Update [' . $permissiongroup->name . ']', route('permissiongroup.edit', $permissiongroup));
});

// Home > Permission Group > Create
Breadcrumbs::for('permissiongroup.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permissiongroup.index');
    $trail->push('Create', route('permissiongroup.create'));
});

// **************************** END PERMISSION GROUP ***************************


// **************************** MENU GROUP ***************************

// Home > Menu Group
Breadcrumbs::for('menugroup.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Menu Group', route('menugroup.index'));
});

// Home > Menu Group > [Update]
Breadcrumbs::for('menugroup.edit', function (BreadcrumbTrail $trail, $menugroup) {
    $trail->parent('menugroup.index');
    $trail->push('Update [' . $menugroup->name . ']', route('menugroup.edit', $menugroup));
});

// Home > Menu Group > Create
Breadcrumbs::for('menugroup.create', function (BreadcrumbTrail $trail) {
    $trail->parent('menugroup.index');
    $trail->push('Create', route('menugroup.create'));
});

// **************************** END MENU GROUP ***************************


// **************************** MENU ***************************

// Home > Menu
Breadcrumbs::for('menu.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Menu', route('menu.index'));
});

// Home > Menu > [Update]
Breadcrumbs::for('menu.edit', function (BreadcrumbTrail $trail, $menu) {
    $trail->parent('menu.index');
    $trail->push('Update [' . $menu->nama_menu . ']', route('menu.edit', $menu));
});

// Home > Menu > Create
Breadcrumbs::for('menu.create', function (BreadcrumbTrail $trail) {
    $trail->parent('menu.index');
    $trail->push('Create', route('menu.create'));
});

// **************************** END MENU ***************************


// **************************** ARTICLE CATEGORY ***************************

// Home > Article Categories
Breadcrumbs::for('article_categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Article Categories', route('article_categories.index'));
});

// Home > Article Categories > [Update]
Breadcrumbs::for('article_categories.edit', function (BreadcrumbTrail $trail, $article_categories) {
    $trail->parent('article_categories.index');
    $trail->push('Update [' . $article_categories->name . ']', route('article_categories.edit', $article_categories));
});

// Home > Article Categories > Create
Breadcrumbs::for('article_categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('article_categories.index');
    $trail->push('Create', route('article_categories.create'));
});

// **************************** END ARTICLE CATEGORY ***************************


// **************************** SETTING ***************************

// Home > Article Categories
Breadcrumbs::for('setting.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Web Setting', route('setting.index'));
});

// **************************** END SETTING ***************************

// **************************** ACOUNT ***************************

// Home > Acount > Profile
Breadcrumbs::for('acount.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Account', route('acount.index'));
});

// Home > Acount > Setting
Breadcrumbs::for('acount.security', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Account', route('acount.security'));
});

// **************************** END ACOUNT ***************************

// **************************** ARTICLE ***************************

// Home > Article Categories
Breadcrumbs::for('article.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Article', route('article.index'));
});

// Home > Article Categories > [Update]
Breadcrumbs::for('article.edit', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('article.index');
    $trail->push('Update [' . $article->title . ']', route('article.edit', $article));
});

// Home > Article Categories > Create
Breadcrumbs::for('article.create', function (BreadcrumbTrail $trail) {
    $trail->parent('article.index');
    $trail->push('Create', route('article.create'));
});

// Home > Article Categories > Create
Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('article.index');
    $trail->push('Article ' . $article->title, route('article.show', $article));
});

// **************************** END ARTICLE ***************************





// **************************** PROPERTY SERVICES ***************************

// Home > Property Services
Breadcrumbs::for('property_services.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Property Services', route('property_services.index'));
});

// Home > Property Services > Create
Breadcrumbs::for('property_services.create', function (BreadcrumbTrail $trail) {
    $trail->parent('property_services.index');
    $trail->push('Create', route('property_services.create'));
});

// Home > Property Services > Edit
Breadcrumbs::for('property_services.edit', function (BreadcrumbTrail $trail, $property_service) {
    $trail->parent('property_services.index');
    $trail->push('Update [' . $property_service->name . ']', route('property_services.edit', $property_service));
});

// **************************** END PROPERTY SERVICES ***************************


// **************************** PROPERTIES ***************************

// Home > Properties
Breadcrumbs::for('properties.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Properties', route('properties.index'));
});

// Home > Properties > Create
Breadcrumbs::for('properties.create', function (BreadcrumbTrail $trail) {
    $trail->parent('properties.index');
    $trail->push('Create', route('properties.create'));
});

// Home > Properties > Edit
Breadcrumbs::for('properties.edit', function (BreadcrumbTrail $trail, $property) {
    $trail->parent('properties.index');
    $trail->push('Update [' . $property->name . ']', route('properties.edit', $property));
});

// **************************** DESTINATIONS ***************************

// Home > Destination
Breadcrumbs::for('destination.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Destinations', route('destination.index'));
});

// Home > Destination > Create
Breadcrumbs::for('destination.create', function (BreadcrumbTrail $trail) {
    $trail->parent('destination.index');
    $trail->push('Create', route('destination.create'));
});

// Home > Destination > Edit
Breadcrumbs::for('destination.edit', function (BreadcrumbTrail $trail, $destination) {
    $trail->parent('destination.index');
    $trail->push('Update [' . $destination->name . ']', route('destination.edit', $destination));
});

// **************************** END DESTINATIONS ***************************


// **************************** FACILITIES ***************************


// Home > Facilities
Breadcrumbs::for('facilities.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Facilities', route('facilities.index'));
});

// Home > Facilities > Create
Breadcrumbs::for('facilities.create', function (BreadcrumbTrail $trail) {
    $trail->parent('facilities.index');
    $trail->push('Create', route('facilities.create'));
});

// Home > Facilities > Edit
Breadcrumbs::for('facilities.edit', function (BreadcrumbTrail $trail, $facility) {
    $trail->parent('facilities.index');
    $trail->push('Update [' . $facility->name . ']', route('facilities.edit', $facility));
});

// **************************** END FACILITIES ***************************


// **************************** PAYMENT METHODS ***************************

// Home > Payment Methods
Breadcrumbs::for('payment_methods.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Payment Methods', route('payment_methods.index'));
});

// Home > Payment Methods > Create
Breadcrumbs::for('payment_methods.create', function (BreadcrumbTrail $trail) {
    $trail->parent('payment_methods.index');
    $trail->push('Create', route('payment_methods.create'));
});

// Home > Payment Methods > Edit
Breadcrumbs::for('payment_methods.edit', function (BreadcrumbTrail $trail, $payment_method) {
    $trail->parent('payment_methods.index');
    $trail->push('Update [' . $payment_method->name . ']', route('payment_methods.edit', $payment_method));
});

// **************************** END PAYMENT METHODS ***************************

// **************************** BOOKINGS ***************************

// Home > Bookings
Breadcrumbs::for('bookings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Bookings', route('bookings.index'));
});

// Home > Bookings > Edit
Breadcrumbs::for('bookings.edit', function (BreadcrumbTrail $trail, $booking) {
    $trail->parent('bookings.index');
    $trail->push('Edit [' . $booking->booking_code . ']', route('bookings.edit', $booking));
});

// **************************** END BOOKINGS ***************************

// **************************** PROMOTIONS ***************************

// Home > Promotions
Breadcrumbs::for('promotion.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Promotions', route('promotion.index'));
});

// Home > Promotions > Create
Breadcrumbs::for('promotion.create', function (BreadcrumbTrail $trail) {
    $trail->parent('promotion.index');
    $trail->push('Create', route('promotion.create'));
});

// Home > Promotions > Edit
Breadcrumbs::for('promotion.edit', function (BreadcrumbTrail $trail, $promotion) {
    $trail->parent('promotion.index');
    $trail->push('Update [' . $promotion->name . ']', route('promotion.edit', $promotion));
});

// **************************** END PROMOTIONS ***************************

// **************************** REVIEWS ***************************

// Home > Reviews
Breadcrumbs::for('reviews.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Reviews', route('reviews.index'));
});

// Home > Reviews > Edit
Breadcrumbs::for('reviews.edit', function (BreadcrumbTrail $trail, $review) {
    $trail->parent('reviews.index');
    $trail->push('Moderasi Ulasan', route('reviews.edit', $review));
});

// **************************** PROPERTY RULES ***************************

// Home > Property Rules
Breadcrumbs::for('property_rules.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Peraturan Villa', route('property_rules.index'));
});

// Home > Property Rules > Create
Breadcrumbs::for('property_rules.create', function (BreadcrumbTrail $trail) {
    $trail->parent('property_rules.index');
    $trail->push('Tambah Peraturan', route('property_rules.create'));
});

// Home > Property Rules > Edit
Breadcrumbs::for('property_rules.edit', function (BreadcrumbTrail $trail, $property_rule) {
    $trail->parent('property_rules.index');
    $trail->push('Update [' . $property_rule->title . ']', route('property_rules.edit', $property_rule));
});

// **************************** END PROPERTY RULES ***************************




