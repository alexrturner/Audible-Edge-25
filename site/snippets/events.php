<section class="events">
    <ul>
        <?php foreach ($page->children()->listed() as $event) : ?>
            <li class="event">
                <a href="<?= $event->url() ?>">
                    <?php if ($event->title()->isNotEmpty()) : ?>
                        <span><?= $event->title()->esc() ?></span>
                    <?php endif ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</section>