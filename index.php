<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "1234";
$dbname     = "pro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Ensure users table exists
$tableCheck = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($tableCheck);

class MyClass {
    public function heading() {
        echo "<h2>Welcome to My Application!</h2>";
    }

    public function signupForm() {
        echo '
        <h3>Sign Up</h3>
        <form method="POST" action="">
            Name: <input type="text" name="name" required><br><br>
            Email: <input type="email" name="email" required><br><br>
            <input type="submit" name="signup" value="Sign Up">
        </form>
        ';
    }

    public function userList($conn) {
        echo "<h3>Registered Users</h3>";
        $sql = "SELECT name FROM users ORDER BY name ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<ol>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . htmlspecialchars($row['name']) . "</li>";
            }
            echo "</ol>";
        } else {
            echo "No users found.";
        }
    }

    public function footer() {
        echo "<footer>Contact us at <a href='mailto:info@bbit.edu'>info@bbit.edu</a></footer>";
    }
}

// Create an instance of MyClass
$instance = new MyClass();

// Handle signup + email validation
if (isset($_POST['signup'])) {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format!";
    } else {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $name, $email);
            try {
                $stmt->execute();

                // Send welcome email (suppress warning with @)
                $subject = "Welcome to Our Application!";
                $message = "Hello " . htmlspecialchars($name) . ",\n\nWelcome to our application!";
                $headers = "From: no-reply@yourapp.com\r\n";

                if (@mail($email, $subject, $message, $headers)) {
                    echo "✅ User registered & welcome email sent to " . htmlspecialchars($email);
                } else {
                    echo "⚠️ User registered, but email could not be sent (SMTP not configured).";
                }
            } catch (Exception $e) {
                echo "⚠️ Error: " . $e->getMessage();
            }
        } else {
            echo "⚠️ Failed to prepare SQL statement.";
        }
    }
}

// Display content
$instance->heading();
$instance->signupForm();
$instance->userList($conn);
$instance->footer();

$conn->close();
?>
