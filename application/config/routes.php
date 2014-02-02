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
$route['toggle_favorite/(:any)'] = 'ajax/toggle_favorite/$1';
$route['pages/(:any)'] = 'pages/view/$1';
$route['best-of/(:any)'] = 'campus/bestof/$1';
$route['best-of'] = 'campus/bestof';
$route['rss'] = 'rss/index';
$route['rss/school/(:any)'] = 'rss/school/$1';
$route['rss/dorms/(:any)/(:any)'] = 'rss/dorm/$1/$2';
$route['rss/(:any)/(:any)/(:any)'] = 'rss/category/$1/$2'; 
$route['rss/(:any)/comments'] = 'rss/comments/$1';
$route['auth/reset_password/(:any)'] = 'auth/reset_password/$1';

$route['(:any)/(:any)/(:any)/rate'] = 'forms/rate/$1/$3';
$route['(:any)/(:any)/(:any)/rate-thanks'] = 'forms/ratethanks/$1/$3';
$route['(:any)/rate'] = 'forms/ratecampus/$1';
$route['(:any)/rate-thanks'] = 'forms/ratecampusthanks/$1';
$route['(:any)/(:any)/(:any)/share'] = 'forms/share/$3';
$route['(:any)/(:any)/(:any)/share-thanks'] = 'forms/sharethanks/$3';
$route['(:any)/rating/(:num)'] = 'campus/view_rating/$2';
$route['(:any)/(:any)/(:any)/submit-correction'] = 'forms/submitcorrection/$3';
$route['(:any)/(:any)/(:any)/submit-correction-thanks'] = 'forms/submitcorrectionthanks/$3';
$route['(:any)/add-category'] = 'forms/addcategory/$1';
$route['(:any)/add-category-thanks'] = 'forms/addcategorythanks/$1';
$route['(:any)/(:any)/add-item'] = 'forms/additem/$1/$2';
$route['(:any)/(:any)/add-item-thanks'] = 'forms/additemthanks/$1/$2';
$route['(:any)/(:any)/(:any)/(:num)/flag'] = 'forms/flag/$1/$4/$3';
$route['(:any)/(:any)/(:any)/(:num)/flag-thanks'] = 'forms/flagthanks/$1/$4/$3';
$route['(:any)/(:num)/flag'] = 'forms/flag/$1/$2';
$route['(:any)/(:num)/flag-thanks'] = 'forms/flagthanks/$1/$2';
$route['(:any)/(:any)/(:any)/upload'] = 'campus/upload/$3';
$route['(:any)/(:any)/(:any)/do_upload'] = 'campus/do_upload/$3';
$route['(:any)/(:any)/(:any)'] = 'campus/item/$1/$2/$3';
$route['(:any)/(:any)'] = 'campus/category/$1/$2';
$route['campus/view'] = 'campus/view';

$route['upload'] = 'campus/upload';
$route['do_upload'] = 'campus/do_upload';

$route['favorites'] = 'campus/favorites';
$route['directory'] = 'campus/directory';
$route['auth(\/index)?'] = 'auth/index';
$route['login'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['auth/logout'] = 'auth/logout';
$route['signup'] = 'auth/create_user';
$route['auth/create_user'] = 'auth/create_user';
$route['auth/forgot_password'] = 'auth/forgot_password';
$route['auth/fb'] = 'auth/fb';
$route['admin'] = 'admin';


$route['main'] = 'main/index';

//$route['forms/submit-correction'] = 'forms/submitcorrection';
//$route['forms/submit-correction-thanks'] = 'forms/submitcorrectionthanks';
$route['forms/contact'] = 'forms/contact';
$route['forms/contact-thanks'] = 'forms/contactthanks';
$route['forgot_password'] = 'forms/forgotpassword';
$route['forms/forgot-password'] = 'forms/forgotpassword';
$route['forms/forgot-password-thanks'] = 'forms/forgotpasswordthanks';
$route['forms/flag-comment'] = 'forms/flag';
$route['forms/flag-comment-thanks'] = 'forms/flagthanks';
$route['forms/add-category'] = 'forms/addcategory';
$route['forms/add-category-thanks'] = 'forms/addcategorythanks';
$route['forms/add-item'] = 'forms/additem';
$route['forms/add-item-thanks'] = 'forms/additemthanks';
$route['forms/rate/(:any)'] = 'forms/rate/$1';
$route['forms/rate-thanks/(:any)'] = 'forms/ratethanks/$3';

$route['(:any)'] = 'campus/view/$1';
$route['default_controller'] = 'campus/find';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
