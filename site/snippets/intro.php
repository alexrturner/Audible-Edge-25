<section class="project-intro-container text">

    <h1><?= $page->title() ?></h1>
    <?php if ($page->year()->isNotEmpty()) : ?>
        <h2 class="subtitle"><?= $page->subtitle() ?></h2>
    <?php endif ?>

    <?php if ($page->year()->isNotEmpty()) : ?>
        <span class="year"><?= $page->year() ?></span>
    <?php endif ?>

    <?php if ($page->credits()->isNotEmpty()) : ?>
        <ul class="credits-container">
            <?php
            $credits = $page->credits()->toStructure();
            $first = $credits->first();

            foreach ($credits as $credit) :
            ?>
                <li class="credit">
                    <div class="credit-item color-grey credit-item-a 
                    <?php if ($first) ?> credit-first">
                        <h2 class="credit-name">
                            <?php if ($credit->other_name()->isNotEmpty()) : ?>
                                <?= $credit->other_name() ?>
                            <?php endif ?>
                            <?= $credit->sort_name() ?>
                        </h2>
                    </div>
                    <div class="credit-item credit-item-b rows-2 ">
                        <?php if ($credit->role()->isNotEmpty()) : ?>
                            <span class="credit-role">
                                <?= $credit->role() ?>
                            </span>
                        <?php endif ?>

                        <?php if ($credit->group()->isNotEmpty()) : ?>
                            <span class="credit-group">
                                <?= $credit->group() ?>
                            </span>
                        <?php endif ?>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</section>