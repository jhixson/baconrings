<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = '';
$route['pages/(:any)'] = 'pages/view/$1';
$route['(:any)/(:any)'] = 'campus/category/$1/$2';
$route['campus/view'] = 'campus/view';
$route['best-of'] = 'campus/bestof';
$route['auth(\/index)?'] = 'auth/index';
$route['login'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['auth/logout'] = 'auth/logout';
$route['signup'] = 'auth/create_user';
$route['auth/create_user'] = 'auth/create_user';
$route['auth/forgot_password'] = 'auth/forgot_password';

$route['forms/submit-correction'] = 'forms/submitcorrection';
$route['forms/submit-correction-thanks'] = 'forms/submitcorrectionthanks';
$route['forms/contact'] = 'forms/contact';
$route['forms/contact-thanks'] = 'forms/contactthanks';
$route['forms/forgot-password'] = 'forms/forgotpassword';
$route['forms/forgot-password-thanks'] = 'forms/forgotpasswordthanks';
$route['forms/add-category'] = 'forms/addcategory';
$route['forms/add-category-thanks'] = 'forms/addcategorythanks';
$route['forms/add-item'] = 'forms/additem';
$route['forms/add-item-thanks'] = 'forms/additemthanks';

$route['(:any)'] = 'campus/view/$1';
$route['default_controller'] = 'campus/find';


/* End of file routes.php */
/* Location: ./application/config/routes.php */