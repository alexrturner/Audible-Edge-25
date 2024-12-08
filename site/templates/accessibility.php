<?php snippet('header') ?>

<main class="main content-container index">
    <section id="col1" class="intro" style="max-width: 60ch;">
        <?= kt($page->intro()) ?>
    </section>

    <section id="col2" class="description" style="max-width: 60ch;">
        <?= kt($page->description()) ?>
    </section>

    <section id="col3" class="form" style="max-width: 60ch;">

        <?= kt($page->form()) ?>

        <form method="post" action="<?= $page->url() ?>">
            <div class="honeypot" style="position: absolute; left: -9999px;">
                <label for="website">Website <abbr title="required">*</abbr></label>
                <input type="url" id="website" name="website" tabindex="-1">
            </div>
            <div class="field-group">
                <div class="field half">
                    <input type="text" id="name" name="name" value="<?= esc($data['name'] ?? '', 'attr') ?>" placeholder="Name">
                    <?= isset($alert['name']) ? '<span class="alert error">' . esc($alert['name']) . '</span>' : '' ?>
                </div>
                <div class="field half">
                    <input type="text" id="pronouns" name="pronouns" value="<?= esc($data['pronouns'] ?? '', 'attr') ?>" placeholder="Pronouns">
                    <?= isset($alert['pronouns']) ? '<span class="alert error">' . esc($alert['pronouns']) . '</span>' : '' ?>
                </div>
            </div>
            <div class="field-group">
                <div class="field half">
                    <input type="email" id="email" name="email" value="<?= esc($data['email'] ?? '', 'attr') ?>" placeholder="eMail">
                    <?= isset($alert['email']) ? '<span class="alert error">' . esc($alert['email']) . '</span>' : '' ?>
                </div>
                <div class="field half">
                    <input type="tel" id="phone" name="phone" value="<?= esc($data['phone'] ?? '', 'attr') ?>" placeholder="Phone">
                    <?= isset($alert['phone']) ? '<span class="alert error">' . esc($alert['phone']) . '</span>' : '' ?>
                </div>
            </div>
            <div class="field">
                <textarea id="text" name="text" placeholder="Request" required><?= esc($data['text'] ?? '') ?></textarea>

                <?= isset($alert['text']) ? '<span class="alert error">' . esc($alert['text']) . '</span>' : '' ?>
            </div>
            <div>
                <button class="button__link button__submit" type="submit">Get in Touch</button>
            </div>
        </form>


        <?php

        // DB connection from environment variables
        require 'vendor/autoload.php';

        use Dotenv\Dotenv;

        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            date_default_timezone_set('Australia/Perth');

            $name = ($_POST["name"]);
            $pronouns = ($_POST["pronouns"]);
            $phone = ($_POST["phone"]);
            $email = ($_POST["email"]);
            $text = ($_POST["text"]);
            $submitted_at = date('Y-m-d H:i:s');

            // database connection parameters

            $host = $_ENV['DB_HOST'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            $database = $_ENV['DB_DATABASE'];
            $usertable = 'accessibility_requests';

            $conn = mysqli_connect($host, $username, $password, $database);

            // check connection
            if ($conn === false) {
                die("Error: could not connect. " . mysqli_connect_error());
            }


            $sql = "INSERT INTO $usertable (name, pronouns, email, phone, text, submitted_at) VALUES ('$name', '$pronouns', '$email', '$phone', '$text', '$submitted_at');";

            // retrieve and display feedback messages
            $successMessage = $page->dbSuccessMessage()->kirbytext();
            $errorMessage = $kirby->site()->dbErrorMessage()->kirbytext();

            if (mysqli_query($conn, $sql)) {
                echo '<div class="form-container">' . $successMessage . '</div>';
            } else {
                echo '<div class="form-container">' . $errorMessage . '</div>' . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
        ?>
    </section>
</main>

<?php snippet('footer') ?>