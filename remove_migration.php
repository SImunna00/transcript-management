<?php

// This script removes a specific migration entry from the migrations table

require 'vendor/autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create a database connection
$host = env('DB_HOST', 'localhost');
$database = env('DB_DATABASE', 'forge');
$username = env('DB_USERNAME', 'forge');
$password = env('DB_PASSWORD', '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete the migration entry
    $stmt = $pdo->prepare("DELETE FROM migrations WHERE migration = ?");
    $migrationName = '2025_07_11_000002_add_parent_names_to_users_table';
    $stmt->execute([$migrationName]);

    $count = $stmt->rowCount();
    if ($count > 0) {
        echo "Successfully removed migration entry: $migrationName\n";
    } else {
        echo "Migration entry not found: $migrationName\n";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
