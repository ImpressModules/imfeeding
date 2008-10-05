<?php
/**
* Feed page
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @package imfeeding
* @version		$Id$
*/

/**
 * Edit a Blog Feed
 *
 * @param object $feedObj ImblogginFeed object to be edited
*/
function editfeed($feedObj)
{
	global $imfeeding_feed_handler, $xoopsTpl, $xoopsUser;

	if (!$feedObj->isNew()){
		if (!$feedObj->userCanEditAndDelete()) {
			redirect_header($feedObj->getItemLink(true), 3, _NOPERM);
		}
		$feedObj->hideFieldFromForm(array('feed_published_date', 'feed_uid', 'meta_keywords', 'meta_description', 'short_url'));
		$sform = $feedObj->getSecureForm(_MD_IMFEEDING_FEED_EDIT, 'addfeed');
		$sform->assign($xoopsTpl, 'imfeeding_feedform');
		$xoopsTpl->assign('imfeeding_category_path', $feedObj->getVar('feed_title') . ' > ' . _EDIT);
	} else {
		if (!$imfeeding_feed_handler->userCanSubmit()) {
			redirect_header(IMFEEDING_URL, 3, _NOPERM);
		}
		$feedObj->setVar('feed_uid', $xoopsUser->uid());
		$feedObj->setVar('feed_published_date', time());
		$feedObj->hideFieldFromForm(array('feed_published_date', 'feed_uid', 'meta_keywords', 'meta_description', 'short_url'));
		$sform = $feedObj->getSecureForm(_MD_IMFEEDING_FEED_SUBMIT, 'addfeed');
		$sform->assign($xoopsTpl, 'imfeeding_feedform');
		$xoopsTpl->assign('imfeeding_category_path', _SUBMIT);
	}
}

include_once 'header.php';

$xoopsOption['template_main'] = 'imfeeding_feed.html';
include_once ICMS_ROOT_PATH . '/header.php';

$imfeeding_feed_handler = xoops_getModuleHandler('feed');

/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';

if (isset($_GET['op'])) $clean_op = $_GET['op'];
if (isset($_FEED['op'])) $clean_op = $_FEED['op'];

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_feed_id = isset($_GET['feed_id']) ? intval($_GET['feed_id']) : 0 ;
$feedObj = $imfeeding_feed_handler->get($clean_feed_id);

/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','addfeed','del','');
/**
 * Only proceed if the supplied operation is a valid operation
 */
if (in_array($clean_op,$valid_op,true)){
  switch ($clean_op) {
	case "mod":
  		if ($clean_feed_id > 0 && $feedObj->isNew()) {
			redirect_header(imfeeding_getPreviousPage('index.php'), 3, _NOPERM);
		}
		editfeed($feedObj);
		break;

	case "addfeed":
        if (!$xoopsSecurity->check()) {
        	redirect_header(imfeeding_getPreviousPage('index.php'), 3, _MD_IMFEEDING_SECURITY_CHECK_FAILED . implode('<br />', $xoopsSecurity->getErrors()));
        }
          include_once ICMS_ROOT_PATH.'/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($imfeeding_feed_handler);
		$controller->storeFromDefaultForm(_MD_IMFEEDING_FEED_CREATED, _MD_IMFEEDING_FEED_MODIFIED);
		break;

	case "del":
		if (!$feedObj->userCanEditAndDelete()) {
			redirect_header($feedObj->getItemLink(true), 3, _NOPERM);
		}
		if (isset($_FEED['confirm'])) {
		    if (!$xoopsSecurity->check()) {
		    	redirect_header($impresscms->urls['previouspage'], 3, _MD_IMFEEDING_SECURITY_CHECK_FAILED . implode('<br />', $xoopsSecurity->getErrors()));
		    }
		}
  	    include_once ICMS_ROOT_PATH.'/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($imfeeding_feed_handler);
		$controller->handleObjectDeletionFromUserSide();
		$xoopsTpl->assign('imfeeding_category_path', $feedObj->getVar('feed_title') . ' > ' . _DELETE);

		break;

	default:
		if ($feedObj && !$feedObj->isNew()) {
			$xoopsTpl->assign('imfeeding_feed', $feedObj->getFeed());
			$xoopsTpl->assign('imfeeding_category_path', $feedObj->getVar('feed_title'));
		} else {
			redirect_header(IMFEEDING_URL, 3, _NOPERM);
		}

		break;
}

/**
 * Generating meta information for this page
 */
$icms_metagen = new IcmsMetagen($feedObj->getVar('feed_title'), $feedObj->getVar('meta_keywords','n'), $feedObj->getVar('meta_description', 'n'));
$icms_metagen->createMetaTags();

}
$xoopsTpl->assign('imfeeding_module_home', imfeeding_getModuleName(true, true));

include_once 'footer.php';
?>