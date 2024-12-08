<?php snippet('header') ?>

<main class="content-container">

    <!-- associsated event -->
    <section class="section" id="col1">
        <?php
        $events = $page->events()->toPages();

        if ($events->isNotEmpty()) : ?>

            <ul class="associated-events">

                <?php if ($events->count() > 1) : ?>
                    <span class="mobile__section-subtitle">Associated Events:</span>
                <?php else : ?>
                    <span class="mobile__section-subtitle">Associated Event:</span>
                <?php endif; ?>
                <?php foreach ($events as $event) : ?>

                    <li>
                        <a href="<?= $event->url() ?>">
                            <?= $event->title()->html() ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
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
    </section>

    <!-- artists, images -->
    <section class="section" id="col2">
        <ul class="artists" id="events-items">
            <span class="mobile__section-subtitle">Artist:</span>

            <li class="artists-item" data-type="artists" data-id="<?= $page->id() ?>">
                <h2 class="section-title">
                    <?= $page->title()->html() ?>
                </h2>
            </li>
        </ul>

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

        <?php snippet('gallery', ['images' => $page->images()]); ?>

    </section>

    <!-- description and links -->
    <section class="section" id="col3">

        <div class="bio-container">
            <?php if ($page->bio_short()->isNotEmpty()) : ?>
                <div class="bio-short">
                    <?= kt($page->bio_short()) ?>
                </div>
            <?php endif; ?>
            <?php if ($page->bio_long()->isNotEmpty()) : ?>
                <button id="toggleBio" class="toggle-bio-btn">+</button>
                <div id="bioLong" class="bio-long" style="visibility:hidden;">
                    <?= $page->bio_long()->kt() ?>
                </div>
            <?php endif; ?>
        </div>

        <?php $links = $page->links()->toStructure(); ?>
        <?php if ($links->isNotEmpty()) : ?>
            <ul class="artist-links">
                <?php foreach ($links as $link) : ?>
                    <li>
                        [
                        <a class="serif italic" href="<?= $link->url() ?>" <?= $link->popup()->toBool() ? 'target="_blank"' : '' ?>>

                            <?= $link->text()->html() ?>
                            <?php
                            // construct the SVG file path based on the link type
                            $type = $link->type()->value();
                            $svgFilePath = 'assets/imgs/icons/' . $type . '.svg';

                            if (file_exists($svgFilePath)) {
                                svg($svgFilePath);
                            } else {
                                // fallback text
                                echo htmlspecialchars($type);
                            }
                            ?></a> ]
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($page->support()->isNotEmpty()) : ?>
            <p class="support"><span>Supported by: </span><?= html($page->support()) ?></p>
        <?php endif; ?>
    </section>


</main>

<?= js([
    'assets/js/gallery.js'
]) ?>

<?php snippet('footer') ?>