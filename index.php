<?php declare(strict_types=1);

require_once "vendor/autoload.php";

use App\GiphyApiClient;
use App\Models\GiphyGif;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$defaultTag = "Happy day";
$tag = $_GET['tag'] ?? $defaultTag;
$giphyApiClient = new GiphyApiClient();
$giphyGifs = $giphyApiClient->getGifs($tag);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Best GIFS</title>
</head>
<body>
<div class="container">
    <div>
        <h1>Best gifs here</h1>
        <div class="links">
            <a href="/?tag=Cars">Cars</a>
            <a href="/?tag=Sports">Sports</a>
            <a href="/?tag=Programming">Programming</a>
        </div>
        <form class="form" action="" method="get">
            <label>
                <input type="text" placeholder="Tag...." name="tag">
            </label>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="gif-container">
        <div class="list-container">
            <?php
            if ($giphyGifs != null) {
                echo "<ul>";
                foreach ($giphyGifs as $gif) {
                    /** @var GiphyGif $gif */
                    echo '<li><img src="' . $gif->getUrl() . '" alt="' . $gif->getName() . '"></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Error: No gifs found. Please try again</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>