<?php
// add_admin.php
require_once "db.php"; // DB connection file

// Change as needed
$name     = "System Admin";
$email    = "admin@gmail.com";
$password = "1234"; // plaintext
$role_id  = 1; // assuming role_id=1 is 'Admin' in roles table
$department_id = 1; // admin may not belong to a department
$phone   = 030000000; // or 1, depending on schema
$created_at = date("Y-m-d H:i:s");

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Prepare query
$sql = "INSERT INTO users ( full_name, email,phone, password, role, created_at) 
        VALUES ( ?, ?, ?, ?, 'admin', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiss", $name, $email,$phone, $password_hash, $created_at);

if ($stmt->execute()) {
    echo "✅ Admin user added successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
