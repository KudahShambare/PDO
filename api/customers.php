




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
    
    echo "✅ Connected successfully!"; // 👈 add this

} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}


//rETRIEVE rECORDS

$customers = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => '2024-01-15'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'created_at' => '2024-01-20'],
    ['id' => 3, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'created_at' => '2024-02-03'],
    ['id' => 4, 'name' => 'Bob Brown', 'email' => 'bob@example.com', 'created_at' => '2024-02-18'],
    ['id' => 5, 'name' => 'Charlie Wilson', 'email' => 'charlie@example.com', 'created_at' => '2024-03-01'],
    ['id' => 6, 'name' => 'Diana Prince', 'email' => 'diana@example.com', 'created_at' => '2024-03-10'],
    ['id' => 7, 'name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'created_at' => '2024-03-22'],
    ['id' => 8, 'name' => 'Fiona Gallagher', 'email' => 'fiona@example.com', 'created_at' => '2024-04-05'],
    ['id' => 9, 'name' => 'George Costanza', 'email' => 'george@example.com', 'created_at' => '2024-04-18'],
    ['id' => 10, 'name' => 'Hannah Baker', 'email' => 'hannah@example.com', 'created_at' => '2024-05-01'],
];

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







