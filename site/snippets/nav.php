<?php
// arguments: expanded (true/false)
$expanded = $expanded ?? "true";

?>

<style>
    header {
        /* sticky */
        position: fixed;
        top: 0;
        left: 0.5rem;
        right: 0.5rem;

        z-index: 100;


        display: grid;
        grid-template-columns: 1fr 2fr;
        min-height: 6rem;
        gap: 0.66rem;
    }

    header * {
        background-color: transparent;
    }

    nav.menu-items-container {
        align-content: flex-end;
        position: absolute;
        right: 0;
        bottom: 0;
    }

    nav.menu-items-container ul {
        display: flex;
        justify-content: flex-end;
        list-style: none;
        gap: 2rem;
        font-size: 1rem;
    }

    /* for screen sizes less than 1460px */
    @media screen and (max-width: 1460px) {
        nav.menu-items-container ul {
            gap: 1rem;
        }
    }

    .logo-container {
        width: auto;
        height: 100%;
        position: relative;
        /* max-width: 5em; */
    }

    .logo-container svg {
        width: auto;
        height: 100%;
    }

    .program-header {
        display: none;
    }

    .program-header>div {
        display: inline-block;
        width: fit-content;
    }

    /* desktop */
    @media screen and (min-width: 768px) {
        .program-header {
            display: grid;
            grid-template-columns: minmax(min-content, 1fr) 1fr 2fr 2fr;
            /* margin-bottom: 2em; */
            /* color: #666; */

            /* sticky */
            margin-top: 6em;
            position: absolute;
            left: 0;
            right: 0;
            top: 10em;
            margin-bottom: 0;
            pointer-events: none;
        }
    }

    /* mobile */
    @media screen and (max-width: 767px) {
        header {
            position: relative;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 3em;


            left: unset;
            right: unset;
            margin-left: 0.5;
            margin: 0;
            width: auto;
            min-height: 2rem;
            width: calc(100% - 2em);
            margin-left: 0.5em;

            /* ?? */
            margin-bottom: 2em;

        }

        nav.menu-items-container ul {
            flex-direction: column;
            align-items: end;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
    }

    #mode-desktop {
        display: none;
    }
</style>

<header>
    <div class="title col flex-end">
        <div class="logo-container" title="Audible">
            <a href="<?= $site->url() ?>" aria-label="Home">
                <?= svg('assets/img/logo-audible.svg') ?>
            </a>
        </div>
        <div class="mode-container">
            <span id="mode-desktop" class="gap mode">high contrast</span>

            <label class="switch">
                <input
                    type="checkbox"
                    id="toggle-mode" />
                <span class="slider round interact inverted"></span>
            </label>
        </div>
    </div>
    <div class="col">
        <div class="logo-container title--edge" title="Edge">
            <a href="<?= $site->url() ?>" aria-label="Home">
                <?= svg('assets/img/logo-edge.svg') ?>
            </a>
        </div>
    </div>

    <?php $expanded = "false"; ?>


    <div class="menu-header-container">
        <button class="menu-toggle toggle pseudo-list-item" aria-expanded="<?= $expanded ?>" aria-controls="menu-items" aria-label="Toggle Menu">
            Menu
        </button>

        <nav class="menu-items-container">

            <ul class="menu-items items <?php e($expanded === "true", "", "hidden__visibility"); ?>" id="menu-items">

                <?php
                date_default_timezone_set('Australia/Perth');

                if (strtotime('now') < strtotime('2025-02-26 18:00:00')): ?>
                    <li><a href="/program/program-launch" class="lighten">Program Launch</a></li>
                    <li><a href="/donate" class="lighten">Donate</a></li>

                <?php else: ?>

                    <li class="lighten menu-item"><a href="/about" class="lighten menu-link">About</a></li>
                    <li class="lighten menu-item"><a href="/accessibility" class="lighten menu-link">Accessibility</a></li>
                    <li class="lighten menu-item"><a href="/acknowledgements" class="lighten menu-link">Acknowledgements</a></li>

                    <?php foreach ($site->children()->listed() as $p) : ?>
                        <li class="lighten menu-item">
                            <a <?php e($p->isOpen(), 'aria-current="page"') ?> href="<?= $p->url() ?>" class="lighten menu-link<?php e($p->isOpen(), ' active') ?>">
                                <?= $p->title()->esc() ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </nav>

        <?php
        if ($page->parent()) :
            snippet('pagination-event');
        endif ?>
    </div>


    <?php if ($page->uid() === "program" || $page->uid() === "nightschool") : ?>
        <div class="program-header sml">
            <div class="lighten">date</div>
            <div class="lighten">time</div>
            <div class="lighten">show</div>
            <div class="lighten">presenter(s)</div>
        </div>
    <?php endif ?>
</header>