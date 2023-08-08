<?php
/**
 * Plugin Name: BC Plugin Dynamic Shortcode API
 * Description: Dynamic Shortcode API.
 * Version:     1.0.0
 * Author:      Better Collective G/S
 */

if (!defined('ABSPATH')) {
    die;
}

use BetterCollective\WpPlugins\DynamicShortcodeAPI\ShortcodeApiUpdater;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';

    if (class_exists('BetterCollective\WpPlugins\DynamicShortcodeAPI\ShortcodeApiUpdater')) {
        define('BC_DYNAMIC_SHORCODE_API_VERSION', '1.0.0');
        define('BC_DYNAMIC_SHORCODE_API_DIR', __DIR__);
        define('BC_DYNAMIC_SHORCODE_API_URL', plugin_dir_url(__FILE__));
        define('BC_DYNAMIC_SHORCODE_API_FILE', __FILE__);

        ShortcodeApiUpdater::getInstance();
    } else {
        error_log('BC Plugin Dynamic Shortcode API: Required class not found.');
    }
} else {
    error_log('BC Plugin Dynamic Shortcode API: Autoload file not found. Run composer install to generate it.');
}

