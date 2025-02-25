<?php snippet('header') ?>
<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section id="col1" class="column a min-height">

            <div class="error-container">
                <div class="error-message">
                    <?= kt($page->description()->kirbytext()) ?>
                </div>
            </div>
        </section>
    </main>
</div>

<?php snippet('footer') ?>