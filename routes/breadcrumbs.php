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


