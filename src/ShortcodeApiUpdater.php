<?php

namespace BetterCollective\WpPlugins\DynamicShortcodeAPI;

use BetterCollective\WpPlugins\DynamicShortcodeAPI\Traits\SingletonTrait;

/**
 * Class ShortcodeApiUpdater
 */
class ShortcodeApiUpdater
{
    use SingletonTrait;

    private function __construct()
    {
        $this->setupHooks();

        add_shortcode('dynamic_content', [$this, 'renderShortcode']);
        add_action('init', [$this, 'enqueueScript']);

    }

    private function setupHooks()
    {

        add_action('wp_ajax_update_shortcode_api_content', [$this, 'updateShortcodeApiContentCallback']);
        add_action('wp_ajax_nopriv_update_shortcode_api_content', [$this, 'updateShortcodeApiContentCallback']);

    }

    public function updateShortcodeApiContentCallback()
    {
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('Unauthorized', 401);
        }

        $postID = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
        $newContent = isset($_POST['new_content']) ? wp_kses_post($_POST['new_content']) : '';

        $this->updateShortcodeContent($postID, $newContent);

        wp_send_json_success('Content updated successfully');
    }

    private function updateShortcodeContent($postID, $newContent)
    {
        update_post_meta($postID, '_shortcode_api_content', $newContent);
    }

    public static function renderShortcode($attrs)
    {
        $postID = isset($attrs['post_id']) ? absint($attrs['post_id']) : get_the_ID();
        return get_post_meta($postID, '_shortcode_api_content', true);
    }

    public function enqueueScript()
    {
        wp_register_script(
            'shortcode-api-updater-script',
            BC_DYNAMIC_SHORCODE_API_URL . 'assets/script.min.js',
            [],
            BC_DYNAMIC_SHORCODE_API_VERSION,
            true
        );
        wp_enqueue_script('shortcode-api-updater-script');
    }
}
