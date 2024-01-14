<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jookebox";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginEmailOrMobile = $_POST["login_email_or_mobile"];
    $loginPassword = $_POST["login_password"];

    $checkUserQuery = "SELECT * FROM users WHERE email = '$loginEmailOrMobile' OR mobile = '$loginEmailOrMobile'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

    
        if (password_verify($loginPassword, $user["password"])) {
            $_SESSION["user_email"] = $user["email"];
            $loginMessage = "Login successful!";
        } else {
            $loginMessage = "Incorrect password";
        }
    } else {
        $loginMessage = "User not found";
    }
}

$conn->close();
?>

