<?php snippet('header') ?>
<?php $swamps = $site->files()->filterBy('template', 'ae_swamp_svg'); ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">

        <section id="col1" class="column a min-height">
            <div class="content">
                <h1 class="section-title lighten"><?= $page->title() ?></h1>
            </div>





            <div class="icon__swamp" id="icon-hue">
                <?= svg($swamps->filterBy('position', 'left')->first()) ?>
            </div>
        </section>




        <section id="col2" class="column b description">

            <div>
                <?= kt($page->description()) ?>
            </div>

            <div class="logos">
                <?php
                $logos = kirby()->page('acknowledgements')->smalllogos()->toFiles();
                if ($logos->count() > 0): ?>
                    <?php foreach ($logos as $logo): ?>
                        <div class="logo" role="img" aria-label="<?= $logo->alt() ?>">

                            <?= $logo->read() ?>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="icon__swamp" id="icon-saturation">
                <?=
                svg($swamps->filterBy('position', 'middle')->first())
                ?>
            </div>
        </section>



        </section>
    </main>
</div>

<?php snippet('footer') ?>