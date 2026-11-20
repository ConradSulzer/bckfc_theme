<?php defined('ABSPATH') || exit(); ?>
<header class="bckfc-design bckfc-surface--ink bckfc-header">
    <?php if ($backgroundUrl !== ''): ?>
        <div class="bckfc-header__background" aria-hidden="true">
            <img src="<?= $backgroundUrl ?>" alt="" />
        </div>
    <?php endif; ?>
    <div class="bckfc-header__inner<?= $imageUrl !== '' ? ' bckfc-header__inner--with-image' : '' ?>">
        <div class="bckfc-header__content">
            <?php if (trim($header['alert']) !== ''): ?>
                <div class="bckfc-header__alert">
                    <?php include $icons . 'triangle-alert.svg'; ?>
                    <span><?= esc_html($header['alert']) ?></span>
                </div>
            <?php endif; ?>
            <div class="bckfc-header__heading">
                <?php if (trim($header['eyebrow']) !== ''): ?>
                    <p class="bckfc-label bckfc-accent"><?= esc_html($header['eyebrow']) ?></p>
                <?php endif; ?>
                <h1 class="bckfc-title"><?= esc_html($titleStart) ?> <span class="bckfc-accent"><?= esc_html($titleAccent) ?></span></h1>
            </div>
            <?php if ($date !== '' || $location !== ''): ?>
                <div class="bckfc-header__facts">
                    <?php if ($date !== ''): ?>
                        <span><?php include $icons . 'calendar-days.svg'; ?><span><?= $date ?></span></span>
                    <?php endif; ?>
                    <?php if ($location !== ''): ?>
                        <span><?php include $icons . 'map-pin.svg'; ?><span><?= $location ?></span></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (trim($header['intro']) !== ''): ?>
                <p class="bckfc-lead bckfc-header__intro"><?= nl2br(esc_html($header['intro'])) ?></p>
            <?php endif; ?>
            <?php if ($header['coming_soon'] === '1'): ?>
                <p class="bckfc-header__status">Registration Coming Soon</p>
            <?php elseif ($showPrimary || $showSecondary): ?>
                <div class="bckfc-header__actions">
                    <?php if ($showPrimary): ?>
                        <a class="bckfc-button" href="<?= $primaryUrl ?>">
                            <span><?= esc_html($header['primary_label']) ?></span>
                            <?php include $icons . 'arrow-right.svg'; ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($showSecondary): ?>
                        <a class="bckfc-button bckfc-button--outline bckfc-button--inverse" href="<?= $secondaryUrl ?>"><?= esc_html($header['secondary_label']) ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($imageUrl !== ''): ?>
            <div class="bckfc-header__art">
                <img src="<?= $imageUrl ?>" alt="" />
            </div>
        <?php endif; ?>
    </div>
</header>
