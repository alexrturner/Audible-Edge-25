<?php
// arguments: parent page slug, optional class name
$parentPageSlug = $parentPageSlug ?? null;
$className = $className ?? 'listing';
$eventFilter = $eventFilter ?? null;

if ($className === 'nightschool') {
    $className = 'events';
}
if ($className === 'satellite') {
    $className = 'events';
}

if ($parentPageSlug && ($parentPage = page($parentPageSlug)) && $parentPage->hasChildren()) : ?>
    <ul class="items" id="<?= $className ?>-items">
        <?php foreach ($parentPage->children()->listed() as $child) :

            $startTime = $child->start_time();
            $endTime = $child->end_time();
            $formattedStartTime = $startTime->toDate('H:i');
            $formattedEndTime = $endTime->toDate('H:i'); ?>
            <li tabindex="0" class="<?= $className ?>-item" data-type="<?= $className ?>" data-id="<?= $child->id() ?>" data-start-time="<?= $formattedStartTime ?>" data-end-time="<?= $formattedEndTime ?>">
                <a href="<?= $child->url() ?>" class="<?= $className ?>-link">
                    <?php if ($child->display_title()->isNotEmpty()) : ?>

                        <?php foreach ($child->display_title()->toStructure() as $display) : ?>
                            <?= $display->name()->html() ?>
                            <?php if ($display->place()->isNotEmpty()) : ?>
                                <span class="artist-place serif">
                                    <sup>[<?= $display->place()->html() ?>]</sup>
                                </span>
                            <?php endif ?>
                            <?php if ($display->context()->isNotEmpty()) : ?>
                                <span class="artist-context serif">
                                    <?= $display->context()->html() ?>
                                </span>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= $child->title()->html() ?>
                    <?php endif ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>