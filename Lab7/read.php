<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['matric'])) {
    header("Location: index.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $sql = "DELETE FROM users WHERE matric='$matric'";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

// Fetch users
$sql = "SELECT matric, name, accessLevel FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Users List</title>
</head>
<body>
    <div class="container">
        <h2>Users List</h2>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Access Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['matric'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['accessLevel'] . "</td>";
                        echo "<td><a href='update.php?matric=" . $row['matric'] . "'>Edit</a> | <a href='read.php?delete=" . $row['matric'] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
