<?php snippet('header') ?>
<main class="content">
    <div class="content-container index">
        <section id="col1">
            <?= $page->description() ?>
        </section>
        <section id="col3">
            <div class="donate">
                <a class="button__link" aria-label="Visit Audible Edge 2024 ACF fundraiser website" aria-type="link" href="<?= $page->link()->url() ?>"><?= $page->link_text() ?></a>
            </div>
        </section>
    </div>
</main>
<?php snippet('footer') ?>