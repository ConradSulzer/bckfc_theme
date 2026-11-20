<?php
namespace BCKFC\Theme;

final class EventHighlights
{
    public static function registerHooks(): void
    {
        add_shortcode('bckfc_highlights', [self::class, 'renderHighlights']);
        add_shortcode('bckfc_highlight', [self::class, 'renderHighlight']);
        add_action('fusion_builder_before_init', [self::class, 'registerBuilderElements']);
    }

    public static function registerBuilderElements(): void
    {
        fusion_builder_map([
            'name' => 'BCKFC Highlights',
            'shortcode' => 'bckfc_highlights',
            'icon' => 'fusiona-list-ul',
            'multi' => 'multi_element_parent',
            'element_child' => 'bckfc_highlight',
            'child_ui' => true,
            'params' => [
                [
                    'type' => 'tinymce',
                    'heading' => 'Highlights',
                    'param_name' => 'element_content',
                    'value' => '[bckfc_highlight label=""][/bckfc_highlight]',
                    'description' => 'Designed for one to four highlights. Drag items to change their order.',
                ],
            ],
        ]);

        fusion_builder_map([
            'name' => 'Highlight',
            'shortcode' => 'bckfc_highlight',
            'hide_from_builder' => true,
            'allow_generator' => true,
            'params' => [
                [
                    'type' => 'textarea',
                    'heading' => 'Value',
                    'param_name' => 'element_content',
                    'value' => '',
                    'description' => 'Enter text or an event shortcode, such as [bckfc_registration_closes].',
                ],
                [
                    'type' => 'textfield',
                    'heading' => 'Subtext',
                    'param_name' => 'label',
                    'value' => '',
                ],
                [
                    'type' => 'link_selector',
                    'heading' => 'Link',
                    'param_name' => 'link',
                    'value' => '',
                    'description' => 'Optional. Use a URL or a section anchor such as #rules.',
                ],
                [
                    'type' => 'iconpicker',
                    'heading' => 'Icon',
                    'param_name' => 'icon',
                    'value' => '',
                ],
            ],
        ]);
    }

    public static function renderHighlights($attributes, $content = ''): string
    {
        $items = do_shortcode(shortcode_unautop($content));

        return '<div class="bckfc-design bckfc-highlights" role="list">' . $items . '</div>';
    }

    public static function renderHighlight($attributes, $content = ''): string
    {
        $item = shortcode_atts(['label' => '', 'link' => '', 'icon' => ''], $attributes);
        $value = trim(wp_strip_all_tags(do_shortcode($content)));

        if ($value === '') {
            return '';
        }

        $icon = fusion_font_awesome_name_handler($item['icon']);
        $link = esc_url($item['link']);

        ob_start();
        include dirname(__DIR__) . '/templates/event-highlight.php';

        return ob_get_clean();
    }
}
