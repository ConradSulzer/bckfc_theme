<?php
namespace BCKFC\Theme;

use BCKFC\Tools\Events\TournamentSettings;

final class EventTimesLocations
{
    public static function registerHooks(): void
    {
        add_shortcode('bckfc_times_locations', [self::class, 'renderTimesLocations']);
        add_action('fusion_builder_before_init', [self::class, 'registerBuilderElement']);
    }

    public static function registerBuilderElement(): void
    {
        fusion_builder_map([
            'name' => 'BCKFC Times and Locations',
            'shortcode' => 'bckfc_times_locations',
            'icon' => 'fusiona-clock',
            'params' => [
                [
                    'type' => 'textfield',
                    'heading' => 'Times Heading',
                    'param_name' => 'heading',
                    'value' => 'Tournament Times',
                ],
                [
                    'type' => 'iconpicker',
                    'heading' => 'Launch Location Icon',
                    'param_name' => 'launch_icon',
                    'value' => 'fa-map-marker-alt fas',
                ],
                [
                    'type' => 'iconpicker',
                    'heading' => 'Weigh-In / Awards Icon',
                    'param_name' => 'awards_icon',
                    'value' => 'fa-trophy fas',
                ],
                [
                    'type' => 'tinymce',
                    'heading' => 'Additional Details',
                    'param_name' => 'element_content',
                    'value' => '',
                    'description' => 'Optional content below the times and locations. Supports HTML and event shortcodes.',
                ],
            ],
        ]);
    }

    public static function renderTimesLocations($attributes, $content = ''): string
    {
        // The data belongs to Tools; the theme can also run without that plugin.
        if (!class_exists(TournamentSettings::class) || get_post_type() !== 'tribe_events') {
            return '';
        }

        $settings = shortcode_atts([
            'heading' => 'Tournament Times',
            'launch_icon' => 'fa-map-marker-alt fas',
            'awards_icon' => 'fa-trophy fas',
        ], $attributes);

        $eventId = (int) get_the_ID();
        $times = array_filter(TournamentSettings::getEventTimes($eventId), static fn($time) => $time !== '');
        $labels = TournamentSettings::getEventTimeLabels($eventId);
        $locations = array_filter(
            TournamentSettings::getEventLocations($eventId),
            static fn($location) => $location['name'] !== '' || $location['location'] !== '' || $location['address'] !== '',
        );
        $details = wpautop(wp_kses_post(do_shortcode(shortcode_unautop($content))));

        if (!$times && !$locations && $details === '') {
            return '';
        }

        ob_start();
        include dirname(__DIR__) . '/templates/event-times-locations.php';

        return ob_get_clean();
    }
}
