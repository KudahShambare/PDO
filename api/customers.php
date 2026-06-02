<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Records</title>
    <link rel="stylesheet" href="/api/styles.css">
</head>

<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env locally only
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$host   = $_ENV['DB_HOST']   ?? getenv('DB_HOST');
$dbname = $_ENV['DB_NAME']   ?? getenv('DB_NAME');
$user   = $_ENV['DB_USER']   ?? getenv('DB_USER');
$pass   = $_ENV['DB_PASS']   ?? getenv('DB_PASS');
$port   = $_ENV['DB_PORT']   ?? getenv('DB_PORT') ?: '3306';

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

$statement = $pdo->prepare('SELECT * FROM customers ORDER BY id');
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
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
            <td><?= htmlspecialchars($customer['id']) ?></td>
            <td><?= htmlspecialchars($customer['name']) ?></td>
            <td>
                <a href="mailto:<?= htmlspecialchars($customer['email']) ?>">
                    <?= htmlspecialchars($customer['email']) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($customer['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>