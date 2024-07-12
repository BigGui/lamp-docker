<?php

require __DIR__ . '/vendor/autoload.php';
include 'includes/_functions.php';
include 'includes/_templates.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dbCo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8',
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );
    $dbCo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Unable to connect to the database. ' . $e->getMessage());
}

$text = 'Hello World!!!!!';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= loadAssets(['js/main.js', 'js/component.js']) ?>
</head>

<body>
    <h1>
        <?php
        echo $text;
        ?>
    </h1>
    <ul>
        <?php

        $query = $dbCo->prepare("SELECT article_name, purchase_price FROM article;");

        if ($query->execute()) {
            echo implode(array_map('getHtmlProduct', $query->fetchAll()));
        }
        ?>
    </ul>
</body>

</html>