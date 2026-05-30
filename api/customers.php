




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Records</title>
   <link rel="stylesheet" href="./styles.css">



</head>

<?php

// cONNECT tO db

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// After $dotenv->load()
if (empty($_ENV['DB_HOST'])) {
    die('DB_HOST not set. Check .env file location and syntax.');
}

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$port = $_ENV['DB_PORT'];


try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}


//rETRIEVE rECORDS

  $statement = $pdo->prepare('SELECT * FROM customers ORDER BY id');
    $statement->execute();
    $customers = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= $customer['id'] ?></td>
            <td><?= $customer['name'] ?></td>
            <td>
                <a href="mailto:<?= $customer['email'] ?>">
                    <?= $customer['email'] ?>
                </a>
            </td>
            <td><?= $customer['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>




</html>







