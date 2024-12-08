<?php snippet('header') ?>

<main class="content-container index">

    <section id="col1" class="description">
        <div>
            <?= kt($page->description()) ?>
        </div>
    </section>

    <section id="col2" class="logos-container">
        <?php
        // display full logos after Program Launch
        date_default_timezone_set('Australia/Perth');
        $currentDate = new DateTime();
        $cutoffDate = new DateTime('2024-03-12');

        if ($currentDate < $cutoffDate) : ?>
            <div class="logos logos-small">
                <?php foreach ($page->smallLogos_partial()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>

            <div class="logos logos-medium">
                <?php foreach ($page->mediumLogos_partial()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>

            <div class="logos logos-large">
                <?php foreach ($page->largeLogos_partial()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="logos logos-small">
                <?php foreach ($page->smallLogos()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>

            <div class="logos logos-medium">
                <?php foreach ($page->mediumLogos()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>

            <div class="logos logos-large">
                <?php foreach ($page->largeLogos()->toFiles() as $logo) : ?>
                    <img style="max-width: 100%;" src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </section>
    </div>
</main>

<?php snippet('footer') ?>