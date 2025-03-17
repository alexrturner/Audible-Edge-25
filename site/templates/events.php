<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>

    <?php snippet('events-listings', ['parentPageSlug' => 'program']) ?>
</div>

<script>
    class SoundPlayer {
        constructor() {

            // store
            this.audioElements = {};

            // number of prompts
            const nPrompts = 16;

            // array of prompt numbers
            const promptNumbers = Array.from({
                length: 16
            }, (_, i) => i.toString().padStart(2, '0'));

            // init
            this.soundMap = {};
            this.currentIndex = {};

            this.soundMap = {
                '00': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '00')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '01': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '01')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '02': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '02')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '03': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '03')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '04': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '04')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '05': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '05')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '06': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '06')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '07': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '07')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '08': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '08')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '09': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '09')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '10': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '10')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '11': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '11')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '12': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '12')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '13': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '13')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '14': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '14')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '15': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '15')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
                '16': this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                            ->filterBy('promptnumber', '16')
                                            ->filterBy('approved', 'true')
                                            ->pluck('url')) ?>),
            };


            // available sounds
            // console.log('sound map :', this.soundMap);

            this.currentIndex = {}
            // for (let i = 0; i <= nPrompts; i++) {
            //     const promptNumber = i.toString().padStart(2, '0');
            //     this.currentIndex[promptNumber] = 0;
            // }

            this.currentIndex = {
                '00': 0,
                '01': 0,
                '02': 0,
                '03': 0,
                '04': 0,
                '05': 0,
                '06': 0,
                '07': 0,
                '08': 0,
                '09': 0,
                '10': 0,
                '11': 0,
                '12': 0,
                '13': 0,
                '14': 0,
                '15': 0,
                '16': 0,
            };

            this.preloadAudio();
            this.initEventListeners();

            // autoplay
            this.hasShownAutoplayWarning = localStorage.getItem('hasShownAutoplayWarning') === 'true';
            this.autoplayAllowed = false;
            this.checkAutoplayCapability();
        }

        async checkAutoplayCapability() {
            try {
                // create test audio e
                const audio = new Audio();
                audio.src = "data:audio/mpeg;base64,SUQzBAAAAAAAI1RTU0UAAAAPAAADTGF2ZjU4LjI5LjEwMAAAAAAAAAAAAAAA//tQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAACAAADQABERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERE//sQZAAP8AAAaQAAAAgAAA0gAAABAAABpAAAACAAADSAAAAETEFNRTMuMTAwVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//sQZB4P8AAAaQAAAAgAAA0gAAABAAABpAAAACAAADSAAAAEVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV";

                await audio.play();
                this.autoplayAllowed = true;
                audio.remove();
            } catch (err) {
                this.autoplayAllowed = false;
                if (!this.hasShownAutoplayWarning) {
                    this.showAutoplayWarning();
                }
            }
        }

        showAutoplayWarning() {
            localStorage.setItem('hasShownAutoplayWarning', 'false');
            this.hasShownAutoplayWarning = false;

            if (this.hasShownAutoplayWarning) return;

            const popup = document.createElement('div');
            popup.style.cssText = `
                position: fixed;
                top: 20%;
                left: 50%;
                transform: translateX(-50%);
                background: var(--cc-highlight-background);
                color: var(--cc-highlight-foreground);
                padding: 12px 24px;
                border-radius: 4px;
                font-size: 1.5rem;
                z-index: 1000;
                max-width: 50ch;
                transition: opacity 0.3s ease-in-out;
                opacity: 0;
            `;

            popup.innerHTML = `<p>This site contains audio elements.</p><p>Please enable autoplay in your browser settings.</p>`;


            document.body.appendChild(popup);
            // fade in after 2 seconds
            setTimeout(() => {
                popup.style.opacity = '1';
            }, 1000);

            localStorage.setItem('hasShownAutoplayWarning', 'true');
            this.hasShownAutoplayWarning = true;


            // fade oot
            setTimeout(() => {
                popup.style.opacity = '0';
                setTimeout(() => {
                    popup.remove();
                }, 300);
            }, 5000);
        }

        preloadAudio() {
            // foreachsoundtype
            Object.entries(this.soundMap).forEach(([soundType, urls]) => {
                // console.log(`preloading ${urls.length} sounds for type ${soundType}`);

                //  hold audio elements for this sound type
                this.audioElements[soundType] = urls.map(url => {
                    const audio = new Audio(url);
                    audio.preload = 'auto';
                    return audio;
                });
            });
        }

        shuffleArray(array) {
            // console.log('shuffling sounds', array);
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        playSound(soundType) {
            const sounds = this.audioElements[soundType];
            if (!sounds || !sounds.length) {
                console.error(`??? no sounds found for ${soundType}`);
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
            // console.log(`${icons.length} descriptor icons`);

            icons.forEach(icon => {



                const playAudio = (e) => {
                    // closest e handles event bubbling
                    const descriptorElement = e.target.closest('.descriptor');
                    if (!descriptorElement) {
                        console.error('No descriptor element found');
                        return;
                    }

                    const soundType = descriptorElement.dataset.sound;
                    if (!soundType || !this.soundMap[soundType]) {
                        console.error('Invalid sound type:', soundType);
                        return;
                    }

                    this.playSound(soundType);
                };

                // Always add click handler
                icon.addEventListener('click', playAudio);
                icon.addEventListener('mouseover', playAudio);


            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.soundPlayer = new SoundPlayer();
    });
</script>

<?php snippet('footer') ?>