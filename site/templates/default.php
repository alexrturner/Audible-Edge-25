<?php snippet('header') ?>
<?php

$swamps = $site->files()->filterBy('template', 'ae_swamp_svg');
$hasImages = $page->images()->count() > 0;
?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section id="col1" class="column a min-height">
            <div>
                <?php if ($page->link()->isNotEmpty()): ?>
                    <a href="<?= $page->link() ?>" class="button__link" aria-label="Visit <?= $page->title() ?> website" aria-type="link">
                        <h1 class="section-title lighten"><?= $page->link_text() ?> ↗</h1>
                    </a>
                <?php else: ?>
                    <h1 class="section-title lighten"><?= $page->title() ?></h1>
                <?php endif ?>
            </div>

            <div class="icon__swamp" id="icon-hue">
                <?= svg($swamps->filterBy('position', 'left')->first()) ?>
            </div>
        </section>

        <section id="col2" class="column b description <?= $hasImages ? 'span2' : '' ?>">
            <div class="content lighten">
                <?= kt($page->description()) ?>
            </div>
            <div class="icon__swamp" id="icon-saturation">
                <?=
                svg($swamps->filterBy('position', 'middle')->first())
                ?>
            </div>
        </section>

        <?php if ($hasImages): ?>
            <section id="col3" class="column c">

                <?php snippet('gallery', ['images' => $page->images()]); ?>

                <div class="icon__swamp" id="icon-color">
                    <?=
                    svg($swamps->filterBy('position', 'right')->first())
                    ?>
                </div>
            </section>
        <?php endif ?>

    </main>
</div>
<?= js('assets/js/gallery.js') ?>

<?php snippet('footer') ?>