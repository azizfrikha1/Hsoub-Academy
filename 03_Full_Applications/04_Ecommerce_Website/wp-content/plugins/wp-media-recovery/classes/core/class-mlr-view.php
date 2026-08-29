<?php

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'MLR_View' ) ) {

	require_once WP_PLUGIN_DIR . '/wp-media-recovery/classes/events/class-mlr-explorer.php';

	class MLR_View extends Media_Library_Recovery {

		public function __construct() {
			parent::__construct();
			$this->explorer = new MLR_Explorer();
		}

		public function load_media_explorer() {
			?>
				<div class="mlr">
					<div class="mlr-container">
						<h1>
							Media Library Recovery
							<hr />
						</h1>
						<p>
							A tool that helps you recover older and existing images from your <strong>/wp-content/uploads</strong> folder after database reset.
						</p>
						<p>
							Click on any of the media items below to mark it up for recovery:
						</p>
						<p>
							<label>
								<input type="checkbox" name="mlr-hide-existing-media" /> Hide all existing media already found in the media library.
							</label>
						</p>
						<div class="mlr-media-explorer">
							<?php echo $this->explorer->media_explorer(); ?>
						</div>
						<p>
							<div class="mlr-media-explore-nav">
								<div class="button-action">
									<button class="button button-primary button-large" name="mlr-recover-media-button"><i class="dashicons dashicons-backup"></i>Recover Media</button><span></span>
								</div>
								<div class="button-group">
									<a href="?page=media-library-recovery&p=<?php echo ( isset( $_GET['p'] ) && $_GET['p'] > 1 ) ? ( $_GET['p'] - 1 ) : 1; ?>" class="button button-primary button-large">&larr; Previous Page</a>
									<a href="?page=media-library-recovery&p=<?php echo ( isset( $_GET['p'] ) && $_GET['p'] > 0 ) ? ( $_GET['p'] + 1 ) : 2; ?>" class="button button-primary button-large">Next Page &rarr;</a>
								</div>
							</div>
						</p>
						<hr />
						<p>
							<a href="javascript:void();" class="button" onclick="window.location.reload(true);"><strong>Reload...</strong></a>
						</p>
						<p>
							<em>Note: Refresh this page manually if the recovering process doesn't complete successfully within a couple of minutes.</em>
						</p>
						<hr />
						<p>
							<strong>This tool DOES NOT re-upload any media on the server</strong>, and it will only scan the existing media folders and display all the media. Then you will have the ability to individually select the media files you want to recover or use the filters to speed up the process.
						</p>
						<p>
							When you delete an image or any media file from your library, it will only remove it from the database. However, you might decide to use this media again, and instead of uploading it and using up your server storage with <em>Media Library Recovery</em>, you can restore the existing media from the uploads directory and re-insert it into the WordPress database.
						</p>
						<p>
							<em>Note: If you choose to retrieve any existing media, it will create a duplicate one.</em>
						</p>
						<hr />
						<p>
							If something is not clear, please open a ticket on the official plugin <a href="<?php echo esc_url( $this->settings['plugin_wporgurl'] ); ?>" target="_blank">Support Forum</a>. All tickets should be addressed within a couple of working days.
						</p>
						<p>
							<i class="dashicons dashicons-visibility"></i> Files already recovered and found in the media library.<br />
							<i class="dashicons dashicons-hidden"></i> Hidden files not currently showing up in the media library and availble for recovery.<br />
							<i class="dashicons dashicons-yes"></i> Selected files that you want to recover and show in your media library.
						</p>
						<hr />
						<div class="mlr-notice">
							<p>
								<strong>Please rate us</strong>
								<a href="<?php echo esc_url( $this->settings['plugin_wporgrate'] ); ?>" target="_blank"><img src="<?php echo esc_url( $this->settings['plugin_url'] ); ?>assets/img/rate.png" alt="Rate us @ WordPress.org" /></a>
							</p>
							<p>
								<strong>Having issues?</strong>
								<a href="<?php echo esc_url( $this->settings['plugin_wporgurl'] ); ?>" target="_blank">Create a Support Ticket</a>
							</p>
							<p>
								<strong>Developed by</strong>
								<a href="https://krasenslavov.com/" target="_blank">Krasen Slavov @ Developry</a>
							</p>
						</div>
					</div>
				</div>
			<?php
		}
	}
}
