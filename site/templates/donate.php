<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section class="column a" id="col1">
            <div class="donate">
                <a class="button__link" aria-label="Visit Audible Edge 2025 ACF fundraiser website" aria-type="link" href="<?= $page->link()->url() ?>">
                    <h1 class="section-title lighten"><?= $page->link_text() ?> ↗</h1>
                </a>

            </div>
        </section>
        <section id="col2" class="column b">
            <div class="content lighten">
                <?= $page->description() ?>
            </div>
            <?php
            $swamps = $site->files()->filterBy('template', 'ae_swamp_svg');
            ?>
            <div class="icon__swamp" id="icon-color">
                <?=
                svg($swamps->filterBy('position', 'right')->first())
                ?>
            </div>
        </section>
    </main>
</div>

<?php snippet('footer') ?>