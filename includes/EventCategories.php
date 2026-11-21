<?php
namespace BCKFC\Theme;

final class EventCategories
{
    public static function registerHooks(): void
    {
        add_shortcode('bckfc_categories', [self::class, 'renderCategories']);
        add_shortcode('bckfc_category', [self::class, 'renderCategoryRow']);
        add_action('fusion_builder_before_init', [self::class, 'registerBuilderElements']);
    }

    public static function registerBuilderElements(): void
    {
        fusion_builder_map([
            'name' => 'BCKFC Categories',
            'shortcode' => 'bckfc_categories',
            'icon' => 'fusiona-table',
            'multi' => 'multi_element_parent',
            'element_child' => 'bckfc_category',
            'child_ui' => true,
            'params' => [
                [
                    'type' => 'textfield',
                    'heading' => 'Heading',
                    'param_name' => 'heading',
                    'value' => 'Categories',
                ],
                [
                    'type' => 'tinymce',
                    'heading' => 'Categories',
                    'param_name' => 'element_content',
                    'value' => '[bckfc_category title="Category Name"][/bckfc_category]',
                ],
                [
                    'type' => 'textarea',
                    'heading' => 'Footer',
                    'param_name' => 'footer',
                    'value' => '',
                    'description' => 'Optional. Supports HTML, line breaks and event shortcodes.',
                ],
            ],
        ]);

        fusion_builder_map([
            'name' => 'Category',
            'shortcode' => 'bckfc_category',
            'hide_from_builder' => true,
            'allow_generator' => true,
            'params' => [
                [
                    'type' => 'textfield',
                    'heading' => 'Category Name',
                    'param_name' => 'title',
                    'value' => '',
                ],
                [
                    'type' => 'textarea',
                    'heading' => 'Description',
                    'param_name' => 'element_content',
                    'value' => '',
                ],
                [
                    'type' => 'textfield',
                    'heading' => 'Payout / Prize',
                    'param_name' => 'prize',
                    'value' => '',
                ],
            ],
        ]);
    }

    public static function renderCategories($attributes, $content = ''): string
    {
        $settings = shortcode_atts(['heading' => 'Categories', 'footer' => ''], $attributes);
        $rows = do_shortcode(shortcode_unautop($content));
        $footer = wpautop(wp_kses_post(do_shortcode($settings['footer'])));
        $sizeLimits = class_exists(\BCKFC\Tools\Events\TournamentSettings::class)
            ? \BCKFC\Tools\Events\TournamentSettings::getEventSizeLimits((int) get_the_ID())
            : [];

        ob_start();
        include dirname(__DIR__) . '/templates/event-categories.php';

        return ob_get_clean();
    }

    public static function renderCategoryRow($attributes, $content = ''): string
    {
        $category = shortcode_atts(['title' => '', 'prize' => ''], $attributes);
        $description = wpautop(wp_kses_post(do_shortcode($content)));

        ob_start();
        include dirname(__DIR__) . '/templates/event-category.php';

        return ob_get_clean();
    }
}
