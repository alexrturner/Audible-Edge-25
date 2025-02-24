<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section id="col1" class="column a min-height">
            <div class="content">
                <h1 class="section-title lighten"><?= $page->title() ?></h1>
                <div class="signup">
                    <span>Sign-up to the</span>
                    <a href="<?= $page->link_email()->url() ?>" class="button__link" aria-label="Visit Email Newsletter sign up" aria-type="link">
                        Email Newsletter
                    </a>
                </div>
            </div>
        </section>

        <section id="col2" class="column b description">
            <div class="content lighten">
                <?= kt($page->Description()) ?>
            </div>
        </section>

    </main>
</div>

<?php snippet('footer') ?>