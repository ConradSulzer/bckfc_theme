<?php
namespace BCKFC\Theme;

final class EventHeader
{
    public static function registerHooks(): void
    {
        add_shortcode('bckfc_event_header', [self::class, 'renderHeader']);
        add_action('fusion_builder_before_init', [self::class, 'registerBuilderElement']);
    }

    public static function registerBuilderElement(): void
    {
        fusion_builder_map([
            'name' => 'BCKFC Header',
            'shortcode' => 'bckfc_event_header',
            'icon' => 'fusiona-image',
            'params' => [
                [
                    'type' => 'textfield',
                    'heading' => 'Title',
                    'param_name' => 'title',
                    'value' => '',
                    'description' => 'Leave blank to use the event title.',
                ],
                [
                    'type' => 'textfield',
                    'heading' => 'Eyebrow',
                    'param_name' => 'eyebrow',
                    'value' => '',
                ],
                [
                    'type' => 'textarea',
                    'heading' => 'Introduction',
                    'param_name' => 'intro',
                    'value' => '',
                ],
                [
                    'type' => 'textarea',
                    'heading' => 'Alert Message',
                    'param_name' => 'alert',
                    'value' => '',
                ],
                [
                    'type' => 'upload',
                    'heading' => 'Featured Image',
                    'param_name' => 'image',
                    'value' => '',
                ],
                [
                    'type' => 'upload',
                    'heading' => 'Background Image',
                    'param_name' => 'background',
                    'value' => '',
                ],
                [
                    'type' => 'radio_button_set',
                    'heading' => 'Registration Coming Soon',
                    'param_name' => 'coming_soon',
                    'default' => '0',
                    'value' => ['0' => 'No', '1' => 'Yes'],
                    'description' => 'Show a coming-soon message instead of the buttons. Does not change ticket availability.',
                ],
                [
                    'type' => 'textfield',
                    'heading' => 'Primary Button Text',
                    'param_name' => 'primary_label',
                    'value' => 'Register',
                ],
                [
                    'type' => 'link_selector',
                    'heading' => 'Primary Button Link',
                    'param_name' => 'primary_url',
                    'value' => '',
                    'description' => 'Use a URL or section anchor, such as #bckfc-tickets. Leave blank to hide this button.',
                ],
                [
                    'type' => 'textfield',
                    'heading' => 'Secondary Button Text',
                    'param_name' => 'secondary_label',
                    'value' => '',
                ],
                [
                    'type' => 'link_selector',
                    'heading' => 'Secondary Button Link',
                    'param_name' => 'secondary_url',
                    'value' => '',
                    'description' => 'Optional. Both text and a link are needed to show this button.',
                ],
            ],
        ]);
    }

    public static function renderHeader($attributes): string
    {
        $header = shortcode_atts([
            'title' => '',
            'eyebrow' => '',
            'intro' => '',
            'alert' => '',
            'image' => '',
            'background' => '',
            'coming_soon' => '0',
            'primary_label' => 'Register',
            'primary_url' => '',
            'secondary_label' => '',
            'secondary_url' => '',
        ], $attributes);

        $title = trim($header['title']) ?: get_the_title();
        $titleWords = preg_split('/\s+/u', trim($title), -1, PREG_SPLIT_NO_EMPTY);
        $titleAccent = array_pop($titleWords) ?? '';
        $titleStart = implode(' ', $titleWords);
        $date = '';
        $location = '';

        // Tools is optional: omit unavailable event facts, including their icons.
        if (get_post_type() === 'tribe_events') {
            if (shortcode_exists('bckfc_event_date') && get_post_meta(get_the_ID(), '_EventStartDate', true)) {
                $date = do_shortcode('[bckfc_event_date]');
            }

            if (shortcode_exists('bckfc_event_location')) {
                $location = do_shortcode('[bckfc_event_location type="fishing"]');
            }
        }

        $primaryUrl = esc_url($header['primary_url']);
        $secondaryUrl = esc_url($header['secondary_url']);
        $imageUrl = esc_url($header['image']);
        $backgroundUrl = esc_url($header['background']);
        $showPrimary = $primaryUrl !== '' && trim($header['primary_label']) !== '';
        $showSecondary = $secondaryUrl !== '' && trim($header['secondary_label']) !== '';
        $icons = dirname(__DIR__) . '/assets/icons/';

        ob_start();
        include dirname(__DIR__) . '/templates/event-header.php';

        return ob_get_clean();
    }
}
