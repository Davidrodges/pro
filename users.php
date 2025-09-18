<?php
// users.php
include 'config.php'; // your DB connection file

$sql = "SELECT name FROM users ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $i = 1;
    echo "<h3>Registered Users</h3>";
    echo "<ol>"; // ordered list for auto-numbering
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . htmlspecialchars($row['name']) . "</li>";
        $i++;
    }
    echo "</ol>";
} else {
    echo "No users found.";
}
?>
