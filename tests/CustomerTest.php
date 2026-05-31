<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class CustomerTest extends TestCase
{
    private $pdo;

    // Runs before each test
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $this->pdo = new PDO(
            "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset=utf8",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // 1. Test DB connects
    public function testDatabaseConnection()
    {
        $this->assertInstanceOf(PDO::class, $this->pdo);
    }

    // 2. Test table exists
    public function testCustomersTableExists()
    {
        $stmt = $this->pdo->query("SHOW TABLES LIKE 'customers'");
        $result = $stmt->fetch();
        $this->assertNotFalse($result, "customers table does not exist");
    }

    // 3. Test fetching all customers returns array
    public function testFetchAllCustomers()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM customers ORDER BY id');
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertIsArray($customers);
        $this->assertNotEmpty($customers);
    }

    // 4. Test fetching single customer by id
    public function testFetchCustomerById()
    {
        $id = 1;
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($customer);
        $this->assertEquals(1, $customer['id']);
        $this->assertArrayHasKey('name', $customer);
        $this->assertArrayHasKey('email', $customer);
    }

    // 5. Test search by name
    public function testSearchByName()
    {
        $search = '%Moyo%';
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE name LIKE :name');
        $stmt->bindParam(':name', $search, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($results);
        $this->assertStringContainsString('Moyo', $results[0]['name']);
    }

    // 6. Test customer has valid email format
    public function testCustomerEmailIsValid()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM customers');
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($customers as $customer) {
            $this->assertMatchesRegularExpression(
                '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                $customer['email'],
                "Invalid email: {$customer['email']}"
            );
        }
    }

    // 7. Test fetching non existent customer returns false
    public function testFetchNonExistentCustomer()
    {
        $id = 99999;
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($customer);
    }
}