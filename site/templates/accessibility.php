<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section class="column a min-height" id="col1">
            <div class="content">
                <?php if ($page->page_title()->isNotEmpty()) : ?>
                    <h1 class="section-title lighten"><?= $page->page_title() ?></h1>
                <?php else : ?>
                    <h1 class="section-title lighten"><?= $page->title() ?></h1>
                <?php endif ?>
                <?= kt($page->intro()) ?>
            </div>
        </section>
        <section id="col2" class="column b min-height">
            <div class="content lighten">
                <?= kt($page->description()) ?>
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