<?php
/**
 * Deactivation Survey Feedback.
 *
 * @package deactivation-survey
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Deactivation_Survey_Helper' ) ) {

	/**
	 * Class Deactivation_Survey_Helper.
	 */
	class Deactivation_Survey_Helper {


		/**
		 * Get the array of default reasons.
		 *
		 * @return array Default reasons.
		 */
		public static function get_default_reasons() {

			return apply_filters(
				'uds_default_deactivation_reasons',
				[
					'temporary_deactivation' => [
						'label'           => esc_html__( 'This is a temporary deactivation for testing.', 'user-deactivation-survey' ),
						'placeholder'     => esc_html__( 'How can we assist you?', 'user-deactivation-survey' ),
						'show_cta'        => 'false',
						'accept_feedback' => 'false',
					],
					'plugin_not_working'     => [
						'label'           => esc_html__( 'The plugin isn\'t working properly.', 'user-deactivation-survey' ),
						'placeholder'     => esc_html__( 'Please tell us more about what went wrong?', 'user-deactivation-survey' ),
						'show_cta'        => 'true',
						'accept_feedback' => 'true',
					],
					'found_better_plugin'    => [
						'label'           => esc_html__( 'I found a better alternative plugin.', 'user-deactivation-survey' ),
						'placeholder'     => esc_html__( 'Could you please specify which plugin?', 'user-deactivation-survey' ),
						'show_cta'        => 'false',
						'accept_feedback' => 'true',
					],
					'missing_a_feature'      => [
						'label'           => esc_html__( 'It\'s missing a specific feature.', 'user-deactivation-survey' ),
						'placeholder'     => esc_html__( 'Please tell us more about the feature.', 'user-deactivation-survey' ),
						'show_cta'        => 'false',
						'accept_feedback' => 'true',
					],
					'other'                  => [
						'label'           => esc_html__( 'Other', 'user-deactivation-survey' ),
						'placeholder'     => esc_html__( 'Please tell us more details.', 'user-deactivation-survey' ),
						'show_cta'        => 'false',
						'accept_feedback' => 'true',
					],
				]
			);
		}

		/**
		 * Check is error in the received response.
		 *
		 * @param object $response Received API Response.
		 * @return array $result Error result.
		 */
		public static function is_api_error( $response ) {

			$result = [
				'error'         => false,
				'error_message' => __( 'Oops! Something went wrong. Please refresh the page and try again.', 'user-deactivation-survey' ),
				'error_code'    => 0,
			];

			if ( is_wp_error( $response ) ) {
				$result['error']         = true;
				$result['error_message'] = $response->get_error_message();
				$result['error_code']    = $response->get_error_code();
			} elseif ( ! empty( wp_remote_retrieve_response_code( $response ) ) && ! in_array( wp_remote_retrieve_response_code( $response ), [ 200, 201, 204 ], true ) ) {
				$result['error']         = true;
				$result['error_message'] = wp_remote_retrieve_response_message( $response );
				$result['error_code']    = wp_remote_retrieve_response_code( $response );
			}

			return $result;
		}

		/**
		 * Get API headers
		 *
		 * @since 1.0.0
		 * @return array<string, string>
		 */
		public static function get_api_headers() {
			return [
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			];
		}

		/**
		 * Get the API URL.
		 *
		 * @since  1.0.0
		 *
		 * @return string
		 */
		public static function get_api_domain() {
			return trailingslashit( defined( 'UDS_REMOTE_SERVER_URL' ) ? UDS_REMOTE_SERVER_URL : apply_filters( 'uds_survey_api_domain', 'https://templates.cartflows.com/' ) );
		}

		/**
		 * Get the API Base.
		 *
		 * @since  1.0.0
		 *
		 * @return string
		 */
		public static function get_api_base() {
			return trailingslashit( defined( 'UDS_API_BASE' ) ? UDS_API_BASE : apply_filters( 'uds_survey_api_base', 'wp-json/cartflows-server/v1' ) );
		}


		/**
		 * Get the API target URL.
		 *
		 * @since  1.0.0
		 *
		 * @param string $endpoint The API endpoint.
		 * @return string The full API target URL.
		 */
		public static function get_api_target_url( $endpoint ) {
			return self::get_api_domain() . self::get_api_base() . $endpoint;
		}

		/**
		 * Check if the current screen is allowed for the survey.
		 *
		 * This function checks if the current screen is one of the allowed screens for displaying the survey.
		 * It uses the `get_current_screen` function to get the current screen information and compares it with the list of allowed screens.
		 *
		 * @since 1.0.0
		 * @return bool True if the current screen is allowed, false otherwise.
		 */
		public static function is_allowed_screen() {

			// This filter allows to dynamically modify the list of allowed screens for the survey.
			$allowed_screens = apply_filters( 'uds_survey_allowed_screens', [ 'plugins', 'themes' ] );

			$current_screen = get_current_screen();

			// Check if $current_screen is a valid object before accessing its properties.
			if ( ! is_object( $current_screen ) ) {
				return false; // Return false if current screen is not valid.
			}

			$screen_id = $current_screen->id;

			if ( ! empty( $screen_id ) && in_array( $screen_id, $allowed_screens, true ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Get base URL for the astra-notices.
		 *
		 * @return mixed URL.
		 */
		public static function get_assets_url() {
			$path      = wp_normalize_path( UDS_DIR );
			$theme_dir = wp_normalize_path( get_template_directory() );

			if ( strpos( $path, $theme_dir ) !== false ) {
				return trailingslashit( get_template_directory_uri() . str_replace( $theme_dir, '', $path ) );
			} else {
				return UDS_URL;
			}
		}
	}

}
