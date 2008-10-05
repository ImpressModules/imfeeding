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
	?>
		<div id="sp_results">

			<!-- As long as the feed has data to work with... -->
			<?php if ($feed): ?>


				<!-- Let's begin looping through each individual news item in the feed. -->
				<?php foreach($feed->get_items() as $item): ?>
					<div class="chunk">

						<?php
						// Let's add a favicon for each item. If one doesn't exist, we'll use an alternate one.
						if (!$favicon = $feed->get_favicon())
						{
							$favicon = './for_the_demo/favicons/alternate.png';
						}
						?>

						<!-- If the item has a permalink back to the original post (which 99% of them do), link the item's title to it. -->
						<h4><img src="<?php echo $favicon; ?>" alt="Favicon" class="favicon" /><?php if ($item->get_permalink()) echo '<a href="' . $item->get_permalink() . '">'; echo $item->get_title(); if ($item->get_permalink()) echo '</a>'; ?></h4>

						<!-- Display the item's primary content. -->
						<?php echo $item->get_content(); ?>

						<?php
						// Check for enclosures.  If an item has any, set the first one to the $enclosure variable.
						if ($enclosure = $item->get_enclosure(0))
						{
							// Use the embed() method to embed the enclosure into the page inline.
							echo '<div align="center">';
							echo '<p>' . $enclosure->embed(array(
								'audio' => './for_the_demo/place_audio.png',
								'video' => './for_the_demo/place_video.png',
								'mediaplayer' => './for_the_demo/mediaplayer.swf',
								'alt' => '<img src="./for_the_demo/mini_podcast.png" class="download" border="0" title="Download the Podcast (' . $enclosure->get_extension() . '; ' . $enclosure->get_size() . ' MB)" />',
								'altclass' => 'download'
							)) . '</p>';
							echo '<p class="footnote" align="center">(' . $enclosure->get_type();
							if ($enclosure->get_size())
							{
								echo '; ' . $enclosure->get_size() . ' MB';
							}
							echo ')</p>';
							echo '</div>';
						}
						?>

					</div>

				<!-- Stop looping through each item once we've gone through all of them. -->
				<?php endforeach; ?>

			<!-- From here on, we're no longer using data from the feed. -->
			<?php endif; ?>

		</div>

	</div>
	<?php
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