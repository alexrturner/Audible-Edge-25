<?php snippet('header') ?>

<main class="main content-container index">
    <section id="col1" class="intro" style="max-width: 60ch;">
        <p>
            <?= kt($page->description()) ?>
        </p>
    </section>
    <section id="col2" class="description" style="max-width: 60ch;">
        <details>
            <summary>
                <?= $page->privacy_title() ?>
            </summary>
            <?= kt($page->privacy_text()) ?>
        </details>
    </section>
    <section id="col3" class="form">
        <div class="sms_form">
            <form method="post" action="<?= $page->url() ?>">
                <div class="field-group">
                    <div class="field">
                        <input type="text" id="name" name="name" required placeholder="Preferred Name">
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <input type="tel" id="number" name="number" required placeholder="Phone">
                    </div>
                </div>
                <div>
                    <button class="button__link button__submit" type="submit">Submit</button>
                </div>
            </form>
            <?php

            // DB connection from environment variables
            require 'vendor/autoload.php';

            use Dotenv\Dotenv;
            use Kirby\Cms\App;

            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = ($_POST["name"]);
                $number = ($_POST["number"]);
                $dateAdded = date('Y-m-d H:i:s');

                // database connection parameters
                $host = $_ENV['DB_HOST'];
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];
                $database = $_ENV['DB_DATABASE'];
                $usertable = 'users';


                $conn = mysqli_connect($host, $username, $password, $database);

                // Check connection
                if ($conn === false) {
                    die("Error: could not connect. " . mysqli_connect_error());
                }

                $sql = "INSERT INTO $usertable (name, phone, date_added) VALUES ('$name', '$number', '$dateAdded');";

                // retrieve and display feedback messages
                $successMessage = $kirby->site()->dbSuccessMessage()->kirbytext();
                $errorMessage = $kirby->site()->dbErrorMessage()->kirbytext();

                if (mysqli_query($conn, $sql)) {
                    echo '<div class="form-container">' . $successMessage .
                        '</div>';
                } else {
                    echo '<div class="form-container">' . $errorMessage . '</div>' . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
            ?>
        </div>
    </section>
</main>
<?php snippet('footer') ?>