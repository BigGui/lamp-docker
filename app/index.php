<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dbCo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=sdbm;charset=utf8',
        'root',
        'root_password'
    );
    $dbCo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Unable to connect to the database. ' . $e->getMessage());
}


$query = $dbCo->prepare("SELECT article_name, purchase_price FROM article;");

$query->execute();

$result = $query->fetchAll();


$text = 'Hello World!!!!!';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
if ($_ENV['ENV_TYPE'] === 'dev') {
    // Developement integration for vite with run dev
    ?>
<script type="module" src="http://localhost:5173/@vite/client"></script>
<script type="module" src="http://localhost:5173/js/main.js"></script>
    <?php
}
else if ($_ENV['ENV_TYPE'] === 'prod') {
    // Production integration for vite with run build

}
    ?>
</head>

<body>
    <h1>
        <?php
        echo $text;
        ?>
    </h1>
    <ul>

        <?php



        foreach ($result as $beer) {
            echo '<li>' . $beer['article_name'] . '  vendu au prix de ' . $beer['purchase_price'] . '</li>';
        }
        ?>
    </ul>
</body>

</html>