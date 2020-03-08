<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth

$route['login'] = 'auth/login_view';
$route['signup'] = 'auth/signup_view';
$route['account/login'] = 'auth/user_login';
$route['account/signup'] = 'auth/create_account';
$route['logout'] = 'auth/signout';

$route['admin/login'] = 'admin_auth/login_view';
$route['admin/signup'] = 'admin_auth/signup_view';
$route['account/admin/login'] = 'admin_auth/admin_login';
$route['account/admin/signup'] = 'admin_auth/admin_signup';

// User Account

$route['order_history'] = 'account/order_history_view';
$route['order'] = 'account/order_view';
$route['billing'] = 'account/billing_view';
$route['menu'] = 'account/menu';

// Admin Account

$route['admin/orders'] = 'admin/admin_orders_view';
$route['admin/billing'] = 'admin/admin_billing_view';
$route['admin/view_menu'] = 'admin/menu_view';
$route['admin/create_menu'] = 'admin/create_menu_view';
$route['admin/view_menu/(:any)/add_user'] = 'admin/add_user_view';
$route['admin/edit_menu/(:any)'] = 'admin/edit_menu_view';
$route['admin/settings'] = 'admin/admin_settings_view';

// API
$route['admin/menu/create'] = 'menu/create_menu';
$route['admin/menu/edit'] = 'menu/edit_menu';
$route['admin/menu/add_user'] = 'menu/add_user_menu';
$route['user/menu/order'] = 'user_api/order_menu';
$route['user/menu/cancel_order'] = 'user_api/cancel_order';

$route['admin/settings/save'] = 'admin_settings/save';
$route['api/find_users'] = 'menu/find_users';
$route['api/orders'] = 'admin/get_admin_orders';
$route['api/orders/remove'] = 'admin/remove_admin_orders';
$route['api/admin/bills'] = 'admin/get_admin_bills';


