<?php snippet('header') ?>


<style>
    :root {
        --cc-dusk-foreground: #fa6432;
    }

    @media screen and (min-width: 768px) {
        :root {
            --fs-body: var(--fs-med);
        }
    }

    body {
        /* padding: 0 1em; */
        overflow-x: hidden;
    }

    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        font-weight: 400;
        font-size: var(--fs-body);
    }

    .program-item {
        display: flex;
        flex-direction: column;
        padding: 1em 0;
    }

    .artists {
        display: flex;
        flex-direction: column;
    }

    /* erebus */
    .descriptors {
        display: inline-flex;
        gap: 0.6em;
    }

    .descriptors img {
        width: auto;
        cursor: pointer;
        height: var(--fs-body);
        scale: 2;
    }

    .descriptors img:hover {
        transform: scale(1.5);
    }

    /* underline border */
    .artists span,
    .description,
    .event-title,
    .date,
    .time {
        /* border-bottom: 1px solid #000; */
        display: inherit;
    }


    .artists>*,
    .event-title,
    .time,
    .date,
    .venue {
        /* centred vs baseline */
        /* padding: 0.5em 0; */
        padding-top: 1rem;
    }

    .descriptors {
        padding-top: 0.6em;
    }

    span.prefix {
        margin-right: 2ch;
    }

    .container {
        /* padding: 0 1em;
        padding: 0 0.5em; */
        padding: 0 0.5rem;
    }


    /* responsive */

    /* tablet / desktop */
    @media screen and (min-width: 768px) {
        .program-item-container {
            margin-top: 10em;
        }

        .program-item {
            display: grid;
            grid-template-columns: 1fr 1fr 2fr 2fr;
            padding: 1em 0;
            border-bottom: none;
        }

        /* distinct columns */
        .date,
        .time,
        .venue {
            padding-right: 0.5em;
        }
    }

    /* mobile */
    @media screen and (max-width: 767px) {

        .descriptors {
            margin: 0.5em 0;
        }

        .program-item>div:not(:first-child) {
            margin-left: 2em;
        }

        /* .time::before {
            content: "*";
            position: absolute;
            transform: translateX(-2em);
        } */
    }

    /* hover state */
    /* desktop */
    @media screen and (min-width: 768px) {

        .time,
        .date,
        .event>*:not(:last-child),
        .artists>*:not(:last-child),
        .event>*:only-child,
        .artists>*:only-child {
            /* background-color: #eaeaea90; */
        }

        .event>.lighten:last-child {
            background-color: unset;
        }

        /* .time:hover, */
        /* .date:hover, */
        .event>*:hover,
        .artists>*:hover {
            background-color: unset;
        }
    }

    .tooltip {
        position: fixed;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        pointer-events: none;
        z-index: 100;
        display: none;
    }
</style>

<div class="container">
    <?php snippet('nav') ?>

    <?php snippet('events') ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create a single tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        document.body.appendChild(tooltip);

        // Add event listeners to all descriptors
        document.querySelectorAll('.descriptor').forEach(img => {
            img.addEventListener('mousemove', (e) => {
                tooltip.style.display = 'block';
                tooltip.textContent = img.dataset.tooltip;
                // Position tooltip near cursor with offset
                tooltip.style.left = e.pageX + 10 + 'px';
                tooltip.style.top = e.pageY + 10 + 'px';
            });

            img.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });
    });
</script>

<script>
    class SoundPlayer {
        constructor() {

            // console.log('All files:', <?= json_encode(site()->files()->pluck('url')) ?>);
            // console.log('Sound Uploads:', <?= json_encode(page('storage')->files()->filterBy('template', 'upload')->pluck('url')) ?>);

            // store
            this.audioElements = {};

            // array of prompt numbers (max 20?)
            const promptNumbers = Array.from({
                length: 21
            }, (_, i) => i.toString().padStart(2, '0'));

            // init
            this.soundMap = {};
            this.currentIndex = {};

            // todo ... brute force
            this.soundMap = {
                '00': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '00')
                                            ->pluck('url')) ?>),
                '01': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '01')
                                            ->pluck('url')) ?>),
                '02': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '02')
                                            ->pluck('url')) ?>),
                '03': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '03')
                                            ->pluck('url')) ?>),
                '04': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '04')
                                            ->pluck('url')) ?>),
                '05': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '05')
                                            ->pluck('url')) ?>),
            };

            // available sounds
            // console.log('sound map :', this.soundMap);

            this.currentIndex = {
                '00': 0,
                '01': 0,
                '02': 0,
                '03': 0,
                '04': 0,
                '05': 0,
            };

            // preload audio elements
            this.preloadAudio();
            this.initEventListeners();
        }

        preloadAudio() {
            // foreachsoundtype
            Object.entries(this.soundMap).forEach(([soundType, urls]) => {
                console.log(`Preloading ${urls.length} sounds for type ${soundType}`);

                //  hold audio elements for this sound type
                this.audioElements[soundType] = urls.map(url => {
                    const audio = new Audio(url);
                    audio.preload = 'auto';
                    return audio;
                });
            });
        }

        shuffleArray(array) {
            console.log('Shuffling array:', array);
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        playSound(soundType) {
            console.log(`Attempting to play sound type: ${soundType}`);

            const sounds = this.audioElements[soundType];
            if (!sounds || !sounds.length) {
                console.error(`No sounds found for type: ${soundType}`);
                return;
            }

            // stop! sounds of this type
            // sounds.forEach(audio => {
            //     audio.pause();
            //     audio.currentTime = 0;
            // });

            // stop! all of the sounds
            Object.values(this.audioElements).forEach(audioArray => {
                audioArray.forEach(audio => {
                    audio.pause();
                    audio.currentTime = 0;
                });
            });

            const currentAudio = sounds[this.currentIndex[soundType]];
            // console.log(`playing: ${currentAudio.src}`);

            currentAudio.play().catch(error => {
                console.error('Error playing audio:', error);
            });

            // next sound or loop back
            this.currentIndex[soundType] = (this.currentIndex[soundType] + 1) % sounds.length;
        }

        initEventListeners() {
            const icons = document.querySelectorAll('.descriptor');
            // console.log(`Found ${icons.length} descriptor icons`);

            icons.forEach(icon => {
                icon.addEventListener('mouseover', (e) => {
                    const soundType = e.target.dataset.sound;
                    // console.log(`Icon sound type = ${soundType}`);

                    if (this.soundMap[soundType]) {
                        this.playSound(soundType);
                    } else {
                        console.error(`! Error: no sound map for type: ${soundType}`);
                    }
                });
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.soundPlayer = new SoundPlayer();
    });
</script>

<?php snippet('footer') ?>