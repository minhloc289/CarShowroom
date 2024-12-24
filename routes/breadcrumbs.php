<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí hồ sơ lý lịch');
    $trail->push('Home', route('dashboard'));
    $trail->push('Chỉnh sửa hồ sơ', route('profile'));
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


//Carsales
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

//Customer
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

//Accessories
Breadcrumbs::for('Accessories', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí sản phẩm', route('accessories.index'));
    $trail->push('Quản lý phụ kiện', route('accessories.index'));
});

Breadcrumbs::for('accessories.details', function (BreadcrumbTrail $trail) {
    $trail->parent('Accessories'); // Parent breadcrumb
    $trail->push('Chi tiết phụ kiện');
});

Breadcrumbs::for('accessories.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('Accessories'); // Parent breadcrumb
    $trail->push('Chỉnh sửa thông tin phụ kiện');
});

Breadcrumbs::for('accessories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('Accessories'); // Parent breadcrumb
    $trail->push('Thêm phụ kiện mới');
});

//Rental Car
Breadcrumbs::for('rentalCar', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí sản phẩm');
    $trail->push('Quản lý xe thuê', route('rentalCar'));
});

Breadcrumbs::for('rentalCar.details', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalCar'); // Parent breadcrumb
    $trail->push('Chi tiết phụ kiện');
});

Breadcrumbs::for('rentalCar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalCar'); // Parent breadcrumb
    $trail->push('Thêm xe thuê mới');
});

Breadcrumbs::for('rentalCar.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalCar'); // Parent breadcrumb
    $trail->push('Chỉnh sửa xe thuê');
});

Breadcrumbs::for('rentalCar.record.create', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalCar'); // Parent breadcrumb
    $trail->push('Thêm bản ghi');
});

//order
Breadcrumbs::for('Order', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí Order', route('orders.index'));
    $trail->push('Quản lý Order Sản Phẩm', route('orders.index'));
});
Breadcrumbs::for('order.details', function (BreadcrumbTrail $trail) {
    $trail->parent('Order'); // Parent breadcrumb
    $trail->push('Chi tiết Order');
});


//Rental Order
Breadcrumbs::for('rentalOrders', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí Order');
    $trail->push('Theo dõi đơn hàng', route('rentalOrders'));
});

Breadcrumbs::for('rentalOrders.details', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalOrders');
    $trail->push('Chi tiết đơn hàng');  
});

Breadcrumbs::for('rentalOrders.create', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalOrders');
    $trail->push('Thêm đơn hàng');  
});

Breadcrumbs::for('order.add.car', function (BreadcrumbTrail $trail) {
    $trail->parent('Order'); // Parent breadcrumb
    $trail->push('Thêm Order Xe');
});

Breadcrumbs::for('rentalReceipt', function (BreadcrumbTrail $trail) {
    $trail->push('Xử lý yêu cầu gia hạn');
    $trail->push('Thông tin hóa đơn thuê xe');  
});

Breadcrumbs::for('rentalRenewals', function (BreadcrumbTrail $trail) {
    $trail->parent('rentalReceipt');
    $trail->push('Chi tiết gia hạn');  
});
Breadcrumbs::for('Revenue', function (BreadcrumbTrail $trail) {
    $trail->push('Quản lí Doanh Thu và Thống Kê');
    $trail->push('Doanh Thu', route('payments.manage'));
});
Breadcrumbs::for('Revenue.details', function (BreadcrumbTrail $trail) {
    $trail->parent('Revenue');
    $trail->push('Chi tiết thanh toán');  
});