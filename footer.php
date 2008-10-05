<?php
/**
* Footer page included at the end of each page on user side of the mdoule
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imfeeding
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

$xoopsTpl->assign("imfeeding_adminpage", imfeeding_getModuleAdminLink());
$xoopsTpl->assign("imfeeding_is_admin", $imfeeding_isAdmin);
$xoopsTpl->assign('imfeeding_url', IMFEEDING_URL);
$xoopsTpl->assign('imfeeding_images_url', IMFEEDING_IMAGES_URL);

$xoTheme->addStylesheet(IMFEEDING_URL . 'module.css');

$xoopsTpl->assign("ref_smartfactory", "imFeeding is developed by The SmartFactory (http://smartfactory.ca), a division of INBOX International (http://inboxinternational.com)");

include_once(ICMS_ROOT_PATH . '/footer.php');

?>