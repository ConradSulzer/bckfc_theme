<?php use BCKFC\Tools\Events\TournamentSettings; ?>
<section class="bckfc-times-locations">
    <?php if ($times || $locations): ?>
        <div class="bckfc-times-locations__overview">
            <?php if ($times): ?>
                <div class="bckfc-times-locations__schedule">
                    <?php if ($settings['heading'] !== ''): ?>
                        <h2 class="bckfc-section-heading"><?php echo esc_html($settings['heading']); ?></h2>
                    <?php endif; ?>
                    <ol class="bckfc-times-locations__times">
                        <?php foreach ($times as $key => $time): ?>
                            <li>
                                <?php if ($time === 'tbd'): ?>
                                    <strong>TBD</strong>
                                <?php else: ?>
                                    <time datetime="<?php echo esc_attr($time); ?>"><?php echo esc_html(DateTimeImmutable::createFromFormat('!H:i', $time)->format('g:i A')); ?></time>
                                <?php endif; ?>
                                <span><?php echo esc_html($labels[$key] ?: TournamentSettings::TIME_FIELDS[$key]); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            <?php endif; ?>

            <?php foreach ($locations as $key => $location): ?>
                <?php
                $title = implode(' · ', array_filter([$location['name'], $location['location']]));
                $icon = fusion_font_awesome_name_handler($settings[$key === 'fishing' ? 'launch_icon' : 'awards_icon']);
                ?>
                <div class="bckfc-times-locations__location">
                    <h2 class="bckfc-section-heading"><?php echo $key === 'fishing' ? 'Launch Location' : 'Weigh-In / Awards'; ?></h2>
                    <?php if ($icon !== ''): ?>
                        <i class="bckfc-times-locations__icon <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                    <?php endif; ?>
                    <?php if ($title !== ''): ?>
                        <p class="bckfc-location-name"><?php echo esc_html($title); ?></p>
                    <?php endif; ?>
                    <?php if ($location['address'] !== ''): ?>
                        <p class="bckfc-supporting-text"><?php echo esc_html($location['address']); ?></p>
                        <a class="bckfc-link" href="<?php echo esc_url('https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($location['address'])); ?>">Get Directions</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($details !== ''): ?>
        <div class="bckfc-times-locations__details bckfc-prose"><?php echo $details; ?></div>
    <?php endif; ?>
</section>
