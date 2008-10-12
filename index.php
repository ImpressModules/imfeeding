<?php
/**
* Index page
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imfeeding
* @version		$Id$
*/
/** Include the module's header for all pages */
include_once 'header.php';

$xoopsOption['template_main'] = 'imfeeding_index.html';
/** Include the ICMS header file */
include_once ICMS_ROOT_PATH . '/header.php';

// At which record shall we start display
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$imfeeding_feed_handler = xoops_getModuleHandler('feed');

$xoopsTpl->assign('imfeeding_feeds', $imfeeding_feed_handler->getFeeds($clean_start, $xoopsModuleConfig['feeds_limit']));

/**
 * Create Navbar
 */
include_once ICMS_ROOT_PATH . '/class/pagenav.php';
$feeds_count = $imfeeding_feed_handler->getFeedsCount();
$pagenav = new XoopsPageNav($feeds_count, $xoopsModuleConfig['feeds_limit'], $clean_start, 'start');
$xoopsTpl->assign('navbar', $pagenav->renderNav());

$xoopsTpl->assign('imfeeding_module_home', imfeeding_getModuleName(true, true));
/** Include the module's footer */
include_once 'footer.php';
?>