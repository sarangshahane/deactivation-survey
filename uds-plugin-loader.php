<?php
/**
 * Plugin Loader.
 *
 * @package deactivation-survey
 * @since x.x.x
 */

namespace UDS_Loader;

if ( ! class_exists( 'UDS_Plugin_Loader' ) ) {

	/**
	 * UDS_Plugin_Loader
	 *
	 * @since X.X.X
	 */
	class UDS_Plugin_Loader {

		/**
		 * Instance
		 *
		 * @access private
		 * @var UDS_Plugin_Loader Class Instance.
		 * @since X.X.X
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since X.X.X
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Autoload classes.
		 *
		 * @param string $class class name.
		 */
		public function autoload( $class ) {
			if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
				return;
			}

			$class_to_load = $class;

			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);

			$file = UDS_DIR . $filename . '.php';

			// if the file redable, include it.
			if ( is_readable( $file ) ) {
				require_once $file;
			}
		}

		/**
		 * Constructor
		 *
		 * @since X.X.X
		 */
		public function __construct() {

			spl_autoload_register( [ $this, 'autoload' ] );

			add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
			add_action( 'wp_loaded', [ $this, 'load_classes' ] );
		}

		/**
		 * Load Plugin Text Domain.
		 * This will load the translation textdomain depending on the file priorities.
		 *   1. Global Languages /wp-content/languages/user-deactivation-survey/ folder
		 *   2. Local dorectory /wp-content/plugins/user-deactivation-survey/languages/ folder
		 *
		 * @since X.X.X
		 * @return void
		 */
		public function load_textdomain() {
			// Default languages directory.
			$lang_dir = UDS_DIR . 'languages/';

			/**
			 * Filters the languages directory path to use for plugin.
			 *
			 * @param string $lang_dir The languages directory path.
			 */
			$lang_dir = apply_filters( 'uds_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter.
			global $wp_version;

			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			/**
			 * Language Locale for plugin
			 *
			 * @var $get_locale The locale to use.
			 * Uses get_user_locale()` in WordPress 4.7 or greater,
			 * otherwise uses `get_locale()`.
			 */
			$locale = apply_filters( 'plugin_locale', $get_locale, 'user-deactivation-survey' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'user-deactivation-survey', $locale );

			// Setup paths to current locale file.
			$mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;
			$mofile_local  = $lang_dir . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/user-deactivation-survey/ folder.
				load_textdomain( 'user-deactivation-survey', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/user-deactivation-survey/languages/ folder.
				load_textdomain( 'user-deactivation-survey', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'user-deactivation-survey', false, $lang_dir );
			}
		}

		/**
		 * Load Library Classes
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function load_classes() {

			// Load the helper classes.
			require_once UDS_DIR . 'classes/class-deactivation-survey-helper.php';

			// Load the library core functionality.
			require_once UDS_DIR . 'classes/class-deactivation-survey-feedback.php';

		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	UDS_Plugin_Loader::get_instance();
}
