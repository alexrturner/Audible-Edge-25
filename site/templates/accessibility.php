<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section class="column a min-height" id="col1">
            <?= kt($page->intro()) ?>
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