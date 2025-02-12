<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section id="col1" class="column a contact">
            <div class="signup">
                <a href="<?= $page->link_email()->url() ?>" class="button__link" aria-label="Visit Email Newsletter sign up" aria-type="link">
                    Email Newsletter
                </a>
            </div>
            <div class="signup">
                <a href="signup" class="button__link" aria-label="Visit SMS Newsletter sign up" aria-type="link">
                    SMS Newsletter
                </a>
            </div>
            <div class="signup contact-container">

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