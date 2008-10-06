<?php
/**
* Classes responsible for managing imFeeding feed objects
*
* @copyright	http://smartfactory.ca The SmartFactory
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// including the IcmsPersistabelSeoObject
include_once ICMS_ROOT_PATH."/kernel/icmspersistableseoobject.php";

class ImfeedingFeed extends IcmsPersistableSeoObject {

    /**
     * Constructor
     *
     * @param object $handler ImfeedingFeedHandler object
     */
    public function __construct(&$handler){
    	global $xoopsConfig;

    	$this->IcmsPersistableObject($handler);

        $this->quickInitVar('feed_id', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('feed_title', XOBJ_DTYPE_TXTBOX);
        $this->quickInitVar('feed_description', XOBJ_DTYPE_TXTAREA);
        $this->quickInitVar('feed_url', XOBJ_DTYPE_TXTBOX);
        $this->quickInitVar('feed_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('feed_cache', XOBJ_DTYPE_INT);
		$this->quickInitVar('feed_last_updated', XOBJ_DTYPE_LTIME);

		$this->setControl('feed_uid', 'user');

		$this->hideFieldFromForm(array('feed_last_updated'));

		$this->IcmsPersistableSeoObject();
    }

    /**
     * Overriding the IcmsPersistableObject::getVar method to assign a custom method on some
     * specific fields to handle the value before returning it
     *
     * @param str $key key of the field
     * @param str $format format that is requested
     * @return mixed value of the field that is requested
     */
    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array())) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function getFeed() {
    	$ret = array();
		// Create a new instance of the SimplePie object
		$feed = new IcmsSimpleRss($this->getVar('feed_url'), 0);
		if ($feed) {
			$ret['title'] = $feed->get_title();
			$ret['link'] = $feed->get_link();
			$ret['image_url'] = $feed->get_image_url();
			$ret['image_title'] = $feed->get_image_title();
			$ret['image_link'] = $feed->get_image_link();
			$ret['description'] = $feed->get_description();
			foreach($feed->get_items() as $feed_item) {
				$item = array();
				$item['permalink'] = $feed_item->get_permalink();
				$item['title'] = $feed_item->get_title();
				$item['content'] = $feed_item->get_content();
				$ret['items'][] = $item;
			}
		}
		return $ret;
    }
}

class ImfeedingFeedHandler extends IcmsPersistableObjectHandler {

	public $parentName = 'feed_pid';

	/**
	 * Constructor
	 */
    public function __construct(&$db){
        $this->IcmsPersistableObjectHandler($db, 'feed', 'feed_id', 'feed_title', 'feed_description', 'imfeeding');
    }
}
?>