<style>
    :root {
        --gallery-height: 33vh;
    }

    .gallery-container {
        position: relative;
    }

    .gallery-images figure {
        display: none;
        text-align: center;
        align-items: center;
        justify-content: center;

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
        height: 2rem;
    }

    button.gallery-next {
        right: 0.5rem;
        height: 2rem;
    }

    .gallery-images figure img {
        max-height: var(--gallery-height);
        height: auto;
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
        transform: translateY(calc(50% + 0.5em));

    }

    .gallery-images figure {
        align-items: start;
    }

    .gallery-count {
        text-align: center;
    }
</style>

<?php if ($images->isNotEmpty()) : ?>
    <div class="gallery-container" aria-label="Image Gallery">
        <?php
        $count = $images->count();
        if ($count > 1) : ?>
            <button aria-label="Previous Image" class="gallery-prev">←</button>
            <button aria-label="Next Image" class="gallery-next">→</button>
            <div class="gallery-count" aria-live="polite">
                <span class="current">1</span><span class="total"> / <?= $count ?></span>
            </div>
        <?php endif; ?>
        <div class="gallery-images">
            <?php foreach ($images as $index => $image) : ?>
                <figure class="<?= $index === 0 ? 'active' : '' ?>">
                    <img style="max-width: 100%;" src="<?= $image->resize(500)->url() ?>" alt="<?= $image->alt()->or($page->title() . ' image') ?>" loading="lazy">
                    <figcaption><?= $image->caption()->or('') ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>