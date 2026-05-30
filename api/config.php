<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

try {
    $pdo = new PDO(
        "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset=utf8",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        created_at DATE NOT NULL
    )";
    $pdo->exec($sql);
    echo "✅ Table 'customers' created successfully.\n";

    // Seed data
    $insert = "INSERT IGNORE INTO customers (name, email, created_at) VALUES
        ('Tendai Moyo', 'tendai.moyo@gmail.com', '2024-01-15'),
        ('Nomsa Dlamini', 'nomsa.dlamini@gmail.com', '2024-01-20'),
        ('Chukwuemeka Banda', 'chukwuemeka.banda@gmail.com', '2024-02-03'),
        ('Aisha Mutasa', 'aisha.mutasa@gmail.com', '2024-02-18'),
        ('Sipho Nkosi', 'sipho.nkosi@gmail.com', '2024-03-01'),
        ('Rudo Chirwa', 'rudo.chirwa@gmail.com', '2024-03-10'),
        ('Bongani Sithole', 'bongani.sithole@gmail.com', '2024-03-22'),
        ('Chipo Phiri', 'chipo.phiri@gmail.com', '2024-04-05'),
        ('Tafadzwa Ncube', 'tafadzwa.ncube@gmail.com', '2024-04-18'),
        ('Lindiwe Mahlangu', 'lindiwe.mahlangu@gmail.com', '2024-05-01')
    ";
    $pdo->exec($insert);
    echo "✅ Table populated with data.\n";

} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}
?>