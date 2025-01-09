# Deactivation Survey Library.

## Description

The Deactivation Survey plugin allows you to gather feedback from users when they deactivate your WordPress plugin. This valuable information can help you understand user behavior and improve your plugin based on real user insights.

## Features

-   Collect user feedback upon plugin deactivation.
-   Customizable survey questions.
-   Easy integration with existing WordPress plugins.
-   View responses in the WordPress admin dashboard.

## How to Integration

1. Add the library file in your plugin's or theme's loader file such as `require_once <Add Your Dir Path> . 'libraries/deactivation-survey/deactivation-survey.php';`.
2. Add the following code in your notices class from where you are adding plugin notices:

```php
public function load_deactivation_survay_form()
{
    if( class_exists( 'Deactivation_Survey_Feedback' ) ){
        Deactivation_Survey_Feedback::show_feedback_form(
            'deactivation-survay-cartflows',
            array(
                'source'            => 'cartflows',
                'popup_logo'        => CARTFLOWS_URL . 'admin-core/assets/images/cartflows-icon.svg',
                'popup_title'       => __( 'Quick Feedback', 'cartflows' ),
                'support_url'       => 'https://cartflows.com/contact/',
                'popup_description' => __( 'If you have a moment, please share why you are deactivating CartFlows:', 'cartflows' ),
            )
        );
    }
}
```

3. If you are adding it from a plugin, add the following code to add your theme slug:

```php
add_filter( 'uds_survey_vars', function( $vars ){
    if( ! isset( $vars['_plugin_slug'] ) || empty( $vars['_plugin_slug'] ) ){
        $vars['_plugin_slug'] = ['cartflows'];
    } else {
        $vars['_plugin_slug'][] = 'cartflows';
    }
    return $vars;
} );
```

4. For a theme, you don't have to add anything. Just include the library files and HTML to display the popup.

## Usage

Once integrated, the plugin will prompt users with a survey when they deactivate your plugin.

## Changelog

### 1.0.0

-   Initial release of the Deactivation Survey Library.

## License

This plugin is licensed under the GPL v2 or later.
