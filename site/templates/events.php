<?php snippet('header') ?>


<style>
    :root {
        --fs-body: var(--fs-med);
        --cc-dusk-foreground: #fa6432;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;

    }

    body {
        padding: 0 1em;
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

        letter-spacing: -0.025em;
    }

    /* nav */
    header {
        border-bottom: 1px solid #000;
        /* margin-bottom: 3em; */
        /* padding: 1.5em 0; */

        /* sticky */
        position: fixed;
        top: 0;
        left: 1em;
        right: 1em;

        z-index: 100;
        background: white;
    }

    nav {
        align-content: flex-end;
        position: absolute;
        right: 0;
        bottom: 0;
    }

    nav ul {
        display: flex;
        justify-content: flex-end;
        list-style: none;
        gap: 2rem;

    }

    nav a {
        text-decoration: none;
        color: #000;
    }

    /* program */
    .program-header {
        display: none;
    }

    .program-item {
        display: flex;
        flex-direction: column;
        padding: 1em 0;
    }



    .performers {
        display: flex;
        flex-direction: column;
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
    .performers span,
    .description,
    .show-title,
    .date,
    .time {
        /* border-bottom: 1px solid #000; */
        display: inherit;
    }


    .performers span,
    .show-title,
    .time,
    .date,
    /* .description, */
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

    /* responsive */

    /* tablet / desktop */
    @media screen and (min-width: 768px) {
        .program-header {
            display: grid;
            grid-template-columns: minmax(min-content, 1fr) 1fr 2fr 2fr;
            margin-bottom: 2em;
            color: #666;

            /* sticky */
            margin-top: 6em;
            position: absolute;
            left: 0;
            right: 0;
        }

        .program-item-container {
            margin-top: 10em;
        }

        .program-item {
            display: grid;
            grid-template-columns: 1fr 1fr 2fr 2fr;
            padding: 1em 0;
            border-bottom: none;
        }
    }

    /* mobile */
    @media screen and (max-width: 767px) {
        nav ul {
            flex-direction: column;
            align-items: center;
            gap: 1em;
        }

        .container {
            padding: 0 1em;
        }

        .descriptors {
            margin: 0.5em 0;
        }
    }

    header {
        display: grid;
        grid-template-columns: 1fr 2fr;
        min-height: 5rem;
    }

    .time,
    .date,
    .show>*:not(:last-child),
    .performers>*:not(:last-child),
    .show>*:only-child,
    .performers>*:only-child {
        background-color: #eaeaea90;
    }


    .time:hover,
    .date:hover,
    .show>*:hover,
    .performers>*:hover {
        background-color: unset;
    }

    .program-header span {
        background-color: #eaeaea;
    }

    .prefix,
    .sml {
        font-size: var(--fs-sml);
        font-size: 1rem;
    }
</style>
</head>

<body>
    <div class="container">
        <header>
            <div class="title col flex-end">
                <div class="logo-container lighten" title="Audible">
                    <?= svg('assets/img/logo-audible.svg') ?>
                </div>
            </div>
            <div class="col">
                <div class="logo-container lighten" title="Edge">
                    <?= svg('assets/img/logo-edge.svg') ?>
                </div>
            </div>
            <nav class="sml">
                <ul>
                    <li><a href="#">Program</a></li>
                    <li><a href="#">Night School</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>

            <div class="program-header sml">
                <div><span>date</span></div>
                <div><span>time</span></div>
                <div><span>show</span></div>
                <div><span>performer(s)</span></div>
            </div>
        </header>
    </div>
    <div class="program-item-container">

        <div class="program-item">
            <div>
                <span class="date">Friday, April 21</span>
            </div>
            <div>
                <span class="time">7am–8am</span>
            </div>
            <div class="show">
                <h2 class="show-title">Sun Returns</h2>
                <div class="description">
                    <span class="prefix sml">a</span>
                    <div class="descriptors">
                        <img
                            class="descriptor" data-sound="00"
                            alt="PHWOAR"
                            src="../assets/img/Swamp Icons/Swampy Icons-01.svg" />,
                        <img
                            class="descriptor" data-sound="01"
                            alt="grr"
                            src="../assets/img/Swamp Icons/Swampy Icons-02.svg" />,
                        <img
                            class="descriptor" data-sound="02"
                            alt="bang"
                            src="../assets/img/Swamp Icons/Swampy Icons-03.svg" />
                    </div>
                    show
                </div>
                <div class="venue">
                    <span class="prefix sml">at</span>
                    <span>WA Museum Boola Bardip</span>
                </div>
            </div>
            <div class="performers">
                <span>Anaxios</span>
            </div>
        </div>

        <div class="program-item">
            <div>
                <!-- <span class="date">Friday, April 21</span> -->
            </div>
            <div>
                <span class="time">10am–12pm</span>
            </div>
            <div class="show">
                <h2 class="show-title">Befores</h2>
                <div class="description">
                    <span class="prefix sml">a</span>
                    <div class="descriptors">

                        <img
                            class="descriptor" data-sound="04"
                            alt="wiggle"
                            src="../assets/img/Swamp Icons/Swampy Icons-05.svg" />,
                        <img
                            class="descriptor" data-sound="00"
                            alt="PHWOAR"
                            src="../assets/img/Swamp Icons/Swampy Icons-01.svg" />,
                        <img
                            class="descriptor" data-sound="03"
                            alt="huh"
                            src="../assets/img/Swamp Icons/Swampy Icons-04.svg" />
                    </div>
                    show
                </div>
                <div class="venue">
                    <span class="prefix sml">at</span>
                    <span>The Bird</span>
                </div>
            </div>
            <div class="performers">
                <span>Jameson Feakes</span>
                <span>Nick Ashwood [Naarm]</span>
                <span>Samuel Beilby</span>
                <span>Chi Po Hao</span>
                <span>Chloe Lin</span>
                <span>Sarah Song</span>
                <span>suzueri</span>
                <span>Shih Ya Tien</span>
                <span>Monica Brooks & Sage Pbbbt</span>
                <span>Ben & Luka Buchanan</span>
                <span>Ayo Busari DJ</span>
            </div>
        </div>
    </div>
</body>

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

</html>