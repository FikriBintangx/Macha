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
