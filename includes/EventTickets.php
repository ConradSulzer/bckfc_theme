<?php
namespace BCKFC\Theme;

final class EventTickets
{
    public const PURCHASE_INSTRUCTIONS = 'Each angler must purchase their own tickets for this event.';

    public static function registerHooks(): void
    {
        add_shortcode('bckfc_event_tickets', [self::class, 'renderEventTickets']);
    }

    public static function renderEventTickets(): string
    {
        // Tickets Plus is optional; do not print an unhandled shortcode without it.
        if (!shortcode_exists('tribe_tickets')) {
            return '';
        }

        // Apply presentation additions only while our native ticket picker renders.
        add_action('tribe_template_before_include:tickets/v2/tickets/title', [self::class, 'openTicketHeading']);
        add_action('tribe_template_after_include:tickets/v2/tickets/title', [self::class, 'renderTicketHeadingDetails']);

        try {
            $tickets = do_shortcode('[tribe_tickets]');
        } finally {
            remove_action('tribe_template_before_include:tickets/v2/tickets/title', [self::class, 'openTicketHeading']);
            remove_action('tribe_template_after_include:tickets/v2/tickets/title', [self::class, 'renderTicketHeadingDetails']);
        }

        if ($tickets === '' || is_user_logged_in() || !self::eventRequiresLogin()) {
            return $tickets;
        }

        $loginUrl = wp_login_url(get_permalink());
        ob_start();
        include dirname(__DIR__) . '/templates/ticket-login-prompt.php';

        return ob_get_clean();
    }

    private static function eventRequiresLogin(): bool
    {
        return class_exists(\BCKFC\Tools\Events\EventLoginRequirement::class)
            && \BCKFC\Tools\Events\EventLoginRequirement::requiresLogin((int) get_the_ID());
    }

    private static function renderPurchasedTicketsNotice(): string
    {
        $eventId = (int) get_the_ID();
        $data = \Tribe__Tickets__Tickets_View::instance()->get_my_tickets_link_data($eventId, get_current_user_id());

        if (!$data['total_count']) {
            return '';
        }

        $message = sprintf(
            _n('You have %d ticket.', 'You have %d tickets.', $data['total_count'], 'bckfc-theme'),
            $data['total_count'],
        );

        ob_start();
        include dirname(__DIR__) . '/templates/purchased-tickets-notice.php';

        return ob_get_clean();
    }

    public static function openTicketHeading(): void
    {
        echo '<div class="bckfc-ticket-intro bckfc-design"><div class="bckfc-ticket-heading">';
    }

    public static function renderTicketHeadingDetails(): void
    {
        $requiresLogin = self::eventRequiresLogin();
        $showPurchaseInstructions = is_user_logged_in() && $requiresLogin;
        $deadline = !$requiresLogin && shortcode_exists('bckfc_registration_closes')
            ? do_shortcode('[bckfc_registration_closes]')
            : '';

        include dirname(__DIR__) . '/templates/ticket-heading-details.php';
    }
}
