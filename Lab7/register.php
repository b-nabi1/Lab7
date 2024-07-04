<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="accessLevel">Access Level:</label>
            <select id="accessLevel" name="accessLevel" required>
                <option value="Student">Student</option>
                <option value="Lecturer">Lecturer</option>
            </select>
            
            <input type="submit" name="register" value="Register">
        </form>
        <button onclick="window.location.href='index.php'">Go to Login</button>
    </div>
</body>
</html>

<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $accessLevel = $_POST['accessLevel'];
    
    $sql = "INSERT INTO users (matric, name, password, accessLevel) VALUES ('$matric', '$name', '$password', '$accessLevel')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>
