<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$route['default_controller'] = 'home';
$route['404_override'] = 'error_page';
$route['matrimony/(:any)'] = 'matrimony/community_data/$1';

//for set pagintion url
$route['success-story/(:any)/(:any)'] = 'success-story/details/$1/$2';
// $route['success_story/(:any)/(:any)'] = 'success_story/details/$1/$2';

$route['matrimony/(:any)/(:any)'] = 'matrimony/community_data/$1/$2';

$route['more-details/(:any)'] = 'more_details/community_page_list/$1';

$route['privacy-setting/index/change-password(:any)'] = 'error_page';
$route['privacy-setting/index/change-password/(:any)'] = 'error_page';

$route['translate_uri_dashes'] = TRUE;

$route['control-panel'] = 'control-panel/login';

$route['faq'] = 'cms/faq';
$route['about-us'] = 'cms/about_us';
$route['about_us'] = 'cms/about_us';
$route['register/franchise/(:any)'] = 'register';
$route['refund-policy'] = 'cms/refund_policy';
$route['refund_policy'] = 'cms/refund_policy';

$route['report_misuse'] = 'cms/report_misuse';
$route['report-misuse'] = 'cms/report_misuse';

$route['privacy-policy'] = 'cms/privacy_policy';
$route['privacy_policy'] = 'cms/privacy_policy';

$route['terms-condition'] = 'cms/terms_condition';
$route['terms_condition'] = 'cms/terms_condition';

$route['vendor/(:any)'] = 'wedding_vendor/wed_vendor_list/$1';
$route['vendor-register'] = 'vendor/vendor_register/';
$route['vendor-saveregister'] = 'vendor/save_register/';
$route['vendor-login'] = 'vendor/vendor_login/';
$route['vendor-checklogin'] = 'vendor/check_login/';
$route['vendor-dashboard'] = 'vendor/vendor_dashboard/';
$route['vendor-logout'] = 'vendor/log_out/';
$route['vendor-payment-option'] = 'vendor/payment_option/';
$route['vendor-current-plan'] = 'vendor/current_plan/';
$route['vendor-upload-photos'] = 'vendor/upload_photos/';
$route['vendor-delete-photos'] = 'vendor/delete_photos/';
$route['vendor-stripe-pay'] = 'vendor/stripe/';
$route['vendor-stripe-response'] = 'vendor/stripe-response/';
$route['vendor-payment-cancel-stripe'] = 'vendor/payment_cancel_stripe/';
$route['vendor-payment-status'] = 'vendor/payment_status/';
