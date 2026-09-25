<?php
// Database connection
$mysqli = new mysqli("localhost:3308", "root", "", "domain_archive");

// Check connection
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Users to insert
$users = [
    ['username' => 'ali', 'password' => 'ali123', 'role' => 'web'],
    ['username' => 'hussein', 'password' => 'hussein123', 'role' => 'mobile'],
    ['username' => 'mohamad', 'password' => 'mohamad123', 'role' => 'web']
];

// Insert users with hashed passwords
foreach ($users as $user) {
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user['username'], $hash, $user['role']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "User '{$user['username']}' created successfully.<br>";
    } else {
        echo "Failed to create user '{$user['username']}'. Possibly already exists.<br>";
    }
    $stmt->close();
}

$mysqli->close();
