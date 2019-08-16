<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SP', "/");
define('IMAGE_PATH', FCPATH.'assets'.SP.'images'.SP.'products'.SP);
define('IMAGE_LOC', FCPATH.'assets'.SP.'images'.SP);
define('FILE_LOC', FCPATH.'files'.SP);
define('IMAGE_URL_PATH', 'assets/images/products/');

define('PRODUCT_IMAGE_LARGE_WIDTH', 700);
define('PRODUCT_IMAGE_LARGE_HEIGHT', 500);

define('PRODUCT_IMAGE_SMALL_WIDTH', 231);
define('PRODUCT_IMAGE_SMALL_HEIGHT', 202);

define('PRODUCT_IMAGE_MEDIUM_WIDTH', 500);
define('PRODUCT_IMAGE_MEDIUM_HEIGHT', 300);
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/**
 * Custom constants
 */
define('PAGINATE_PER_PAGE', 1);

/* End of file constants.php */
/* Location: ./application/config/constants.php */
