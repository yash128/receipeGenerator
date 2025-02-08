<?php
session_start();
include 'db.php'; // Connect to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Hashing the password

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "success";
        $_SESSION['username'] = $username;
        header('Location: index.php'); // Redirect to a dashboard or home page
    } else {
        echo "Invalid login credentials!";
    }
}
?>
