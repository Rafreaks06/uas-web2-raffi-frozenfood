<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|=====================================================
| ROUTES DEFAULT
|=====================================================
*/

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*
|=====================================================
| AUTH (ADMIN + USER)
|=====================================================
*/

$route['login']                    = 'auth/login';
$route['auth/login_process']            = 'auth/login_process';
$route['logout']                   = 'auth/logout';
$route['register']                 = 'auth/register';
$route['register/process']         = 'auth/register_process';
$route['change-password']          = 'auth/change_password';
$route['change-password/process']  = 'auth/change_password_process';


/*
|=====================================================
| ADMIN DASHBOARD
|=====================================================
*/

$route['admin/dashboard'] = 'admin/Dashboard/index';
$route['dashboard']        = 'admin/Dashboard/index'; // akses cepat


/*
|=====================================================
| USER DASHBOARD
|=====================================================
*/

$route['user/dashboard'] = 'user/Dashboard/index';


/*
|=====================================================
| MASTER DATA
|=====================================================
*/

/* SUPPLIER */
$route['admin/supplier']                    = 'admin/Supplier/index';
$route['admin/supplier/create']             = 'admin/Supplier/create';
$route['admin/supplier/store']              = 'admin/Supplier/store';
$route['admin/supplier/edit/(:num)']        = 'admin/Supplier/edit/$1';
$route['admin/supplier/update/(:num)']      = 'admin/Supplier/update/$1';
$route['admin/supplier/delete/(:num)']      = 'admin/Supplier/delete/$1';

/* CUSTOMER (read-only + detail) */
$route['admin/customer']                    = 'admin/Customer/index';
$route['admin/customer/detail/(:num)']      = 'admin/Customer/detail/$1';

/* KATEGORI */
$route['admin/kategori']                    = 'admin/Kategori/index';
$route['admin/kategori/create']             = 'admin/Kategori/create';
$route['admin/kategori/store']              = 'admin/Kategori/store';
$route['admin/kategori/edit/(:num)']        = 'admin/Kategori/edit/$1';
$route['admin/kategori/update/(:num)']      = 'admin/Kategori/update/$1';
$route['admin/kategori/delete/(:num)']      = 'admin/Kategori/delete/$1';

/* PRODUK */
$route['admin/produk']                      = 'admin/Produk/index';
$route['admin/produk/create']               = 'admin/Produk/create';
$route['admin/produk/store']                = 'admin/Produk/store';
$route['admin/produk/edit/(:num)']          = 'admin/Produk/edit/$1';
$route['admin/produk/update/(:num)']        = 'admin/Produk/update/$1';
$route['admin/produk/delete/(:num)']        = 'admin/Produk/delete/$1';


/*
|=====================================================
| ORDER OFFLINE
|=====================================================
*/

$route['admin/order-offline']               = 'admin/OrderOffline/index';
$route['admin/order-offline/create']        = 'admin/OrderOffline/create';
$route['admin/order-offline/store']         = 'admin/OrderOffline/store';
$route['admin/order-offline/detail/(:num)'] = 'admin/OrderOffline/detail/$1';   


$route['admin/order-offline/cetak/(:num)']  = 'admin/OrderOffline/cetak/$1';


/*
|=====================================================
| ORDER ONLINE
|=====================================================
*/

$route['admin/order-online']                = 'admin/OrderOnline/index';
$route['admin/order-online/detail/(:num)']  = 'admin/OrderOnline/detail/$1';
$route['admin/order-online/verifikasi/(:num)'] = 'admin/OrderOnline/verifikasi/$1';
$route['admin/order-online/tolak/(:num)']      = 'admin/OrderOnline/tolak/$1';


$route['user/order'] = 'user/Order/index';
$route['user/order/save'] = 'user/Order/save';
$route['user/order'] = 'user/Order_online/index';
$route['user/order/detail/(:num)'] = 'user/Order_online/detail/$1';
$route['user/order-online']             = 'user/order_online/index';
$route['user/order-online/create']      = 'user/order_online/create';
$route['user/order-online/store']       = 'user/order_online/store';
$route['user/order-online/detail/(:num)'] = 'user/order_online/detail/$1';
$route['user/order-online/cancel/(:num)'] = 'user/order_online/cancel/$1';

