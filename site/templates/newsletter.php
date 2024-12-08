<?php snippet('header') ?>

<main>
    <section class="text">
        <div class="signup">
            <a href="<?= $page->link_email()->url() ?>">Sign up for our Email Newsletter</a>
        </div>
        <div class="signup">
            <a href="<?= $page->link_sms()->url() ?>">Sign up for our SMS Newsletter</a>
        </div>
    </section>
</main>
<?php snippet('footer') ?>