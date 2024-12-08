<?php snippet('header') ?>

<main class="content-container">
    <section class="section" id="col1">
        <h1><?= $page->title() ?></h1>
        <p><?= $page->description()->kirbytext() ?></p>
    </section>

    <section class="section team-members" id="col-team">
        <div class="cards">
            <?php foreach ($page->children()->listed() as $teamMember) : ?>

                <div class="card masonry">
                    <div class="inner">
                        <h2><?= $teamMember->title() ?></h2>
                        <span class="roles pill"><?= $teamMember->roles() ?></span>


                        <?php if ($teamMember->image()) : ?>
                            <figure>
                                <img src="<?= $teamMember->image()->url() ?>" alt="<?= $teamMember->title() ?>">
                            </figure>
                        <?php endif; ?>
                        <p><?= $teamMember->bio_short()->kirbytext() ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php snippet('footer') ?>