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
        add_action( 'rest_api_init', [$this, 'registerRestRoute'] );
        add_shortcode( 'dynamic_content', [$this, 'renderShortcode'] );
    }

    public function registerRestRoute()
    {
        register_rest_route('shortcode-api/v1', '/update/(?P<post_id>\d+)', [
            'methods' => 'POST',
            'callback' => [$this, 'shortcodeApiUpdate'],
            'args' => [
                'post_id' => [
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric($param);
                    }
                ],
            ],
        ]);
    }

    public function shortcodeApiUpdate($request)
    {
        $post_id = $request->get_param('post_id');
        $new_title = $request->get_param('new_title');
        $new_content = $request->get_param('new_content');
        $new_content = str_replace('n\\', '<br>', $new_content);

        if ($new_title && $new_content) {
            update_post_meta($post_id, '_shortcode_api_title', sanitize_text_field($new_title));
            update_post_meta($post_id, '_shortcode_api_content', wp_kses_post($new_content));
            return new \WP_REST_Response(['message' => 'Title and content updated successfully'], 200);
        } elseif ($new_title) {
            update_post_meta($post_id, '_shortcode_api_title', sanitize_text_field($new_title));
            return new \WP_REST_Response(['message' => 'Title updated successfully'], 200);
        } elseif ($new_content) {
            update_post_meta($post_id, '_shortcode_api_content', wp_kses_post($new_content));
            return new \WP_REST_Response(['message' => 'Content updated successfully'], 200);
        } else {
            return new \WP_REST_Response(['message' => 'No updates provided'], 400);
        }
    }


    public static function renderShortcode()
    {
        global $post;

        $title = get_post_meta($post->ID, '_shortcode_api_title', true);
        $content = get_post_meta($post->ID, '_shortcode_api_content', true);

        $output = '';

        if ($title) {
            $output .= '<h2>' . __($title) . '</h2>';
        }

        if ($content) {
            $output .= '<p>' . __($content) . '</p>';
        }

        return '<div id="dynamic-content">' . $output . '</div>';
    }

}
