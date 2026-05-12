<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['ttd-pdf'] = 'TtdPdfController/create_qr';
$route['ttd-pdf/store'] = 'TtdPdfController/store';
$route['verifikasi-qrcode/(:num)'] = 'TtdPdfController/verifikasi';

$route['dashboard-dekan-wd'] = 'DekanWdController/index';
$route['dashboard-dekan-wd/verifikasi/(:num)'] = 'DekanWdController/verifikasi';

$route['daftar-mahasiswa'] = 'MahasiswaController/index';
$route['daftar-mahasiswa/delete'] = 'MahasiswaController/delete';
$route['daftar-mahasiswa/aktifasi'] = 'MahasiswaController/aktifasi_mahasiswa';

$route['dosen-pembimbing-dan-penguji'] = 'C_dosen/dosen_pembimbing_dan_penguji';
$route['daftar-dosen'] = 'DosenController/index';
$route['daftar-dosen/delete'] = 'DosenController/delete';
$route['daftar-dosen/aktifasi'] = 'DosenController/aktifasi_dosen';
$route['daftar-dosen/add-jabatan'] = 'DosenController/addJabatan';
$route['daftar-dosen/table'] = 'DosenController/tableDosen';
$route['daftar-dosen/update/(:any)'] = 'DosenController/update';
$route['daftar-mahasiswa/table'] = 'MahasiswaController/tableMahasiswa';

$route['verifikasi-sk'] = 'VerifikasiSk/index';
$route['verifikasi-sk/verifikasi'] = 'VerifikasiSk/verifikasi';
$route['verifikasi-sk/data'] = 'VerifikasiSk/getVerifikasiSk';

$route['penilaian-ujian-mahasiswa'] = 'UjianMahasiswaController/index';
$route['penilaian-ujian-mahasiswa/data'] = 'UjianMahasiswaController/getUjianMahasiswa';
$route['penilaian-ujian-mahasiswa/submit'] = 'UjianMahasiswaController/store';
//admin fakultas yg menilai
$route['penilaian-ujian-mahasiswa/nilai-staf'] = 'UjianMahasiswaController/nilaiUjian';
