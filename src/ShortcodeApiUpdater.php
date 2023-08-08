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

        add_action('wp_ajax_update_shortcode_api_content', [$this, 'updateShortcodeApiContentCallback']);
        add_action('wp_ajax_nopriv_update_shortcode_api_content', [$this, 'updateShortcodeApiContentCallback']);
        add_shortcode('dynamic_content', [$this, 'renderShortcode']);

    }

    public function updateShortcodeApiContentCallback()
    {
        $postID = isset($_GET['post_id']) ? absint($_GET['post_id']) : 0;
        $newContent = isset($_GET['new_content']) ? wp_kses_post($_GET['new_content']) : '';

        $postContent = get_post_field('post_content', $postID);
        if (str_contains($postContent, '[dynamic_content post_id="' . $postID . '"]')) {
            $this->updateShortcodeContent($postID, $newContent);
            wp_send_json_success('Content updated successfully');
        } else {
            wp_send_json_error('The post does not contain the [dynamic_content] block with the specified post_id.');
        }
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

}
