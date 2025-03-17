<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>
    <main class="content-container">
        <section id="col1" class="column a min-height">
            <div class="content">
                <h1 class="section-title lighten"><?= $page->title() ?></h1>
            </div>
            <div class="row">
                <h2 class="title lighten">Contact</h2>

                <ul class="reviews lighten">
                    <li><a href="mailto:<?= $site->email() ?>">Email</a></li>
                    <?php
                    $socials = $site->socials()->toStructure();
                    foreach ($socials as $social): ?>
                        <li><a href="<?= $social->link() ?>"><?= $social->text() ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </section>

        <section id="col2" class="column b description">
            <div class="content lighten">
                <?= kt($page->description()) ?>
            </div>

            <div class="content lighten">
                <?php
                $team = page('team');
                if ($team->description()->isNotEmpty()): ?>
                    <div class="description">
                        <?= kt($team->description()) ?>
                    </div>
                <?php endif ?>

                <?php
                $teammembers = $team->children()->listed();

                if ($teammembers->count()): ?>
                    <ul class="team-members">
                        <?php foreach ($teammembers as $member): ?>
                            <li class="team-member">
                                <?= $member->title() ?>
                                <?php if ($member->roles()->isNotEmpty()): ?>
                                    <sub class="roles">[<?= $member->roles() ?>]</sub>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        </section>

    </main>
</div>

<?php snippet('footer') ?>