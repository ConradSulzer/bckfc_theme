<?php
namespace BCKFC\Theme;

defined('ABSPATH') || exit();

require_once __DIR__ . '/includes/EventHeader.php';
EventHeader::registerHooks();

require_once __DIR__ . '/includes/EventTickets.php';
EventTickets::registerHooks();

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueueDesignStyles', 20);

function enqueueDesignStyles(): void
{
    wp_enqueue_style(
        'bckfc-fonts',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap',
        [],
        null,
    );

    $dependency = 'bckfc-fonts';

    foreach (['tokens', 'foundations', 'buttons', 'event-header', 'event-tickets'] as $name) {
        $path = '/assets/css/' . $name . '.css';
        $handle = 'bckfc-' . $name;

        wp_enqueue_style(
            $handle,
            get_stylesheet_directory_uri() . $path,
            [$dependency],
            (string) filemtime(get_stylesheet_directory() . $path),
        );

        $dependency = $handle;
    }
}
