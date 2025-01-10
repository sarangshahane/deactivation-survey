<?php

namespace {
    /**
     * Class Deactivation_Survey_Feedback.
     */
    class Deactivation_Survey_Feedback
    {
        /**
         * Initiator
         *
         * @since 1.0.0
         * @return object initialized object of class.
         */
        public static function get_instance()
        {
        }
        /**
         * Constructor
         */
        public function __construct()
        {
        }
        /**
         * Register feedback script on plugins.php admin page only.
         *
         * @since 1.0.0
         * @param string $hook_suffix The current hook.
         * @return void
         */
        public function add_feedback_script($hook_suffix)
        {
        }
        /**
         * Render feedback HTML on plugins.php admin page only.
         *
         * This function renders the feedback form HTML on the plugins.php admin page.
         * It takes an optional string parameter $id for the form wrapper ID and an optional array parameter $args for customizing the form.
         *
         * @since 1.0.0
         * @param string $id Optional. The ID for the form wrapper. Defaults to 'uds-feedback-form--wrapper'.
         * @param array  $args Optional. Custom arguments for the form. Defaults to an empty array.
         * @return void
         */
        public static function show_feedback_form(string $id, array $args = [])
        {
        }
        /**
         * Load form styles.
         *
         * This function loads the necessary styles for the feedback form.
         *
         * @since 1.0.0
         * @param array $args Arguments.
         * @return void
         */
        public static function load_form_styles($args)
        {
        }
        /**
         * Sends plugin deactivation feedback to the server.
         *
         * This function checks the user's permission to manage CartFlows flows steps and verifies the nonce for the request.
         * If the checks pass, it sends the feedback data to the server for processing.
         *
         * @return void
         */
        public function send_plugin_deactivate_feedback()
        {
        }
    }
    /**
     * Class Deactivation_Survey_Helper.
     */
    class Deactivation_Survey_Helper
    {
        /**
         * Get the array of default reasons.
         *
         * @return array Default reasons.
         */
        public static function get_default_reasons()
        {
        }
        /**
         * Check is error in the received response.
         *
         * @param object $response Received API Response.
         * @return array $result Error result.
         */
        public static function is_api_error($response)
        {
        }
        /**
         * Get API headers
         *
         * @since 1.0.0
         * @return array<string, string>
         */
        public static function get_api_headers()
        {
        }
        /**
         * Get the API URL.
         *
         * @since  1.0.0
         *
         * @return string
         */
        public static function get_api_domain()
        {
        }
        /**
         * Get the API Base.
         *
         * @since  1.0.0
         *
         * @return string
         */
        public static function get_api_base()
        {
        }
        /**
         * Get the API target URL.
         *
         * @since  1.0.0
         *
         * @param string $endpoint The API endpoint.
         * @return string The full API target URL.
         */
        public static function get_api_target_url($endpoint)
        {
        }
    }
}
namespace UDS_Loader {
    /**
     * UDS_Plugin_Loader
     *
     * @since 1.0.0
     */
    class UDS_Plugin_Loader
    {
        /**
         * Initiator
         *
         * @since 1.0.0
         * @return object initialized object of class.
         */
        public static function get_instance()
        {
        }
        /**
         * Autoload classes.
         *
         * @param string $class class name.
         */
        public function autoload($class)
        {
        }
        /**
         * Constructor
         *
         * @since 1.0.0
         */
        public function __construct()
        {
        }
        /**
         * Load Plugin Text Domain.
         * This will load the translation textdomain depending on the file priorities.
         *   1. Global Languages /wp-content/languages/user-deactivation-survey/ folder
         *   2. Local dorectory /wp-content/plugins/user-deactivation-survey/languages/ folder
         *
         * @since 1.0.0
         * @return void
         */
        public function load_textdomain()
        {
        }
        /**
         * Load Library Classes
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function load_classes()
        {
        }
    }
}
namespace {
    /**
     * Plugin Name: User Deactivation Survery
     * Description: This plugin is used to collect feedback before deactivating the plugin.
     * Author: Brainstorm Force
     * Author URI: https://brainstormforce.com/
     * Version: 1.0.0
     * License: GPL v2
     * Text Domain: user-deactivation-survey
     *
     * @package {{package}}
     */
    /**
     * Set constants
     */
    \define('UDS_FILE', __FILE__);
    \define('UDS_BASE', \plugin_basename(\UDS_FILE));
    \define('UDS_DIR', \plugin_dir_path(\UDS_FILE));
    \define('UDS_URL', \plugins_url('/', \UDS_FILE));
    \define('UDS_VER', '1.0.0');
}
