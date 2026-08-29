<?php
/**
 * Plugin Name: Media Library Recovery
 * Plugin URI: https://krasenslavov.com/plugins/wp-media-recovery
 * Description: A tool that helps you to recover older and existing images from your <code>/wp-content/uploads</code> folder after database reset.
 * Version: 1.3
 * Author: Krasen Slavov
 * Author URI: https://krasenslavov.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: media-library-recovery
 * Domain Path: /lang
 *
 * Copyright 2018-2022 Krasen Slavov (email: hello@krasenslavov.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

// development
// ini_set( 'error_reporting', E_ALL | E_STRICT );
// ini_set( 'display_errors', 1 );

if ( ! class_exists( 'Media_Library_Recovery' ) ) {

	class Media_Library_Recovery {

		const DEV_MODE         = false;
		const VERSION          = '1.3';
		const PHP_MIN_VERSION  = '7.2';
		const WP_MIN_VERSION   = '5.0';
		const UUID             = 'mlr';
		const TEXTDOMAIN       = 'media-library-recovery';
		const PLUGIN_NAME      = 'Media Library Recovery';
		const PLUGIN_DOCURL    = 'https://krasenslavov.com/plugins/media-library-recovery/';
		const PLUGIN_WPORGURL  = 'https://wordpress.org/support/plugin/wp-media-recovery/';
		const PLUGIN_WPORGRATE = 'https://wordpress.org/support/plugin/wp-media-recovery/reviews/?filter=5';

		protected $settings;

		public function __construct() {
			$this->settings = array(
				'dev_mode'         => self::DEV_MODE,
				'version'          => self::VERSION,
				'php_min_version'  => self::PHP_MIN_VERSION,
				'wp_min_version'   => self::WP_MIN_VERSION,
				'uuid'             => self::UUID,
				'textdomain'       => self::TEXTDOMAIN,
				'plugin_name'      => self::PLUGIN_NAME,
				'plugin_docurl'    => self::PLUGIN_DOCURL,
				'plugin_wporgurl'  => self::PLUGIN_WPORGURL,
				'plugin_wporgrate' => self::PLUGIN_WPORGRATE,
				'plugin_url'       => plugin_dir_url( __FILE__ ),
				'plugin_basename'  => plugin_basename( __FILE__ ),
				'plugin_path'      => plugin_dir_path( __FILE__ ),
			);

			if ( $this->check_dependencies() ) {
				load_plugin_textdomain( $this->settings['textdomain'], false, $this->settings['plugin_basename'] . 'lang' );
			}
		}

		public function rating_notice_display() {
			if ( ! get_option( 'mlr_rating_notice' ) ) {
				?>
					<div class="notice notice-success is-dismissible">
						<h3>Media Library Recovery</h3>
						<p>
							Could you please kindly help the plugin in your turn by giving it 5 stars rating? (Thank you in advance)
						</p>
						<p>
							<a href="<?php echo esc_url( $this->settings['plugin_wporgrate'] ); ?>" target="_blank" class="button button-primary">Rate Us @ WordPress.org</a>
							<a href="?mlr_rating_notice_dismiss" class="button"><strong>I already did</strong></a>
							<a href="?mlr_rating_notice_dismiss" class="button"><strong>Don't show this notice again!</strong></a>
						</p>
						</p>
					</div>
				<?php
			}
		}

		public function rating_notice_dismiss() {
			if ( isset( $_GET['mlr_rating_notice_dismiss'] ) ) {
				add_option( 'mlr_rating_notice', 1 );
			}
		}

		public function check_dependencies() {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			if ( version_compare( PHP_VERSION, $this->settings['php_min_version'] ) >= 0
				&& version_compare( $GLOBALS['wp_version'], $this->settings['wp_min_version'] ) >= 0 ) {
				$check = true;
			} else {
				$check = false;
				add_action( 'admin_notices', array( $this, 'display_min_requirements_notice' ) );
			}

			if ( $check ) {
				return true;
			}

			deactivate_plugins( $this->settings['plugin_basename'] );

			return false;
		}

		public function display_min_requirements_notice() {
			?>
				<div class="notice notice-error">
					<p>
						<strong><?php echo $this->settings['plugin_name']; ?></strong> requires a minimum of <em>PHP <?php echo $this->settings['php_min_version']; ?></em> and <em>WordPress <?php echo $this->settings['wp_min_version']; ?></em>.
					</p>
					<p>
						You are currently running <strong>PHP <?php echo PHP_VERSION; ?></strong> and <strong>WordPress <?php echo $GLOBALS['wp_version']; ?></strong>.
					</p>
				</div>
			<?php
		}
	}

	new Media_Library_Recovery();

	// Core
	require_once 'classes/core/class-mlr-view.php';

	// Init
	require_once 'classes/class-mlr-init.php';

	// Events
	require_once 'classes/events/class-mlr-explorer.php';
	require_once 'classes/events/class-mlr-recover.php';
}
