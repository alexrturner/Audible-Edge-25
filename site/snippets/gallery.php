<style>
    :root {
        --gallery-height: calc(50vh - 2em);
        --gallery-height: 50vh;
    }

    .gallery-container {
        position: relative;
    }

    .gallery-images figure {
        display: none;
        text-align: center;
        align-items: start;
        margin: 0 auto;
        justify-content: start;
        /* justify-content: center; */

    }

    .gallery-images figure.active {
        display: block;
    }

    button.gallery-prev,
    button.gallery-next {
        position: absolute;
        top: 50%;
        transform: translateY(calc(-50% - 1em));
    }

    button.gallery-prev {
        left: 0.5rem;
        /* left: 0; */
        height: 2rem;
    }

    button.gallery-next {
        /* right: 0.5rem; */
        /* right: 0; */
        left: 2rem;
        height: 2rem;
    }

    .gallery-images figure img {
        max-height: var(--gallery-height);


        max-height: calc(100vh - 13em);

        /* height: auto; */

        width: 100%;
        max-height: calc(100vh - 14em);
        object-fit: cover;
        max-height: 50vh;
    }

    @media screen and (max-width: 768px) {
        .gallery-images figure img {
            max-height: 100%;
        }

        .gallery-images figure {
            height: auto;
        }
    }

    button.gallery-prev,
    button.gallery-next {
        top: 0%;
        /* transform: translateY(calc(50% + 0.5em)); */
        /* transform: translateY(calc(-100% - 0.5em)); */
        transform: translateY(calc(50% - 0.5em));


    }

    .gallery-count {
        text-align: end;
        padding: 0.5em 1em;
        pointer-events: none;
    }

    /* hhhhhhhmmmmmm */

    .gallery-count {
        /* position: absolute; */
        /* top: 0%; */
        /* transform: translateY(calc(50% - 0.5em)); */
    }
</style>

<?php if ($images->isNotEmpty()) : ?>
    <div class="gallery-container" aria-label="Image Gallery">

        <div class="gallery-images">
            <?php foreach ($images as $index => $image) : ?>
                <figure class="<?= $index === 0 ? 'active' : '' ?>">
                    <img style="max-width: 100%;" src="<?= $image->resize(500)->url() ?>" alt="<?= $image->alt()->or($page->title() . ' image') ?>" loading="lazy">
                    <figcaption><?= $image->caption()->or('') ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <?php
        $count = $images->count();
        if ($count > 1) : ?>
            <button aria-label="Previous Image" class="gallery-prev">←</button>
            <button aria-label="Next Image" class="gallery-next">→</button>
            <div class="gallery-count" aria-live="polite">
                <span class="current">1</span><span class="total"> / <?= $count ?></span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>