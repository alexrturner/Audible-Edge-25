// <script>
class SoundPlayer {
    constructor() {
        console.log('Initializing SoundPlayer...');


        // console.log('All files:', <?= json_encode(site()->files()->pluck('url')) ?>);
        // console.log('Sound Uploads:', <?= json_encode(page('storage')->files()->filterBy('template', 'upload')->pluck('url')) ?>);

        // store
        this.audioElements = {};

        // Get all sounds from PHP
        const allSounds = <?= json_encode(
                                page('storage')->files()->filterBy('template', 'upload')->reduce(function ($sounds, $file) {
                                    $promptNumber = $file->promptnumber()->value();
                                    if ($promptNumber) {  // Only add if promptNumber exists
                                        if (!isset($sounds[$promptNumber])) {
                                            $sounds[$promptNumber] = [];
                                        }
                                        $sounds[$promptNumber][] = $file->url();
                                    }
                                    return $sounds;
                                }, [])
                            ) ?> || {}; // Provide empty object as fallback



        // init soundMap
        this.soundMap = {};
        this.currentIndex = {};


        // Process each sound type
        // Process each sound type (with null check)
        if (allSounds && typeof allSounds === 'object') {
            Object.entries(allSounds).forEach(([promptNumber, urls]) => {
                if (urls && urls.length > 0) {
                    this.soundMap[promptNumber] = this.shuffleArray(urls);
                    this.currentIndex[promptNumber] = 0;
                }
            });
        }

        // Log available sounds
        console.log('Sound Map:', this.soundMap);

        // Preload audio elements
        this.preloadAudio();
        this.initializeEventListeners();
    }

    preloadAudio() {
        // For each sound type
        Object.entries(this.soundMap).forEach(([soundType, urls]) => {
            console.log(`Preloading ${urls.length} sounds for type ${soundType}`);

            // Create array to hold audio elements for this sound type
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

        // Stop any currently playing sound of this type
        sounds.forEach(audio => {
            audio.pause();
            audio.currentTime = 0;
        });

        const currentAudio = sounds[this.currentIndex[soundType]];
        console.log(`Playing sound from URL: ${currentAudio.src}`);

        // Add error handling
        currentAudio.play().catch(error => {
            console.error('Error playing audio:', error);
        });

        // Move to next sound, loop back to start if at end
        this.currentIndex[soundType] = (this.currentIndex[soundType] + 1) % sounds.length;
    }

    initializeEventListeners() {
        const icons = document.querySelectorAll('.descriptor');
        console.log(`Found ${icons.length} descriptor icons`);

        icons.forEach(icon => {
            icon.addEventListener('click', (e) => {
                const soundType = e.target.dataset.sound;
                console.log(`Icon clicked! Sound type: ${soundType}`);

                if (this.soundMap[soundType]) {
                    this.playSound(soundType);
                } else {
                    console.error(`No sound map found for type: ${soundType}`);
                }
            });
        });
    }
}

// Initialize the sound player when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing SoundPlayer...');
    window.soundPlayer = new SoundPlayer();
});
</script>