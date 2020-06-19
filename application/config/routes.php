<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['welcome'] = 'welcome/index';
$route['barang-masuk'] = 'BarangMasuk/index';
$route['barang-keluar'] = 'BarangKeluar/index';
$route['barang-retur'] = 'BarangRetur/index';
$route['barang-jual'] = 'BarangJual/index';
// route laporan
$route['laporan-customer/laporan'] = 'customer/laporan';
$route['laporan-supplier/laporan'] = 'supplier/laporan';
$route['laporan-barang/laporan'] = 'barang/laporan_barang';
$route['laporan-barang-masuk/laporan'] = 'BarangMasuk/laporan';
$route['laporan-barang-keluar/laporan'] = 'BarangKeluar/laporan';
$route['laporan-barang-retur/laporan'] = 'BarangRetur/laporan';
$route['laporan-barang-jual/laporan'] = 'BarangJual/laporan';

//route barang-masuk
$route['barang-masuk/baru'] = 'BarangMasuk/baru';
$route['barang-masuk/edit/(:num)'] = 'BarangMasuk/edit/$1';
$route['barang-masuk/detail/(:num)'] = 'BarangMasuk/detail/$1';
$route['barang-masuk/delete/(:num)'] = 'BarangMasuk/delete/$1';
$route['barang-masuk/print-detail-barang-masuk/(:num)'] = 'BarangMasuk/printDetailBarangMasuk/$1';
$route['barang-masuk/laporan-barang-masuk'] = 'BarangMasuk/laporan_barang_masuk';

//route barang-keluar
$route['barang-keluar/baru'] = 'BarangKeluar/baru';
$route['barang-keluar/edit/(:num)'] = 'BarangKeluar/edit/$1';
$route['barang-keluar/detail/(:num)'] = 'BarangKeluar/detail/$1';
$route['barang-keluar/delete/(:num)'] = 'BarangKeluar/delete/$1';
$route['barang-keluar/print-detail-barang-keluar/(:num)'] = 'BarangKeluar/printDetailBarangKeluar/$1';
$route['barang-keluar/laporan-barang-keluar'] = 'BarangKeluar/laporan_barang_keluar';

//route barang-retur
$route['barang-retur/baru'] = 'BarangRetur/baru';
$route['barang-retur/edit/(:num)'] = 'BarangRetur/edit/$1';
$route['barang-retur/detail/(:num)'] = 'BarangRetur/detail/$1';
$route['barang-retur/delete/(:num)'] = 'BarangRetur/delete/$1';
$route['barang-retur/print-detail-barang-retur/(:num)'] = 'BarangRetur/printDetailBarangRetur/$1';
$route['barang-retur/laporan-barang-retur'] = 'BarangRetur/laporan_barang_retur';

//route barang-jual
$route['barang-jual/baru'] = 'BarangJual/baru';
$route['barang-jual/edit/(:num)'] = 'BarangJual/edit/$1';
$route['barang-jual/detail/(:num)'] = 'BarangJual/detail/$1';
$route['barang-jual/delete/(:num)'] = 'BarangJual/delete/$1';
$route['barang-jual/laporan-barang-jual'] = 'BarangJual/laporan_barang_jual';

//route laporan penagihan
$route['laporan-penagihan/laporan'] = 'penagihan/laporan';
$route['laporan-penagihan-jatuh-tempo/laporan'] = 'penagihan/laporan_jatuh_tempo';

//route laporan penagihan
$route['laporan-tagihan/laporan'] = 'tagihan/laporan';
$route['laporan-tagihan-jatuh-tempo/laporan'] = 'tagihan/laporan_jatuh_tempo';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
