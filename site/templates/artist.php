<?php snippet('header') ?>

<?php
$swamps = $site->files()->filterBy('template', 'ae_swamp_svg');
?>


<div class="container">
    <?php snippet('nav') ?>

    <main class="content-container">

        <!-- associsated event -->
        <section class="section column a" id="col1">
            <ul class="artists" id="events-items">
                <!-- <span class="mobile__section-subtitle">Artist:</span> -->

                <li class="artists-item" data-type="artists" data-id="<?= $page->id() ?>">
                    <h1 class="section-title lighten">
                        <?= $page->title()->html() ?>
                    </h1>
                </li>
            </ul>

            <div class="row content">
                <?php if ($page->bio_short()->isNotEmpty()) : ?>
                    <div class="bio-short lighten">
                        <?= kt($page->bio_short()) ?>
                    </div>
                <?php endif; ?>

                <?php
                $events = $page->events()->toPages();

                if ($events->isNotEmpty()) : ?>
                    <div class="col-2">
                        <h2 class="section-header prefix sml">playing at</h2>
                        <ul class="associated-events">

                            <?php foreach ($events as $event) : ?>

                                <li class="lighten">
                                    <a href="<?= $event->url() ?>">
                                        <?= $event->title()->html() ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($page->support()->isNotEmpty()) : ?>
                    <div class="col-2">
                        <h2 class="section-header prefix sml">supported by</h2>
                        <p class="lighten"> <?= html($page->support()) ?></p>
                    </div>
                <?php endif; ?>

                <?php
                // fetch audio
                $sounds = $page->files()->template('audio');
                $counter = 0;
                if ($sounds->isNotEmpty()) : ?>
                    <div class="artist-sounds">
                        <?php foreach ($sounds as $sound) : ?>
                            <audio id="audioSample<?= $counter ?>" class="audio-sample" controls aria-labelledby="playAudioButtonLabel<?= $counter ?>">
                                <source src="<?= $sound->url() ?>" type="<?= $sound->mime() ?>">
                                Your browser does not support the audio element.
                            </audio>
                            <button id="playAudioButton<?= $counter ?>" class="circle-button play-audio-button" aria-label="Play <?= $page->title()->html() ?> audio sample <?= $counter ?>"></button>
                            <span id="playAudioButtonLabel<?= $counter ?>" hidden>Play audio sample <?= $counter ?></span>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="icon__swamp" id="icon-hue">
                <?= svg($swamps->filterBy('position', 'left')->first()) ?>
            </div>



        </section>

        <!-- artists, images -->
        <section class="section column b" id="col2">
            <!-- <div class="space"></div> -->
            <div class="bio-container">

                <?php if ($page->bio_long()->isNotEmpty()) : ?>
                    <!-- <button id="toggleBio" class="toggle-bio-btn">+</button> -->
                    <div class="lighten">
                        <?= $page->bio_long()->kt() ?>
                    </div>
                <?php endif; ?>

                <?php $links = $page->links()->toStructure(); ?>
                <?php if ($links->isNotEmpty()) : ?>
                    <ul class="artist-links">
                        <?php foreach ($links as $link) : ?>
                            <li class="lighten">
                                <a class="serif italic" href="<?= $link->url() ?>" <?= $link->popup()->toBool() ? 'target="_blank"' : '' ?>>
                                    <?= $link->text()->html() ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>




            <?php if ($page->credits()->count()->toArray() > 0) : ?>
                <?php if ($credits = $page->credits()->toStructure()) : ?>
                    <ul class="credits">
                        <?php foreach ($credits as $credit) : ?>
                            <li>
                                <?php if ($credit->other_name()->isNotEmpty()) : ?><?= $credit->other_name()->html() ?><?php endif; ?>&nbsp;<?php if ($credit->sort_name()->isNotEmpty()) : ?><?= $credit->sort_name()->html() ?><?php endif; ?><?php if ($credit->group()->isNotEmpty()) : ?>&nbsp;(<?= $credit->group()->html() ?>)<?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>

            <div class="icon__swamp" id="icon-saturation" style="rotate: 20deg;">
                <?=
                svg($swamps->filterBy('position', 'middle')->first())
                ?>
            </div>

        </section>

        <!-- description and links -->
        <section class="section column c" id="col3">
            <?php snippet('gallery', ['images' => $page->images()]); ?>



            <div class="icon__swamp" id="icon-color">
                <?=
                svg($swamps->filterBy('position', 'right')->first())
                ?>
            </div>
        </section>


    </main>
</div>

<?= js([
    'assets/js/gallery.js'
]) ?>

<?php snippet('footer') ?>