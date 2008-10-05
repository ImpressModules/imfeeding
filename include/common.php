<?php
/**
* Common file of the module included on all pages of the module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("IMFEEDING_DIRNAME"))		define("IMFEEDING_DIRNAME", $modversion['dirname'] = basename(dirname(dirname(__FILE__))));
if(!defined("IMFEEDING_URL"))			define("IMFEEDING_URL", ICMS_URL.'/modules/'.IMFEEDING_DIRNAME.'/');
if(!defined("IMFEEDING_ROOT_PATH"))	define("IMFEEDING_ROOT_PATH", ICMS_ROOT_PATH.'/modules/'.IMFEEDING_DIRNAME.'/');
if(!defined("IMFEEDING_IMAGES_URL"))	define("IMFEEDING_IMAGES_URL", IMFEEDING_URL.'images/');
if(!defined("IMFEEDING_ADMIN_URL"))	define("IMFEEDING_ADMIN_URL", IMFEEDING_URL.'admin/');

// Include the common language file of the module
icms_loadLanguageFile('imfeeding', 'common');

include_once(IMFEEDING_ROOT_PATH . "include/functions.php");

// Creating the module object to make it available throughout the module
$imfeedingModule = icms_getModuleInfo(IMFEEDING_DIRNAME);
if (is_object($imfeedingModule)){
	$imfeeding_moduleName = $imfeedingModule->getVar('name');
}

// Find if the user is admin of the module and make this info available throughout the module
$imfeeding_isAdmin = icms_userIsAdmin(IMFEEDING_DIRNAME);

// Creating the module config array to make it available throughout the module
$imfeedingConfig = icms_getModuleConfig(IMFEEDING_DIRNAME);

// including the tag class
include_once(IMFEEDING_ROOT_PATH . 'class/feed.php');

// creating the icmsPersistableRegistry to make it available throughout the module
global $icmsPersistableRegistry;
$icmsPersistableRegistry = IcmsPersistableRegistry::getInstance();

?>