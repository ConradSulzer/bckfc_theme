<?php echo self::renderPurchasedTicketsNotice(); ?>
</div>
<?php if ($showPurchaseInstructions): ?>
    <p class="bckfc-ticket-purchase-instructions bckfc-supporting-text"><?php echo esc_html(self::PURCHASE_INSTRUCTIONS); ?></p>
<?php elseif ($deadline !== ''): ?>
    <p class="bckfc-registration-deadline bckfc-supporting-text">
        <?php include dirname(__DIR__) . '/assets/icons/clock.svg'; ?>
        <span>Registration closes <?php echo wp_kses_post($deadline); ?></span>
    </p>
<?php endif; ?>
</div>
