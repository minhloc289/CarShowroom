<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lý nhân viên', route('user'));
    $trail->push('Home', route('dashboard'));
    $trail->push('Quản lý nhóm nhân viên', route('user'));
});

Breadcrumbs::for('user.account', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lý nhân viên', route('user'));
    $trail->push('Home', route('dashboard'));
    $trail->push('Quản lý tài khoản nhân viên', route('user.account'));
});
