<?php

/**
* Recent feed block file
*
* This file holds the functions needed for the recent feed block
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH"))
	die("ICMS root path not defined");

function imfeeding_feed_recent_show($options) {
	include_once (ICMS_ROOT_PATH . '/modules/imfeeding/include/common.php');
	$imfeeding_feed_handler = xoops_getModuleHandler('feed', 'imfeeding');
	$feedObj = $imfeeding_feed_handler->get($options[0]);
	if ($feedObj && !$feedObj->isNew()) {
		$block['feed'] = $feedObj->getFeed($options[1]);
	}
	return $block;
}

function imfeeding_feed_recent_edit($options) {
	include_once (ICMS_ROOT_PATH . '/modules/imfeeding/include/common.php');
	$imfeeding_feed_handler = xoops_getModuleHandler('feed', 'imfeeding');

	$form = '<table><tr>';
	$form .= '<td>' . _MB_IMFEEDING_FEED_SELECT . '</td>';

	include_once(IMCS_ROOT_PATH . '/class/xoopsform/formselect.php');
	$form_select = new XoopsFormSelect('', 'options[]', $options[0]);
	$form_select->addOptionArray($imfeeding_feed_handler->getList());

	$form .= '<td>' . $form_select->render() . '</td></tr><tr>';

	$form .= '<td>' . _MB_IMFEEDING_FEED_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}
?>