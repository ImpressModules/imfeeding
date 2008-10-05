<?php
/**
* imFeeding version infomation
*
* This file holds the configuration information of this module
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imfeeding
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
  'name'=> _MI_IMFEEDING_MD_NAME,
  'version'=> 1.0,
  'description'=> _MI_IMFEEDING_MD_DESC,
  'author'=> "The SmartFactory",
  'credits'=> "INBOX International inc.",
  'help'=> "",
  'license'=> "GNU General Public License (GPL)",
  'official'=> 0,
  'dirname'=> basename( dirname( __FILE__ ) ),

/**  Images information  */
  'iconsmall'=> "images/icon_small.png",
  'iconbig'=> "images/icon_big.png",
  'image'=> "images/icon_big.png", /* for backward compatibility */

/**  Development information */
  'status_version'=> "Beta 1",
  'status'=> "Beta",
  'date'=> "unreleased",
  'author_word'=> "",

/** Contributors */
  'developer_website_url' => "http://smartfactory.ca",
  'developer_website_name' => "The SmartFactory",
  'developer_email' => "info@smartfactory.ca");
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=1]marcan[/url] (Marc-Andr&eacute; Lanciault)";
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=112]felix[/url] (F&eacute;lix Tousignant)";
//$modversion['people']['testers'][] = "";
//$modversion['people']['translators'][] = "";
//$modversion['people']['documenters'][] = "";
//$modversion['people']['other'][] = "";
//$modversion['warning'] = _CO_SOBJECT_WARNING_BETA;

/** Administrative information */
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

/** Database information */
$modversion['object_items'][1] = 'feed';
$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

/** Install and update informations */
$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

/** Search information */
$modversion['hasSearch'] = 1;
$modversion['search'] = array (
  'file' => "include/search.inc.php",
  'func' => "imfeeding_search");

/** Menu information */
$modversion['hasMain'] = 1;

/** Blocks information */
/*$modversion['blocks'][1] = array(
  'file' => 'tag_recent.php',
  'name' => _MI_IMFEEDING_TAGRECENT,
  'description' => _MI_IMFEEDING_TAGRECENTDSC,
  'show_func' => 'imfeeding_tag_recent_show',
  'edit_func' => 'imfeeding_tag_recent_edit',
  'options' => '5',
  'template' => 'imfeeding_tag_recent.html');

$modversion['blocks'][] = array(
  'file' => 'tag_by_month.php',
  'name' => _MI_IMFEEDING_TAGBYMONTH,
  'description' => _MI_IMFEEDING_TAGBYMONTHDSC,
  'show_func' => 'imfeeding_tag_by_month_show',
  'edit_func' => 'imfeeding_tag_by_month_edit',
  'options' => '',
  'template' => 'imfeeding_tag_by_month.html');
*/

/** Templates information */
$modversion['templates'][1] = array(
  'file' => 'imfeeding_header.html',
  'description' => 'Module Header');

$modversion['templates'][] = array(
  'file' => 'imfeeding_footer.html',
  'description' => 'Module Footer');

$modversion['templates'][]= array(
  'file' => 'imfeeding_admin_feed.html',
  'description' => 'Feeds Index');

$modversion['templates'][] = array(
  'file' => 'imfeeding_index.html',
  'description' => 'Feeds Index');

$modversion['templates'][] = array(
  'file' => 'imfeeding_single_feed.html',
  'description' => 'Single Feed template');

$modversion['templates'][] = array(
  'file' => 'imfeeding_feed.html',
  'description' => 'Feed page');

/** Preferences information */

/*$modversion['config'][] = array(
  'name' => 'tags_limit',
  'title' => '_MI_IMFEEDING_LIMIT',
  'description' => '_MI_IMFEEDING_LIMITDSC',
  'formtype' => 'textbox',
  'valuetype' => 'text',
  'default' => 5);
*/

/** Comments information */
$modversion['hasComments'] = 0;

/** Notification information */
$modversion['hasNotification'] = 0;

?>