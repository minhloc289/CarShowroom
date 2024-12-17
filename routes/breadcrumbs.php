<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí nhân viên', route('user'));
    $trail->push('Home', route('dashboard'));
    $trail->push('Quản lý nhóm nhân viên', route('user'));
});

Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user'); // Quản lý nhóm nhân viên as the parent
    $trail->push('Thêm mới nhân viên', route('user.create'));
});

Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user'); // Parent breadcrumb
    $trail->push('Chỉnh sửa nhân viên');
});

Breadcrumbs::for('user.record.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user'); // Parent breadcrumb
    $trail->push('Thêm mới bằng bản ghi');
});

Breadcrumbs::for('carsales', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí sản phẩm', route('Carsales'));
    $trail->push('Quản lý xe bán', route('Carsales'));
});
Breadcrumbs::for('carsales.details', function (BreadcrumbTrail $trail) {
    $trail->parent('carsales'); // Parent breadcrumb
    $trail->push('Chi tiết xe');
});
Breadcrumbs::for('carsales.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('carsales'); // Parent breadcrumb
    $trail->push('Chỉnh sửa thông tin xe');
});
Breadcrumbs::for('carsales.create', function (BreadcrumbTrail $trail) {
    $trail->parent('carsales'); // Parent breadcrumb
    $trail->push('Thêm thông tin xe');
});

Breadcrumbs::for('customer', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí khách hàng', route('customer'));
    $trail->push('Home', route('dashboard'));
    $trail->push('Quản lý tài khoản', route('customer'));
});

Breadcrumbs::for('customer.create', function (BreadcrumbTrail $trail) {
    $trail->parent('customer'); // Quản lý nhóm nhân viên as the parent
    $trail->push('Thêm mới khách hàng', route('customer.create'));
});

Breadcrumbs::for('customer.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('customer'); // Quản lý nhóm nhân viên as the parent
    $trail->push('Chỉnh sửa thông tin khách hàng');
});