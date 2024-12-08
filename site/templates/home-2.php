<?php snippet('header') ?>

<style>
    .homepage__dates .pseudo-list-item::before,
    .homepage__tag.pseudo-list-item::before,
    .header .pseudo-list-item::before {
        color: var(--cc-orange-highlight);
        color: lightgrey;
        opacity: 0.7;
    }

    body {
        overflow-y: hidden;
    }

    .audio-intro-container button {
        border: none;
    }

    .audio-intro-container:hover #visual-aid:not(.active) {
        background-color: var(--cc-primary);
    }

    .audio-intro-container #visual-aid {
        width: 1rem;
        height: 1rem;
    }

    .ae-title {
        display: flex;
        /* justify-content: center;
        align-items: center; */

        width: min-content;
        white-space: initial;
        z-index: 100;
        font-weight: normal;
    }

    .content-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
        margin: 0;
    }


    .homepage__menu-header-container {
        position: fixed;
        top: 50%;
        left: 1em;
        z-index: 100;
    }

    svg {
        width: 100%;
        height: 100%;
    }

    .logo,
    .svg-dots {
        height: auto;
        width: 100%;
    }

    #audio-buttons-container {
        display: block !important;
        position: relative;
        /* max-width: 60rem; */
    }

    .audio-button audio {
        display: none;
    }

    #svg-container {
        width: 100%;
        height: 100%;

    }

    .logo-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width: 768px) {
        .logo-container {
            display: block !important;
        }
    }

    #audio-buttons-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .audio-button,
    .audio-intro-button {
        pointer-events: auto;
        position: absolute;
        z-index: 15;
        line-height: 1;
        display: flex !important;
        justify-content: center;
        align-content: center;
    }

    .audio-button {
        /* transition: all 0.3s ease; */
        animation-fill-mode: forwards;
    }

    .audio-button:hover {
        background-color: var(--cc-olive-highlight);
    }

    @keyframes shake {
        0% {
            transform: translate(0, 0) rotate(0);
        }


        50% {
            transform: translate(-5px, 0) rotate(-5deg);
        }


        100% {
            transform: translate(0, 0) rotate(0);
        }
    }

    .content-container {
        /* height: auto; */
        /* position: relative; */
        max-height: fit-content;
    }

    .audio-intro-container {
        position: absolute;
        bottom: 0;
        pointer-events: auto !important;
    }

    #menu {
        position: fixed;
        right: 1em;
        width: fit-content;
    }

    /* 
    SVG colours and opacity 
    */
    .cls-1,
    .cls-2,
    .cls-3 {
        opacity: 1 !important;
    }

    svg#lineCanvas path,
    svg#lineCanvas polyline {
        fill: var(--cc-olive);
        stroke: var(--cc-squig-colour) !important;
    }

    .cls-3 {
        fill: var(--cc-orange) !important;
        /* animation: fill 2s linear infinite; */
    }

    svg path.cls-2 {
        /* fill: var(--cc-olive-light) !important; */
        opacity: 0.8 !important;
        animation: fill 12s linear infinite;
    }

    .cls-1 {
        /* fill: var(--cc-purple-highlight) !important; */
        /* opacity: 0.2; */
        stroke: var(--cc-olive) !important;
        /* stroke: var(--cc-purple-highlight) !important; */
    }

    @keyframes fill {
        0% {
            fill: var(--cc-olive-highlight);
        }

        50% {
            fill: var(--cc-olive-light);
        }

        100% {
            fill: var(--cc-olive-highlight);
        }
    }

    @-moz-keyframes fill {
        0% {
            fill: var(--cc-olive-highlight);
        }

        50% {
            fill: var(--cc-olive-light);
        }

        100% {
            fill: var(--cc-olive-highlight);
        }
    }

    /* overrides circle-button width & height */
    .audio-button {
        width: 1rem;
        height: 1rem;
        background-color: var(--cc-primary);
    }

    .audio-button-text {
        position: absolute;
        transform: translateY(0.5em);
    }

    .svg-dots {
        position: absolute;
        visibility: hidden;
    }

    .homepage__tag,
    .homepage__dates {
        position: absolute;
        display: flex;
        flex-direction: column;
        z-index: 1;
    }

    .ae-title {
        position: fixed;
        top: 10%;
        /* left: 19%; */
        /* top: 8%; */
        left: 14%;
        left: 23%;

        font-size: var(--fs-big);
        line-height: 0.85;
        letter-spacing: -0.06em;
    }

    .homepage__dates {
        top: 20%;
        /* right: 20%; */
        right: 23%;
        padding: 1rem;
        font-size: 1.5rem;
        color: var(--cc-olive);
        align-items: end;
        font-size: var(--fs-big);
        line-height: 0.85;
        letter-spacing: -0.06em;
    }

    .homepage__tag {
        bottom: 10%;
        right: 15%;
        padding: 1rem;
        font-size: 1.5rem;
        color: var(--cc-olive);
        font-size: var(--fs-big);
        line-height: 0.85;
        letter-spacing: -0.06em;
    }

    .countdown-container {
        position: absolute !important;
        top: 2em;
        right: 1.5em;
        font-family: var(--ff-serif);
        font-style: italic;
        color: var(--cc-olive-light);
        opacity: 0.75;
    }

    .plain-text-container {
        position: fixed !important;
        /* right: 0.3em !important;
         */
        top: unset !important;
        left: 1em !important;
        bottom: 0.5em !important;
    }

    .pseudo-list-item {
        padding: 0;
    }

    #subtitles {
        background-color: var(--cc-olive-highlight);
        z-index: 10000;
    }

    #subtitles .full-transcription {
        display: none;
    }

    #subtitles,
    .audio-intro-container {
        position: fixed;
        z-index: 1;
    }

    .audio-intro-container {
        bottom: 1rem;
    }

    .audio-intro-text {
        font-size: var(--fs-med);
        font-family: var(--ff-serif);
        font-style: italic;
    }

    #subtitles {
        bottom: 3rem;
        left: 25%;
        width: 50%;
        z-index: 10000;
        font-family: var(--ff-serif);
        padding: 0.25em 1.5em;
        padding-left: 3em;
    }

    #subtitles .current-speaker {
        font-style: italic;
        color: var(--cc-olive-light);
        position: absolute;
        left: 1em;
    }

    @media (max-width: 769px) {

        /* // todo: fun with long mobile */
        /* 
        #lineCanvas {
            display: block !important;
            position: relative;
        }

        #lineCanvas {
            height: 500em;
        } */

        .plain-text-container {
            left: 0.3em !important;
        }

        .homepage__dates,
        #svg-container,
        #lineCanvas,
        #lineCanvas-container {
            position: fixed;
        }

        .audio-intro-container {
            bottom: 4rem;
        }

        .audio-intro-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-left: 0em;
        }

        .homepage__tag {
            top: 33%;
            /* top: 28%; */
            bottom: unset;
            right: 1rem;
            font-size: 2.5rem;
            font-size: var(--fs-med);
            letter-spacing: 0;
            line-height: 0.95;
        }

        #lineCanvas-container,
        #dots,
        #audio-buttons-container {
            height: 300vh;
            height: clamp(3000px, 300vh, 6000px);
        }

        #audio-buttons-container {
            left: 20%;
            width: 80%;
        }

        body {
            overflow-y: visible;
        }


        .ae-title {
            position: fixed;
            top: 20%;
            left: 1rem;
            pointer-events: none;
        }

        .homepage__dates {
            top: 10%;
            right: 1rem;
            pointer-events: none;
        }

        #subtitles {
            width: calc(100% - 5em);
            bottom: 8rem;
            left: 1em;
        }
    }

    .countdown-container {
        top: 0.5rem;
        width: 100%;
        text-align: center;
        right: unset;
        pointer-events: auto;
    }

    @media (min-width: 768px) {
        #settingsContainer {
            position: absolute;
            bottom: 0.25rem;
            left: 6em;
            width: max-content;
            width: 200px;
            height: max-content;
            z-index: 0;

        }

        #dragHandle {
            width: 20px;
            pointer-events: auto;
            height: 20px;
            background-color: darkgrey;
            position: absolute;
            bottom: 0;
            left: 0;
            cursor: grab;
            z-index: 100;
        }
    }
</style>

<div class="homepage__menu-header-container menu-header-container-global">
    <?php
    $expanded = "true";
    ?>
    <button class="menu-toggle toggle pseudo-list-item" aria-expanded="<?= $expanded ?>" aria-controls="menu-items" aria-label="Toggle Menu">Menu</span></button>
    <br><br>

    <ul class="menu-items <?php e($expanded === "true", "", "hidden"); ?>" id="menu-items">
        <?php foreach ($site->children()->listed() as $p) : ?>
            <li class="menu-item">
                <a <?php e($p->isOpen(), 'aria-current="page"') ?> href="<?= $p->url() ?>" class="menu-link<?php e($p->isOpen(), ' active') ?>">
                    <?= $p->title()->esc() ?>
                </a>
            </li>
        <?php endforeach ?>

    </ul>
</div>

<div class="homepage__tag pseudo-list-item section__subtitle">
    <span>a Festival of </span>
    <span>Exploratory Music</span>
    <span>presented by</span>
    <span>Tone List on</span>
    <span>Whadjuk Noongar</span>
    <span>Boodja</span>
</div>

<div class="homepage__dates">
    <span class="hidden">Festival Dates:</span>
    <span class="pseudo-list-item">April </span><span>26–28</span>
</div>

<main class="content-container">
    <div id="svg-container" class="logo-container desktop" style="display: none;">
        <div id="dots" class="svg-dots">
            <?php $dots = $site->files()->template('ae_homepage_dot_svg');
            foreach ($dots as $dot) : ?>
                <?= $dot->read() ?>
            <?php endforeach; ?>
        </div>

        <?php
        $logoFiles = $site->files()->template('ae_logo');
        $index = 0;
        foreach ($logoFiles as $file) :
        ?>
            <div class="logo" id="logo-<?= $index ?>" style="<?= $index > 0 ? 'display: none;' : '' ?>">
                <?= $file->read() ?>
            </div>
        <?php
            $index++;
        endforeach;
        ?>
    </div>

    <div id="audio-buttons-container" style="display: none;">
        <?php $index = 0; ?>
        <?php foreach ($site->files()->template('audio_custom') as $audio) : ?>
            <button class="audio-button circle-button" id="audio-btn-<?= $index ?>" data-audio="<?= $audio->url() ?>" aria-controls="audio-<?= $index ?>" aria-label="Play '<?= htmlspecialchars($audio->audio_category()) ?>' sound">
                <span class="audio-button-text"><?= $audio->audio_category() ?></span>
                <audio id="audio-<?= $index ?>" src="<?= $audio->url() ?>"></audio>
            </button>

            <?php $index++; ?>
        <?php endforeach; ?>
    </div>

    <div class="audio-intro-container">

        <?php $index = 0; ?>
        <?php foreach ($site->files()->template('audio_intro') as $intro_audio) : ?>
            <button onclick="playPauseIntro(this)" data-audio="audio-intro-<?= $index ?>" aria-label="Play introduction audio" aria-controls="audio-intro-<?= $index ?>">
                <div id="visual-aid" class="audio-intro-button circle-button" data-audio="audio-intro-<?= $index ?>"></div>
                <div class="audio-intro-text">
                    <span> Click for an audio introduction</span><span> to this website.</span>
                </div>
            </button>

            <audio style="display: block;" id="audio-intro-<?= $index ?>" class="audio-intro" src="<?= $intro_audio->url() ?>" controls></audio>


            <?php $index++; ?>
        <?php endforeach; ?>
    </div>
    <div id="subtitles" class="hidden">
        <div class="full-transcription">
            <?= kt($site->audio_intro_transcription()) ?>
        </div>
    </div>
</main>

<?= js('assets/js/save-the-date.js') ?>
<?= js('assets/js/ae24-audio-svg.js') ?>
<?= js('assets/js/subtitles.js') ?>

<?php snippet('footer') ?>