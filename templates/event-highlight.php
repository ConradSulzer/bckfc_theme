<?php defined('ABSPATH') || exit(); ?>
<div class="bckfc-highlight" role="listitem">
    <?php if ($icon !== ''): ?>
        <i class="bckfc-highlight__icon <?= esc_attr($icon) ?>" aria-hidden="true"></i>
    <?php endif; ?>
    <?php if ($link !== ''): ?>
        <a class="bckfc-highlight__value bckfc-item-heading" href="<?= $link ?>"><?= esc_html($value) ?></a>
    <?php else: ?>
        <span class="bckfc-highlight__value bckfc-item-heading"><?= esc_html($value) ?></span>
    <?php endif; ?>
    <span class="bckfc-label"><?= esc_html($item['label']) ?></span>
</div>
