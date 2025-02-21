<?php snippet('header') ?>

<div class="container">
    <?php snippet('nav') ?>

    <?php snippet('events-listings', ['parentPageSlug' => 'nightschool']) ?>
</div>

<script>
    // tooltip
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        document.body.appendChild(tooltip);

        // event listeners to all descriptors
        document.querySelectorAll('.descriptor').forEach(img => {
            img.addEventListener('mousemove', (e) => {
                tooltip.style.display = 'block';
                tooltip.textContent = img.dataset.tooltip;

                tooltip.style.left = e.pageX + 10 + 'px';
                tooltip.style.top = e.pageY + 10 + 'px';
            });

            img.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });
    });

    // sound player
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

            for (let i = 0; i <= nPrompts; i++) {
                const promptNumber = i.toString().padStart(2, '0');
                this.soundMap[promptNumber] = this.shuffleArray(<?= json_encode(page('storage')->files()->filterBy('template', 'upload')
                                                                    ->filterBy('promptnumber', "' + promptNumber + '")
                                                                    ->pluck('url')) ?>);
            }


            // available sounds
            // console.log('sound map :', this.soundMap);

            this.currentIndex = {}
            for (let i = 0; i <= nPrompts; i++) {
                const promptNumber = i.toString().padStart(2, '0');
                this.currentIndex[promptNumber] = 0;
            }


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