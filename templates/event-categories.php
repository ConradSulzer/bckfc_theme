<section class="bckfc-design bckfc-categories">
    <?php if ($settings['heading'] !== ''): ?>
        <h2 class="bckfc-section-heading"><?php echo esc_html($settings['heading']); ?></h2>
    <?php endif; ?>

    <table class="bckfc-categories__table" role="table">
        <thead role="rowgroup">
            <tr role="row">
                <th scope="col" class="bckfc-label" role="columnheader">Category</th>
                <th scope="col" class="bckfc-label" role="columnheader">Details</th>
                <th scope="col" class="bckfc-label" role="columnheader">Payout / Prize</th>
            </tr>
        </thead>
        <tbody role="rowgroup"><?php echo $rows; ?></tbody>
    </table>

    <?php if ($sizeLimits): ?>
        <div class="bckfc-categories__footer bckfc-supporting-text">
            <?php foreach ($sizeLimits as $index => $limit): ?>
                <?php
                $requirements = [];

                foreach (['minimum' => 'Min: ', 'maximum' => 'Max: '] as $field => $label) {
                    if ($limit[$field] !== '') {
                        $requirements[] = $label . $limit[$field];
                    }
                }
                ?>
                <?php if ($index > 0): ?>
                    <span class="bckfc-categories__separator" aria-hidden="true">·</span>
                <?php endif; ?>
                <span><strong><?php echo esc_html($limit['species']); ?>:</strong> <?php echo esc_html(implode('; ', $requirements)); ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($footer !== ''): ?>
        <div class="bckfc-categories__footer bckfc-prose"><?php echo $footer; ?></div>
    <?php endif; ?>
</section>
