<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['matric'])) {
    header("Location: index.php");
    exit();
}

$matric = $_SESSION['matric'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];
    
    $sql = "UPDATE users SET name='$name', accessLevel='$accessLevel' WHERE matric='$matric'";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Record updated successfully";
        $_SESSION['name'] = $name;
        $_SESSION['accessLevel'] = $accessLevel;
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE matric='$matric'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Information</title>
</head>
<body>
    <div class="container">
        <h2>Update Information</h2>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="update.php" method="post">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" value="<?php echo $user['matric']; ?>" disabled>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            
            <label for="accessLevel">Access Level:</label>
            <select id="accessLevel" name="accessLevel" required>
                <option value="Student" <?php if ($user['accessLevel'] == 'Student') echo 'selected'; ?>>Student</option>
                <option value="Lecturer" <?php if ($user['accessLevel'] == 'Lecturer') echo 'selected'; ?>>Lecturer</option>
            </select>
            
            <input type="submit" value="Update">
        </form>
        <p><a href="read.php">Back to Users List</a></p>
    </div>
</body>
</html>
