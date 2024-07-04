<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="index.php" method="post">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" name="login" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

<?php
session_start();
include 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];
    
    
    
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['matric'] = $row['matric'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['accessLevel'] = $row['accessLevel'];
            header("Location: read.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this matric.";
    }
    
    $conn->close();
}
?>
