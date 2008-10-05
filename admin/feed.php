<?php
/**
* Admin page to manage feeds
*
* List, add, edit and delete feed objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

/**
 * Edit a Feed
 *
 * @param int $feed_id Feedid to be edited
*/
function editfeed($feed_id = 0)
{
	global $imfeeding_feed_handler, $xoopsModule, $icmsAdminTpl;

	$feedObj = $imfeeding_feed_handler->get($feed_id);

	if (!$feedObj->isNew()){

		$xoopsModule->displayAdminMenu(0, _AM_IMFEEDING_CATEGORIES . " > " . _CO_ICMS_EDITING);
		$sform = $feedObj->getForm(_AM_IMFEEDING_FEED_EDIT, 'addfeed');
		$sform->assign($icmsAdminTpl);

	} else {
		$xoopsModule->displayAdminMenu(0, _AM_IMFEEDING_CATEGORIES . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $feedObj->getForm(_AM_IMFEEDING_FEED_CREATE, 'addfeed');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:imfeeding_admin_feed.html');
}

include_once("admin_header.php");

$imfeeding_feed_handler = xoops_getModuleHandler('feed');
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = '';
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ('mod','changedField','addfeed','del','view','');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_feed_id = isset($_GET['feed_id']) ? (int) $_GET['feed_id'] : 0 ;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op,$valid_op,true)){
  switch ($clean_op) {
  	case "mod":
  	case "changedField":

  		xoops_cp_header();

  		editfeed($clean_feed_id);
  		break;
  	case "addfeed":
          include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
          $controller = new IcmsPersistableController($imfeeding_feed_handler);
  		$controller->storeFromDefaultForm(_AM_IMFEEDING_FEED_CREATED, _AM_IMFEEDING_FEED_MODIFIED);

  		break;

  	case "del":
  	    include_once ICMS_ROOT_PATH."/kernel/icmspersistablecontroller.php";
          $controller = new IcmsPersistableController($imfeeding_feed_handler);
  		$controller->handleObjectDeletion();

  		break;

  	default:

  		xoops_cp_header();

  		$xoopsModule->displayAdminMenu(0, _AM_IMFEEDING_FEEDS);

  		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";
  		$objectTable = new IcmsPersistableTable($imfeeding_feed_handler);
  		$objectTable->addColumn(new IcmsPersistableColumn('feed_title', 'left', '200'));
  		$objectTable->addColumn(new IcmsPersistableColumn('feed_description'));

  		$objectTable->addIntroButton('addfeed', 'feed.php?op=mod', _AM_IMFEEDING_FEED_CREATE);
  		$objectTable->addQuickSearch(array('feed_title', 'feed_description'));

  		$icmsAdminTpl->assign('imfeeding_feed_table', $objectTable->fetch());

  		$icmsAdminTpl->display('db:imfeeding_admin_feed.html');
  		break;
  }
  xoops_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */
?>