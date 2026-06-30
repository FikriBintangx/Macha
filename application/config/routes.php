<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING MACHA SYSTEM
| -------------------------------------------------------------------------
*/

// Halaman Utama (Default)
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rute Halaman Statis
$route['tentang'] = 'home/tentang';

// Rute Autentikasi
$route['login']            = 'auth';
$route['logout']           = 'auth/logout';
$route['auth/register']    = 'auth/register';
$route['auth/do_register'] = 'auth/do_register';
$route['auth/forgot']      = 'auth/forgot';
$route['auth/do_forgot']   = 'auth/do_forgot';
$route['auth/reset']       = 'auth/reset';
$route['auth/do_reset']    = 'auth/do_reset';

// Rute Dashboard
$route['dashboard'] = 'dashboard';

// --- RUTE PRODUK ---
$route['product/delete/(:num)']     = 'product/delete/$1';
$route['product/edit/(:num)']       = 'product/edit/$1';
$route['product/update/(:num)']     = 'product/update/$1';
$route['product/update']            = 'product/update';

// Rute Belanja
$route['shop']                      = 'shop';
$route['shop/cart']                 = 'shop/cart';
$route['shop/checkout']             = 'shop/checkout';
$route['shop/add_to_cart/(:num)']   = 'shop/add_to_cart/$1';
$route['shop/decrease_cart/(:num)'] = 'shop/decrease_cart/$1';
$route['shop/remove_cart/(:num)']   = 'shop/remove_cart/$1';
$route['shop/process_checkout']     = 'shop/process_checkout';

/* | -------------------------------------------------------------------------
| Contoh rute tambahan jika nanti ada fitur kategori
| -------------------------------------------------------------------------
| $route['category/delete/(:num)'] = 'category/delete/$1';
*/

// --- RUTE SUPPLIER ---
$route['supplier'] = 'supplier/dashboard';
$route['supplier/auth/logout'] = 'supplier/auth/logout';
$route['supplier/auth'] = 'supplier/auth';
$route['supplier/login'] = 'supplier/auth';
$route['supplier/dashboard'] = 'supplier/dashboard';
$route['supplier/products'] = 'supplier/products';
$route['supplier/products/create'] = 'supplier/products/create';
$route['supplier/products/store'] = 'supplier/products/store';
$route['supplier/products/edit/(:num)'] = 'supplier/products/edit/$1';
$route['supplier/products/update/(:num)'] = 'supplier/products/update/$1';
$route['supplier/products/delete/(:num)'] = 'supplier/products/delete/$1';
$route['supplier/requests'] = 'supplier/requests';
$route['supplier/requests/update_status/(:num)/(:any)'] = 'supplier/requests/update_status/$1/$2';
$route['supplier/shipments'] = 'supplier/shipments';
$route['supplier/shipments/create'] = 'supplier/shipments/create';
$route['supplier/analytics'] = 'supplier/analytics';
$route['supplier/profile'] = 'supplier/profile';
$route['supplier/profile/update'] = 'supplier/profile/update';


$route['xendit_callback'] = 'xendit_callback';

// DB Keepalive endpoint — dipanggil GitHub Actions setiap 5 menit
$route['ping'] = 'keepalive';

// Route for serving uploaded files dynamically (for Vercel compatibility)
$route['uploads/(:any)'] = 'uploads/serve';

