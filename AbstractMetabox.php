<?php
/**
 * Abstract class for use when registering metaboxes for the classic editor.
 *
 * The minimum requirement here is to provide an $id and to create render()
 * and save_data() methods.
 *
 * @package   PattonWebz Metabox Registration Class
 * @version   0.1.0
 * @since     0.1.0
 * @author    William Patton <will@pattonwebz.com>
 * @copyright Copyright (c) 2018-2019, William Patton
 * @license   GPLv2 or later
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace PattonWebz\Metabox;

/**
 * Registering Metaboxes in a standardised way.
 */
abstract class AbstractMetabox {
	/**
	 * Screen or Post Type to attach metabox to.
	 *
	 * @since  0.1.0
	 * @var    string|array|WP_Screen
	 */
	public $post_type = null;

	/**
	 * Metabox id used when registering.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	public $id;

	/**
	 * Title to be used for the metabox.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	public $title;

	/**
	 * The 'context' to load the metabox in the page.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	public $context = 'normal';

	/**
	 * Metabox priority.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	public $priority = 'default';

	/**
	 * Setup post type and add actions.
	 *
	 * @since  0.1.0
	 * @param  string $post_type  the current post type or screen.
	 */
	public function __construct( $post_type ) {
		$this->post_type = $post_type;
	}

	/**
	 * Adds the hooks to handle this metabox, including adding our save method
	 * to the save_post hook.
	 *
	 * @method register
	 * @since  0.1.0
	 */
	public function register() {
		add_action( 'add_meta_boxes_' . $this->post_type, [ $this, 'init' ] );
		add_action( 'save_post', [ $this, 'save_data' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Enqueue styles and scripts for this metabox in this method.
	 *
	 * @method enqueue
	 * @since  0.1.0
	 * @param  string $hook The current page hook.
	 */
	public function enqueue( $hook ) {
		/**
		 * Stub
		 */
	}

	/**
	 * Initiator that adds the metabox.
	 *
	 * @method init
	 * @since  0.1.0
	 */
	public function init() {
		add_meta_box(
			$this->id,
			$this->title,
			[ $this, 'render' ],
			$this->post_type,
			$this->context,
			$this->priority
		);
	}

	/**
	 * The rednder method that provides html for the inputs. Output nonce here.
	 *
	 * @method render
	 * @since  0.1.0
	 * @param  \WP_Post` $post the current post object.
	 */
	abstract public function render( $post );

	/**
	 * The method called on save. Check nonce and permissions here as well as
	 * validate the data.
	 *
	 * @method save_data
	 * @since  0.1.0
	 * @param  string $post_id The current post id.
	 */
	abstract public function save_data( $post_id );
}
